<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;
use App\models\Tattoo;
use App\models\FAQ;
use App\models\Local;

class GeneralController extends Controller
{
    private $id_local = '1';

    public function __construct()
    {
        $this->user = new User();
        $this->faq = new FAQ();
        $this->tatto = new Tattoo();
        $this->local = new Local();
        $this->session = false;
    }

    public function view($html, $variable) {
        $session = $this->session();
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        return view($html, compact('session', 'artists', 'local', 'variable'));
    }

    public function index() {
        return $this->view('index.views',null);
    }

    public function listTattoo() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function viewTattoo() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function listArtist() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function viewArtist() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function listFaq() {
        $variable = array();
        $faqs = new FAQ();
        $variable["faqs"] = $faqs->listFaq();
        return $this->view('faq', $variable);
    }

    //la idea es pasar el id por parametro, y hacer una query que lleve a una vista
    //esa vista va a mostrar la descripcion de esa pregunta
    public function viewFaq($id_faq) {
        $id = ['id' => $id_faq];
        $faq = new FAQ();
        $variable = array();
        $variable["faq"] = $faq->find($id_faq); // aca va el select con where y el id
        return $this->view('faq.views', $variable);
    }

    public function listTerms(){
        return view('terms.and.conditions');
    }

    public function session() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $this->session = true;
        } else {
            $this->session = false;
        }
        return $this->session;
    }
}
