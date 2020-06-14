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
    }

    public function index() {
        session_start();
        $session = $_SESSION;
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        return view('index.views', compact('session', 'artists', 'local'));
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
        session_start();
        $faq = new FAQ();
        $faq = $faq->listFaq();
        $session = $_SESSION;
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        return view('faq', compact('session', 'artists', 'faq', 'local'));
    }

    //la idea es pasar el id por parametro, y hacer una query que lleve a una vista
    //esa vista va a mostrar la descripcion de esa pregunta
    public function viewFaq($id_faq) {
        session_start();
        $session = $_SESSION;
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        $id = ['id' => $id_faq];
        $faq = new FAQ();
        $faq = $faq->find($id_faq); // aca va el select con where y el id
        return view('faq.views', compact('faq'));
    }

    public function listTerms(){
        session_start();
        $session = $_SESSION;
        $artists = $this->user->listArtist();
        return view('terms.and.conditions');
    }

    public function session() {
        if (isset($_SESSION["id_user"])) {
            $session = true;
        } else {
            $session = false;
        }
        return $session;
    }
}
