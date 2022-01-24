<?php

namespace App\Controllers;

use App\Controllers\GeneralController;
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
    }

    public function listFaq() {
        $variable = array();
        $variable["faqs"] = $this->faq->listFaq();
        return $this->view('faq/list.faqs', $variable);
    }

    public function increaseFaq($id_faq) {
        $this->faq->newVisit( $id_faq );
        $faq = $this->faq->find($id_faq);
        return $faq["visits"];
    }

    public function buscarFaq() {
        session_start();
        $salida = "";

        $query = "SELECT * FROM faq";

        if (isset($_POST['val'])) {
            if ($_POST['val'] == 'MorePopular'){
                $query = "SELECT * FROM faq order by visits desc";
            }else if (($_POST['val'] == 'LessPopular')){
                $query = "SELECT * FROM faq order by visits asc";
            }else if(($_POST['val'] == 'MoreRecent')){
                $query = "SELECT * FROM faq order by id_faq desc";
            }else if(($_POST['val'] == 'LessRecent')){
                $query = "SELECT * FROM faq order by id_faq asc";
            }
        }
        $faqs = $this->faq->select( $query );
        if ( count( $faqs ) > 0) {
            $salida.="<div class='questions__accordions' id='content'>";

            foreach ( $faqs as $faq ) {
                $salida.="
				<div class='question-answer__accordion'>
					<div class='question'>
						<h3 class='title__question'>
							" . $faq['question'] . "
						</h3>
						<img src='/public/images/icon-arrow-down.svg' >
					</div>
					<div class='answer'>
						<p class='answer-block'> " . $faq['answer'] . " </p>
						<p class='answer-block'> " . $faq['summary'] . " </p>
						<p class='answer-block visits'> Total de visitas: " . $faq['visits'] . " </p>";
                if (isset( $_SESSION["id_user"] ) ) {
                    $id_usar = $_SESSION["id_user"];
                    if ( $this->isAdministrator( $id_usar ) ) {
                        $salida.= "
                        <section class='manage-faqs'>
                            <form method='get' id='edit-faq-" . $faq['id_faq'] . "' action='/edit_faq/" . $faq['id_faq'] . "'>
                                <input type='hidden' name='id_faq' value=" . $faq['id_faq'] . ">
                                <button class='table-button editBtn' type='submit' form='edit-faq-" . $faq['id_faq'] . "'>Editar</button>
                            </form>
    
                            <form method='get' id='destroy-faq-" . $faq['id_faq'] . "' action='/del_faq/" . $faq['id_faq'] . "' onSubmit='return confirm('Desea eliminar la pregunta?');'>
                                <input type='hidden' name='id_faq' value=" . $faq['id_faq'] . ">
                                <button class='table-button deleteBtn' type='submit' form='destroy-faq-" . $faq['id_faq'] . "'>Borrar</button>
                            </form>
                        </section>";
                    }
                }
                $salida.= "</div></div>";
            }
            $salida.= "</div>";
        } else {
            $salida.= "No hay FAQs registradas hasta el momento";
        }

        return $salida;
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