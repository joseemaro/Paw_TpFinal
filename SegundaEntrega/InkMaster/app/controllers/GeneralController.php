<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Appointment;
use App\models\User;
use App\models\Tattoo;
use App\models\FAQ;
use App\models\Local;

class GeneralController extends Controller
{

    public function __construct()
    {
        $this->user = new User();
        $this->local = new Local();
        $this->id_local = $this->local->getLocal();
        $this->appointment = new Appointment();
        $this->session = false;
    }

    public function view($html, $variable = null, $isArtist = null) {
        $session = $this->session();
        $artists = $this->user->listArtists($this->id_local);
        $local = $this->local->getTxt($this->id_local);
        if (isset($_SESSION["id_user"])) {
            $user = $_SESSION["id_user"];
            $isArtist = $this->isArtist($user);
            $isAdministrator = $this->isAdministrator($user);
            $notifications_count = $this->appointment->notifications_count( $user, $isArtist );
            return view($html, compact('session', 'artists', 'local', 'user', 'notifications_count', 'isArtist', 'isAdministrator', 'variable'));
        }
        return view($html, compact('session', 'artists', 'local', 'isArtist', 'variable'));
    }

    public function index() {
        return $this->view('index.views');
    }

    public function updMedRec($id_user, $medical){
        return $this->user->updMedRec('medical_record' ,$id_user, $medical);
    }

    public function listTerms(){
        return view('terms.and.conditions');
    }

    public function parameters() {
        $boolean = true;
        $parameters["artist"] = $_SESSION["id_user"];
        if (isset($_POST["sector"])){
            $parameters["sector"] = $_POST["sector"];
        } else {
            $boolean = false;
        }
        if (isset($_FILES)){
            $parameters["image"] = $_FILES;
        } else {
            $boolean = false;
        }
        if (isset($_POST["description"])) {
            $parameters["txt"] = $_POST["description"];
        } else {
            $boolean = false;
        }
        if ($boolean) {
            return $parameters;
        } else {
            return false;
        }
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
        return $this->user->isArtist($id_user, $this->id_local);
    }

    public function isAdministrator($id_user) {
        return $this->user->isAdmin($id_user, $this->id_local);
    }

}
