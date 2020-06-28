<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;

class UserController extends Controller
{

    public function __construct()
    {
        $this->user = new User();
        $this->generalController = new GeneralController();
        $this->session = false;
    }

    public function index()
    {
        return view();#'index.views');
    }

    public function saveUser() {
        $array = $this->user->validateInsert($this->parameters());
        $status = $array[count($array)-1];
        if ($status) {
            #si salio bien la validacion
            $variable["parameters"] = $array;
            return $this->generalController->view('register', $variable);   #ver si hacer esto o mandar una view dependiendo del resultado
        } else {
            $variable["errors"] = $array;
            return $this->generalController->view('errors.register', $variable);
        }
    }

    public function editUser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function uptUser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function delUser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function listUsers() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->isAdmin($id_user)) {
                $variable["artists"] = $this->user->listUsers();
                return $this->generalController->view('list.users', $variable);
            }
            return $this->generalController->view('not_found', null);
        }
        return $this->generalController->view('not_found', null);
    }

    public function viewUser($id_user) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            if ($this->isAdmin($_SESSION["id_user"])) {
                $user = $this->user->findUser($id_user);
                $user["photo"] = base64_encode($user["photo"]);
                $variable["user"] = $user;
                return $this->generalController->view('view.user', $variable);
            }
            return $this->generalController->view('not_found', null);
        }
        return $this->generalController->view('not_found', null);
    }

    public function listArtists() {
        $variable["artists"] = $this->user->listArtists($this->generalController->getIdLocal());
        return $this->generalController->view('list.artists', $variable);
    }

    public function viewArtist($id_artist) {
        $variable["artist"] = $this->user->findArtist($id_artist);
        return $this->generalController->view('view.artist', $variable);
    }

    public function register() {
        return $this->generalController->view('register', null);
    }

    public function logIn() {
        return $this->generalController->view('login', null);
    }

    public function autentication() {
        $session = null;
        $id_user = $_POST["id_user"];
        $password = $_POST["password"];
        $result = $this->user->autentication(str_replace(" ", "_", $id_user), $password);
        if ($result) { #obvio que esto no deberian ser var_dump
            $variable["msgWelcome"] = "bienvenido $id_user ! ";
            session_start();
            $_SESSION["id_user"] = $id_user;
        } else {
            $variable["msgWelcome"] = "usuario inválido";
        }
        return $this->generalController->view('index.views', $variable);
    }

    public function logOut() {
        session_start();
        $_SESSION = array();
        return $this->generalController->view('index.views', null);
    }

    public function parameters() {
        $parameters = array();
        if (isset($_POST["id_user"])) {
            $parameters["user"] = str_replace(" ", "_", $_POST["id_user"]);
        }
        if (isset($_POST["password"])) {
            $parameters["password"] = $_POST["password"];
        }
        if (isset($_POST["confirm_password"])) {
            $parameters["confirm_password"] = $_POST["confirm_password"];
        }
        if (isset($_POST["first_name"])) {
            $parameters["first_name"] = $_POST["first_name"];
        }
        if (isset($_POST["last_name"])) {
            $parameters["last_name"] = $_POST["last_name"];
        }
        if (isset($_POST["born"])) {
            $parameters["born"] = $_POST["born"];
        }
        if (isset($_POST["nro_doc"])) {
            $parameters["nro_doc"] = $_POST["nro_doc"];
        }
        if (isset($_POST["phone"])) {
            $parameters["phone"] = $_POST["phone"];
        }
        if (isset($_POST["direction"])) {
            $parameters["direction"] = $_POST["direction"];
        }
        if (isset($_POST["email"])) {
            $parameters["email"] = $_POST["email"];
        }
        if (isset($_FILES)) {
            $parameters["photo"] = $_FILES;
        }
        if (isset($_POST["artist"])) {
            $parameters["artist"] = true;
            $parameters["local"] = $this->generalController->getIdLocal();
            if (isset($_POST["txt"])) {
                $parameters["txt"] = $_POST["txt"];
            }
        }
        return $parameters;
    }

    public function isAdmin($id_user) {
        return true;
    }
}