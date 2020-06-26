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
        #$this->userController = new UserController();
        $this->user = new User();
        $this->faq = new FAQ();
        $this->tatto = new Tattoo();
        $this->local = new Local();
        $this->session = false;
    }

    public function view($html, $variable) {
        $session = $this->session();
        $user = $_SESSION["id_user"];
        //$permissions = $this->userController->is;
        $artists = $this->user->listArtists($this->id_local);
        $local = $this->local->getTxt($this->id_local);
        return view($html, compact('session', 'artists', 'local', 'user', 'variable'));
    }

    public function index() {
        return $this->view('index.views',null);
    }

    public function updPhotos() {
        return $this->view('upload.photos', null);
    }

    public function listTattoos() {
        //$variable["tattoos"] = 'algun sql de recoleccion de tattoos';#$this->user->listArtists($this->generalController->getIdLocal());

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $quantity = 9; //Cant de fotos por pág
        $beginning = ($page > 1) ? (($page * $quantity) - $quantity) : 0;
        $tattoos = new Tattoo;
        $totalTattoos = $tattoos->countTattoos();
        if ($totalTattoos > 0) {
            if ($totalTattoos > 9) {
                $variable['total_pages'] = ceil($totalTattoos['total'] / $quantity);
            }
            $variable["tattoos"] = $tattoos->getTattoos($beginning, $quantity);
        }
        return $this->view('list.tattoos', $variable);
    }

    public function viewTattoo() {
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
        if (!isset($_SESSION)) {
            session_start();
        }
        if (isset($_SESSION["id_user"])) {
            $this->session = true;
        } else {
            $this->session = false;
        }
        return $this->session;
    }

    public function getIdLocal() {
        return $this->id_local;
    }
}
