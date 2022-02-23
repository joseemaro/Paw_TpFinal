<?php
namespace App\Controllers;

use App\models\Appointment;
use App\models\Local;
use App\models\User;
use App\Controllers\GeneralController;

class UserController extends GeneralController
{

    public function __construct()
    {
        $this->user = new User();
        $this->local = new Local();
        $this->id_local = $this->local->getLocal();
        $this->appointment = new Appointment();
        $this->session = false;

    }

    public function register() {
        return $this->view('register');
    }

    public function saveUser() {
        $parameters = $this->parameters();
        $array = $this->user->validateInsert( $parameters );
        $status = $array[count($array)-1];
        if ($status) {  #si salio bien la validacion
            session_start();
            if (isset($_SESSION["id_user"])) {
                return $this->view('/index.views');
            }else{
                $_SESSION = array();
                return $this->view('login');
            }
        } else {
            array_pop( $array );
            $variable["errors"] = $array;
            if (isset( $parameters["pathology"] ) ) $parameters["pathology_check"] = true;
            $variable["data"] = $parameters;
            return $this->view('register', $variable);
        }
    }

    public function logIn() {
        session_start();
        if (!isset($_SESSION["id_user"])) {
            return $this->view('login');
        }
        return $this->view('not_found');
    }

    public function autentication() {
        session_start();
        if (!isset($_SESSION["id_user"])) {
            $id_user = $_POST["id_user"];
            $password = $_POST["password"];
            $result = $this->user->autentication($id_user, $password);
            if ($result) {
                $variable["msgWelcome"] = "bienvenido $id_user ! ";
                $_SESSION["id_user"] = $id_user;
            } else {
                $variable["errors"] = true;
                $login["id_user"] = $id_user;
                $login["password"] = $password;
                $variable["data"] = $login;
                return $this->view('/login', $variable);
            }
            return $this->view('/index.views', $variable);
            
        }
        return $this->view('not_found');
    }

    public function logOut() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $_SESSION = array();
            return $this->view('index.views');
        }
        return $this->view('index.views');
    }

    public function listUsers() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'user.list')) {
                $variable["artists"] = $this->user->listUsers();
                return $this->view('user/list.users', $variable);
            }
        }
        return $this->view('not_found');
    }

    public function viewUser($id_user_v) {
        $id_user_v = str_replace("%20", " ", $id_user_v);
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'user.view')) {
                if ($this->isAdministrator($id_user) || $id_user_v == $id_user) {
                    $variable["user"] = $this->user->findUser($id_user_v);
                    /*return $this->view('user/view.user', $variable);*/
                    return $this->view('user/view.user2', $variable);
                }
            }
        }
        return $this->view('not_found');
    }

    public function editUser($id_user_v) {
        $id_user_v = str_replace("%20", " ", $id_user_v);
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'user.edit')) {
                $user = $this->user->findUser($id_user_v);
                $variable["user"] = $user;
                return $this->view('user/edit.user', $variable);
            }
        }
        return $this->view('not_found');
    }

    public function uptUser() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'user.edit')) {
                $parameters = $this->comparacion($id_user);
                $array = $this->user->validateUpdate($id_user, $parameters);
                $status = $array[count($array)-1];
                if ($status) {  #si salio bien la validacion
                    $user = $this->user->findUser($id_user);
                    $variable["user"] = $user;
                    return $this->view('user/view.user2', $variable);
                } else {
                    array_pop( $array );
                    $variable["errors"] = $array;
                    return $this->view('errors.register', $variable);
                }
            }
        }
        return $this->view('not_found');
    }

    public function delUser($id_user_v) {
        $id_user_v = str_replace("%20", " ", $id_user_v);
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'user.delete')) {
                if ($this->isAdministrator($id_user) || $id_user_v == $id_user) {
                    $status = $this->user->deleteUser($id_user);
                    if ($status == false) {  #si salio bien la validacion
                        $_SESSION = array();
                        return $this->view('/index.views');
                    } else {
                        $variable["errors"] = $status;
                        return $this->view('errors.register', $variable);
                    }
                }
            }
        }
        return $this->view('not_found');
    }

    public function listArtists() {
        $variable["artists"] = $this->user->listArtists($this->getIdLocal());
        return $this->view('artist/list.artists', $variable);
    }

    public function viewArtist($id_artist) {
        $id_artist = str_replace("%20", " ", $id_artist);
        $variable["artist"] = $this->user->findArtist($id_artist);
        return $this->view('artist/view.artist', $variable);
    }

    public function comparacion($id_user) {
        $parameters = array();
        $old = $this->user->findUser($id_user);
        if ($old["first_name"] != $_POST["first_name"]) $parameters["first_name"] = $_POST["first_name"];
        if ($old["last_name"] != $_POST["last_name"]) $parameters["last_name"] = $_POST["last_name"];
        if ($old["born"] != $_POST["born"]) $parameters["born"] = $_POST["born"];
        if ($old["nro_doc"] != $_POST["nro_doc"]) $parameters["nro_doc"] = $_POST["nro_doc"];
        if ($old["phone"] != $_POST["phone"]) $parameters["phone"] = $_POST["phone"];
        if ($old["direction"] != $_POST["direction"]) $parameters["direction"] = $_POST["direction"];
        if ($old["email"] != $_POST["email"]) $parameters["email"] = $_POST["email"];
        if (isset($_FILES["photo_edit"])) $parameters["photo"] = $_FILES["photo_edit"];
        if (!empty($_POST["pathology"]) && $old["considerations"] != $_POST["pathology"]) $parameters["pathology"] = $_POST["pathology"];
        if (isset($_POST["artist"]) || isset($_POST["txt"])) {
            $parameters["artist"] = true;
            if ($old["txt"] != $_POST["txt"]) $parameters["txt"] = $_POST["txt"];
        }
        return $parameters;
    }

    public function parameters() {
        $parameters = array();
        if (isset($_POST["id_user"])) $parameters["user"] = $_POST["id_user"];
        if (isset($_POST["password"])) $parameters["password"] = $_POST["password"];
        if (isset($_POST["confirm_password"])) $parameters["confirm_password"] = $_POST["confirm_password"];
        if (isset($_POST["first_name"])) $parameters["first_name"] = $_POST["first_name"];
        if (isset($_POST["last_name"])) $parameters["last_name"] = $_POST["last_name"];
        if (isset($_POST["born"])) $parameters["born"] = $_POST["born"];
        if (isset($_POST["nro_doc"])) $parameters["nro_doc"] = $_POST["nro_doc"];
        if (isset($_POST["phone"])) $parameters["phone"] = $_POST["phone"];
        if (isset($_POST["direction"])) $parameters["direction"] = $_POST["direction"];
        if (isset($_POST["email"])) $parameters["email"] = $_POST["email"];
        if (isset($_FILES)) $parameters["photo"] = $_FILES['photo'];
        if (isset($_POST["pathology"])) $parameters["pathology"] = $_POST["pathology-txt"];
        if (isset($_POST["artist"])) {
            $parameters["artist"] = true;
            $parameters["local"] = $this->getIdLocal();
            if (isset($_POST["txt"])) $parameters["txt"] = $_POST["txt"];
            if (isset($_POST["id_calendar"])) $parameters["link"] = $_POST["id_calendar"];
        }
        return $parameters;
    }

   
}