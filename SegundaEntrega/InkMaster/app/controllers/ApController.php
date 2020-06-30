<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Appointment;
use App\models\User;
use App\models\Local;
use mysql_xdevapi\Session;

class ApController extends Controller
{

    public function __construct()
    {
        $this->appointment = new Appointment();
        $this->user = new User();
        $this->generalController = new GeneralController();
    }

    public  function newAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            #buscar si el usuario es menor de 18 años, en tal caso enviar advertencia
            $variable["adult"] = $this->user->verifyAdult($id_user);
            return $this->generalController->view('new.appointment', $variable);
        } else {
            return $this->generalController->view('new.appointment');
        }
    }

    public function saveAp ()
    {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $parameters["local"] = $this->generalController->getIdLocal();
            $parameters["user"] = $_SESSION["id_user"];
            $parameters["date"] = $_POST["date"];
            $parameters["hour"] = $_POST["hour"];
            $parameters["artist"] = $_POST["id_artist"];
            $reference_image = $_FILES;

            $medical_record = array();
            if (isset($_POST["pathology"])) {
                $medical_record["pathology-text"] = $_POST["pathology-txt"];
            }

            $array = $this->appointment->validateInsert($parameters, $reference_image, $medical_record);

            $reference_image["reference_image"] = $_FILES;

            if ($array["status"]) {     #si salio bien la validacion
                $variable["appointment"] = $array;
                $id_pacient = $variable["appointment"]["id_user"];
                $variable["medical"] = $this->user->viewMedRec($id_pacient);
                return $this->generalController->view('view.appointment', $variable);
            } else {
                $variable["errors"] = $array;
                return $this->generalController->view('errors.appointment', $variable);
            }
        }
        return $this->generalController->view('not_found');
    }

    public function listAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            if ($this->generalController->isArtist($id_user, $this->generalController->id_local)) {
                return $this->generalController->view('list.appointments', $variable, true);
            }
            return $this->generalController->view('list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function viewAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            $variable["medical"] = $this->user->viewMedRec($variable["appointment"]["id_user"]);
            if ($this->generalController->isArtist($id_user, $this->generalController->id_local)) {
                return $this->generalController->view('view.appointment', $variable, true);
            }
            return $this->generalController->view('view.appointment', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function editAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            if ($this->generalController->user->havePermissions($id_user, 'appointment.edit')) {
                return $this->generalController->view('edit.appointment', $variable, true);
            }
            return $this->generalController->view('view.appointment', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function uptAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->generalController->user->havePermissions($id_user, 'appointment.edit')) {
                #if hay nuevas imagenes de referencia
                $reference_image = "";
                #if hay nueva informacion medica
                $medical_record = "";
                #if hay un tattoo
                $tattoo = "";
                $array = $this->appointment->validateUpdate($id_appointment, $reference_image, $medical_record, $tattoo);
                if ($array["status"]) {     #si salio bien la validacion
                    $variable["appointment"] = $array;
                    return $this->generalController->view('view.appointment', $variable);
                } else {
                    $variable["errors"] = $array;
                    return $this->generalController->view('errors.appointment', $variable);
                }
            }
        }
        return $this->generalController->view('not_found');
    }

    public function aceptAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->generalController->user->havePermissions($id_user, 'appointment.acept')) {
                $result = $this->appointment->changeStatus($id_appointment, $id_user, 'accepted');
                $variable["appointments"] = $this->appointment->listAppointments($id_user);
                return $this->generalController->view('list.appointments', $variable, true);
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->generalController->view('list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function delAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->generalController->user->havePermissions($id_user, 'appointment.delete')) {
                $result = $this->appointment->changeStatus($id_appointment, $id_user, 'annulled');
                $variable["appointments"] = $this->appointment->listAppointments($id_user);
                return $this->generalController->view('list.appointments', $variable, true);
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->generalController->view('list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
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