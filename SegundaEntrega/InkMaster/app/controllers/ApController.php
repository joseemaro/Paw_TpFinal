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
            return $this->generalController->view('appointment/new.appointment', $variable);
        }
        return $this->generalController->view('appointment/new.appointment');
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
                $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
                return $this->generalController->view('appointment/view.appointment', $variable);
            } else {
                $variable["errors"] = $array;
                return $this->generalController->view('appointment/errors.appointment', $variable);
            }
        }
        return $this->generalController->view('not_found');
    }

    public function listAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->generalController->view('appointment/list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function viewAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            $variable["medical"] = $this->user->viewMedRec($variable["appointment"]["id_user"]);
            $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
            return $this->generalController->view('appointment/view.appointment', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function editAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
            if ($this->generalController->user->havePermissions($id_user, 'appointment.edit')) {
                return $this->generalController->view('appointment/edit.appointment', $variable);
            }
            return $this->generalController->view('appointment/view.appointment', $variable);
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
                    $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
                    return $this->generalController->view('appointment/view.appointment', $variable);
                } else {
                    $variable["errors"] = $array;
                    return $this->generalController->view('appointment/errors.appointment', $variable);
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
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->generalController->view('appointment/list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
    }

    public function delAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->generalController->user->havePermissions($id_user, 'appointment.delete')) {
                $result = $this->appointment->changeStatus($id_appointment, $id_user, 'annulled');
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->generalController->view('appointment/list.appointments', $variable);
        }
        return $this->generalController->view('not_found');
    }
}