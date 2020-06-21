<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;

class UserController extends Controller
{
    private $id_local = '1';

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
        $status = array_shift($array);
        if ($status) {     #si salio bien la validacion
            $variable["parameters"] = $array;
        } else {
            $variable["errors"] = $array;
        }
        return $this->generalController->view('register', $variable);   #ver si hacer esto o mandar una view dependiendo del resultado
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

    public function listuser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function viewUser() {
        return view();#'list.appointments', compact('appointments'));
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
        $result = $this->user->autentication($id_user, $password);
        if ($result['count(*)'] == 1) { #obvio que esto no deberian ser var_dump
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
        $this->session = false;
        return $this->generalController->view('index.views', null);
    }

    public function parameters() {
        $parameters = array();
        if (isset($_POST["id_user"])) {
            $parameters["user"] = $_POST["id_user"];
        }
        if (isset($_POST["password"])) {
            $parameters["password"] = $_POST["password"];
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
        if (isset($_POST["photo"])) {
            $parameters["photo"] = $_FILES;
        }
        if (isset($_POST["artist"])) {
            $parameters["artist"] = true;
        }
        if (isset($_POST["id_local"])) {
            $parameters["local"] = $_POST["id_local"];
        }
        if (isset($_POST["txt"])) {
            $parameters["txt"] = $_POST["txt"];
        }
        return $parameters;
    }
}