<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
    }

    public function index()
    {
        return view();#'index.views');
    }

    public function newUser() {
        return view('register');
    }

    public function saveUser() {
        $msg = $this->user->newUser($_POST);
        if ($msg == "Correcto") {
            return view('register');
        } else {
            return view('register', compact('msg'));
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

    public function listuser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function viewUser() {
        return view();#'list.appointments', compact('appointments'));
    }

    public function register() {
        return view('register');
    }

    public function logIn() {
        return view('login');
    }

    public function find() {
        $session = null;
        $id_user = $_POST["id_user"];
        $password = $_POST["password"];
        $result = $this->user->autentication($id_user, $password);
        var_dump($result);
        if ($result['count(*)'] == 1) { #obvio que esto no deberian ser var_dump
            var_dump("se encontró el usuario, bienvenido");
            session_start();
            $_SESSION["id_user"] = $id_user;
            $session = $_SESSION;
            //$session = $this->get('session');
            //$session = null;
            //$session->set('array', array('id_user' => $_SESSION["id_user"]));
            //$twig = new \Twig_Environment();
            //$twig->addGlobal('session', $_SESSION);
        } else {
            var_dump("gil poné un usuario válido");
        }
        return view('index.views', compact('session'));
    }

    public function logOut() {
        session_start();
        $_SESSION = array();
        $session = $_SESSION;
        return view('index.views', compact('session'));
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