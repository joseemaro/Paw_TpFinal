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
        $id_user = $_POST["id_user"];
        $password = $_POST["password"];
        $result = $this->user->find($id_user, $password);
        var_dump($result);
        session_start();
        $_SESSION["id_user"] = $id_user;
        $session = $this->session();
        return view('index.views', compact('session'));
    }

    public function logOut() {
        session_start();
        unset($_SESSION["id_user"]);
        $session = $this->session();
        return view('index.views', compact('session'));#'list.appointments', compact('appointments'));
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