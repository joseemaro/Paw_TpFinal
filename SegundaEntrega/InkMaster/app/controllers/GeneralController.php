<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;
use App\models\Tattoo;
use App\models\FAQ;
use App\models\Local;

class GeneralController extends Controller
{

    public function __construct()
    {
        $this->user = new User();
        $this->faq = new FAQ();
        $this->tatto = new Tattoo();
        $this->local = new Local();
        $this->session = false;
        $this->id_local = $this->local->getLocal();
    }

    public function view($html, $variable) {
        $session = $this->session();
        $isArtist = true;
        $artists = $this->user->listArtists($this->id_local);
        $local = $this->local->getTxt($this->id_local);
        if (isset($_SESSION["id_user"])) {
            $user = $_SESSION["id_user"];
            return view($html, compact('session', 'artists', 'local', 'user', 'isArtist', 'variable'));
        }
        return view($html, compact('session', 'artists', 'local', 'isArtist', 'variable'));
    }

    public function index() {
        return $this->view('index.views',null);
    }

    public function updPhotos() {
        return $this->view('upload.photos', null);
    }

    public function savePhotos() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->isArtist($id_user)) {
                $parameters["artist"] = $id_user;
                if (isset($_POST["sector"])){
                    $parameters["sector"] = $_POST["sector"];
                }
                if (isset($_FILES)){
                    $parameters["image"] = $_FILES;
                }
                $parameters["txt"] = $_POST["description"];
                var_dump($parameters);
                $array = $this->tatto->validateInsert($parameters);
                echo '<br>';
                var_dump($array);
                $status = $array[count($array)-1];
                if ($status) {
                    #si salio bien la validacion
                    return $this->view('upload.photos', null);   #ver si hacer esto o mandar una view dependiendo del resultado
                } else {
                    $variable["errors"] = $array;
                    return $this->view('errors.register', $variable);
                }
            }
            return $this->view('not_found', null);
        }
        return $this->view('not_found', null);
    }

    public function listTattoos() {
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $quantity = 9; //Cant de fotos por pág
        $beginning = ($page > 1) ? (($page * $quantity) - $quantity) : 0;
        $totalTattoos = $this->tatto->countTattoos();
        if ($totalTattoos > 0) {
            if ($totalTattoos > $quantity) {
                $variable["total_pages"] = ceil($totalTattoos['total'] / $quantity);
                $variable["page"] = $page;
            }
            $variable["tattoos"] = $this->tatto->getTattoos($beginning, $quantity);
        }
        return $this->view('list.tattoos', $variable);
    }

    public function viewTattoo() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function listFaq() {
        $variable = array();
        $variable["faqs"] = $this->faq->listFaq();
        return $this->view('faq', $variable);
    }

    //la idea es pasar el id por parametro, y hacer una query que lleve a una vista
    //esa vista va a mostrar la descripcion de esa pregunta
    public function viewFaq($id_faq) {
        $id = ['id' => $id_faq];
        $variable = array();
        $variable["faq"] = $this->faq->find($id_faq); // aca va el select con where y el id
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

    public function isArtist($id_user) {
        return true;
    }

    public function isAdmin($id_user) {
        return true;
    }
}
