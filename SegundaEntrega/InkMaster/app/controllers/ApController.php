<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Appointment;
use App\models\User;
use App\models\Local;

class ApController extends Controller
{
    private $id_local = '1';

    public function __construct()
    {
        $this->appointment = new Appointment();
        $this->user = new User();
        $this->local = new Local();
    }

    public  function newAp() {
        session_start();
        $session = $_SESSION;
        //recupero artista de bd
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        //buscar si el usuario es menor de 18 años, en tal caso que salte advertencia y mandar una variable en compact
        return view('new.appointment', compact('session','artists', 'local'));
    }

    public function saveAp ()
    {
        session_start();
        $session = $_SESSION;

        $parameters = array();
        $parameters["local"] = "1"; #recuperar los datos del local
        $parameters["user"] = $_SESSION["id_user"];
        $parameters["date"] = $_POST["date"];
        $parameters["hour"] = $_POST["hour"];
        $parameters["artist"] = $_POST["id_artist"];

        $artists = $this->artists->listArtist();
        $local = $this->local->getTxt($this->id_local);

        $reference_image["reference_image"] = $_FILES;

        $medical_record = $this->medical_reference();
        echo "medical_reference<br>";
        var_dump($medical_record);
        echo "<br>";

        $array = $this->appointment->validateInsert($parameters, $reference_image, $medical_record);

        if ($array["status"]) {     #si salio bien la validacion
            $parameters = $array;
            return view('view.appointment', compact('session', 'artists', 'local', 'parameters'));
        } else {
            $errors = $array;
            return view('view.appointment', compact('session', 'artists', 'local', 'errors'));
        }
    }

    public function listAp() {
        return view('list.appointments', compact('appointments'));
    }

    public function viewAp() {
        /*$appointment = new Appointment();
        $ap = $appointment->findid($_GET['id']);
        $diagnostico64 = base64_encode($ap['diagnostico']);*/
        session_start();
        $session = $_SESSION;
        $artists = $this->user->listArtist();
        $local = $this->local->getTxt($this->id_local);
        return view('view.appointment', compact('session', 'artists', 'local'));#, compact('ap', 'diagnostico64'));
    }

    public function editAp() {
        return view('edit.appointment', compact('ap', 'diagnostico64'));
    }

    public function uptAp() {
        return view('views.appointment', compact('ap', 'diagnostico64')) ;
    }

    public function delAp() {
        return view('list.appointments', compact('appointments'));
    }

    private function comparacion() {
        $appointment = new Appointment();
        $old = $appointment->findid($_POST['id']);
        $params = array();
        if ($old["nombre"] != $_POST["nombre"]) $params["nombre"] = $_POST["nombre"];
        if ($old["email"] != $_POST["email"]) $params["email"] = $_POST["email"];
        if ($old["telefono"] != $_POST["telefono"]) $params["telefono"] = $_POST["telefono"];
        if ($old["edad"] != $_POST["edad"]) $params["edad"] = $_POST["edad"];
        if ($old["talla_calzado"] != $_POST["talla_calzado"]) $params["talla_calzado"] = $_POST["talla_calzado"];
        if ($old["altura"] != $_POST["altura"]) $params["altura"] = $_POST["altura"];
        if ($old["fecha_nacimiento"] != $_POST["fecha_nacimiento"]) $params["fecha_nacimiento"] = $_POST["fecha_nacimiento"];
        if ($_POST["color_pelo"] != null) {
            $params["color_pelo"] = $_POST["color_pelo"];
        }
        if ($old["fecha_turno"] != $_POST["fecha_turno"] || $old["horario_turno"] != $_POST["horario_turno"]) {
            $params["fecha_turno"] = $_POST["fecha_turno"];
            $params["horario_turno"] = $_POST["horario_turno"];
        }
        return $params;
    }

    public function session() {
        if (isset($_SESSION["id_user"])) {
            $session = true;
        } else {
            $session = false;
        }
        return $session;
    }

    public function medical_reference() {
        $medical_record = array();
        if (isset($_POST["chemotherapy"])) {
            $medical_record["chemotherapy"] = true;
        }
        if (isset($_POST["anemia"])) {
            $medical_record["anemia"] = true;
        }
        if (isset($_POST["leukemia"])) {
            $medical_record["leukemia"] = true;
        }
        if (isset($_POST["thrombocytopenia"])) {
            $medical_record["thrombocytopenia"] = true;
        }
        if (isset($_POST["acne"])) {
            $medical_record["acne"] = true;
        }
        if (isset($_POST["allergy"])) {
            $medical_record["allergy"] = true;
            $medical_record["allergy-txt"] = $_POST["allergy-txt"];
        }
        if (isset($_POST["G6PD_deficiency"])) {
            $medical_record["G6PD_deficiency"] = true;
        }
        if (isset($_POST["diabetes"])) {
            $medical_record["diabetes"] = true;
        }
        if (isset($_POST["von_willebrand"])) {
            $medical_record["von_willebrand"] = true;
        }
        if (isset($_POST["hereditary_spherocytosis"])) {
            $medical_record["hereditary_spherocytosis"] = true;
        }
        if (isset($_POST["hemophilia"])) {
            $medical_record["hemophilia"] = true;
        }

        return $medical_record;
    }
}