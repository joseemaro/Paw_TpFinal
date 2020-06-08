<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\User;
use App\models\Tattoo;
use App\models\FAQ;

class GeneralController extends Controller
{
    public function __construct()
    {
        $this->user = new User();
        $this->faq = new FAQ();
        $this->tatto = new Tattoo();
    }

    public function index() {
        session_start();
        $session = $this->session();
        return view('index.views', compact('session'));
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
        return view();#'list.appointments', compact('appointments'));
    }

    public function viewFaq() {
        return view();#'list.appointments', compact('appointments'));
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