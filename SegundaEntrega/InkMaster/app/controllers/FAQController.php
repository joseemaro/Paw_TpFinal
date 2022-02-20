<?php

namespace App\Controllers;

use App\Controllers\GeneralController;
use App\Core\App;
use App\models\FAQ;
use App\models\Local;
use App\models\User;

class FAQController extends GeneralController
{
    public function __construct()
    {
        $this->user = new User();
        $this->faq = new FAQ();
        $this->local = new Local();
        $this->id_local = $this->local->getLocal();
        $this->session = false;
        $this->logger = App::get('logger');
    }

    public function listFaq() {
        $variable = array();
        $variable["faqs"] = $this->faq->listFaqOrder( "MoreRecent" );
        $this->faq->genSeoJsonFaq($variable);
        return $this->view('faq/list.faqs', $variable);
    }

    public function increaseFaq($id_faq) {
        $this->faq->newVisit( $id_faq );
        $faq = $this->faq->find($id_faq);
        return $faq["visits"];
    }

    public function buscarFaq( $val = 'MorePopular' ) {
        $faqs = $this->faq->listFaqOrder( $val );

        $faqs_order = array();
        if ( count( $faqs ) > 0) {
            $i = 1;
            foreach ( $faqs as $faq ) {
                $faqs_order[$i] = $faq['id_faq'];
                $i++;
            }
        }

        $administrator = false;
        if (isset( $_SESSION["id_user"] ) ) {
            $id_usar = $_SESSION["id_user"];
            if ($this->isAdministrator($id_usar)) {
                $administrator = true;
            }
        }

        $response['faqs'] = $faqs_order;
        $response['isAdministrator'] = $administrator;
        return json_encode( $response );
    }

    public function delFaq($id_faq){
        $this->faq->delFaq($id_faq);
        $variable["faqs"] = $this->faq->listFaq();
        return $this->view('faq/list.faqs', $variable);
    }

    public function editFaq($id_faq){
        $variable["faq"] = $this->faq->find($id_faq);
        return $this->view('faq/edit.faq', $variable);
    }

    public function addFaq(){
        return $this->view('faq/new.faq', null);
    }

    public function saveFaq(){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user= $_SESSION["id_user"];
            $parameters["answer"]= $_POST['answer'];
            $parameters["question"]= $_POST['question'];
            $parameters["summary"]= $_POST['summary'];
            $parameters["visits"]= 0;
            if ($this->user->havePermissions($id_user, 'faq.edit')) {

                $this->faq->newFaq($parameters);

                $variable["faqs"] =$this->faq->listFaq();
                return $this->view('faq/list.faqs', $variable);
            }
        }
        return $this->view('not_found');
    }

    public function updFaq(){
        session_start();
        if ( isset( $_SESSION["id_user"] ) ) {
            $id_user = $_SESSION["id_user"];
            $id_faq = $_POST['id_faq'];
            $parameters["answer"] = $_POST['answer'];
            $parameters["question"] = $_POST['question'];
            $parameters["summary"] = $_POST['summary'];
            if ( $this->user->havePermissions( $id_user, 'faq.edit' ) ) {
                $status =  $this->faq->updateFaq( $id_faq, $parameters );

                if ( $status ) {
                    $variable["faqs"] = $this->faq->listFaq();
                    return $this->view( 'faq/list.faqs', $variable );
                }
            }
        }
        return $this->view( 'not_found' );
    }

}