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
        var_dump($_POST);
        $this->user;
        return view('register');
    }

    public function saveUser() {
        return view();#'list.appointments', compact('appointments'));
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
        return view('log.in');
    }

    public function logOut() {
        return view();#'list.appointments', compact('appointments'));
    }
}