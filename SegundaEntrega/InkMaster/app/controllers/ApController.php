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
        $this->generalController = new GeneralController();
    }

    public  function newAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            #buscar si el usuario es menor de 18 años, en tal caso enviar advertencia
            $variable["adult"] = $this->user->verifyAdult($_SESSION["id_user"]);
            return $this->generalController->view('new.appointment', $variable);
        } else {
            return $this->generalController->view('new.appointment', null);
        }
    }

    public function saveAp ()
    {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $parameters["local"] = $_POST["id_local"];
            $parameters["user"] = $_SESSION["id_user"];
            $parameters["artist"] = $_POST["id_artist"];
            $parameters["date"] = $_POST["date"];
            $parameters["hour"] = $_POST["hour"];
            $reference_image = $_FILES;

            $medical_record = array();
            if (isset($_POST["pathology"])) {
                $medical_record["pathology-text"] = $_POST["pathology-txt"];
            }

            $array = $this->appointment->validateInsert($parameters, $reference_image, $medical_record);

            $reference_image["reference_image"] = $_FILES;

            if ($array["status"]) {     #si salio bien la validacion
                $variable["parameters"] = $array;
                return $this->generalController->view('view.appointment', $variable);
            } else {
                $variable["errors"] = $array;
                return $this->generalController->view('errors.appointment', $variable);
            }
        } else {
            $variable["errors"] = "No se encuentra ningún usuario logueado";
            return $this->generalController->view('errors.appointment', $variable);
        }
    }

    public function listAp() {
        $variable["appointments"] = $this->appointment->listAppointments();
        return $this->generalController->view('list.appointments', $variable);
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
}