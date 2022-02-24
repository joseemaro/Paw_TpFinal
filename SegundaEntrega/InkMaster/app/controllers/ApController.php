<?php
namespace App\Controllers;

use App\Controllers\GeneralController;
use App\models\Appointment;
use App\models\User;
use App\models\Local;
use mysql_xdevapi\Session;
use App\googleAPI\calendar;

class ApController extends GeneralController
{

    public function __construct()
    {
        $this->user = new User();
        $this->local = new Local();
        $this->id_local = $this->local->getLocal();
        $this->session = false;
        $this->appointment = new Appointment();
        $this->calendar = new calendar();
    }

    public  function newAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $variable["session"] = true;
            $id_user = $_SESSION["id_user"];
            #buscar si el usuario es menor de 18 años, en tal caso enviar advertencia
            $variable["adult"] = $this->user->verifyAdult($id_user);
        }else{
            $variable["session"] = false;
        }
        return $this->view('appointment/new.appointment', $variable);

    }

    public function saveAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $parameters["local"] = $this->getIdLocal();
            $parameters["user"] = $_SESSION["id_user"];
            if (isset($_POST["date"])) {
                $parameters["date"] = $_POST["date"];
            }
            if (isset($_POST["hour"])) {
                $parameters["hour"] = $_POST["hour"];
            }
            if (isset($_POST["id_artist"])) {
                $parameters["artist"] = $_POST["id_artist"];
            }
            if (isset($_FILES["reference_image"])) {
                $parameters["reference_images"]["reference_image"] = $_FILES;
            }
            if (isset($_POST["pathology"])) {
                $parameters["txt"] = $_POST["pathology-txt"];
            }

            $array = $this->appointment->validateInsert($parameters);

            if ($array["status"]) {     //si salio bien la validacion
                $variable["appointment"] = $array;
                $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
                return $this->view('appointment/view.new.appointment', $variable);
            } else {
                $variable["errors"] = $array;
                return $this->view('appointment/errors.appointment', $variable);
            }
        }
        return $this->view('not_found');
    }

    public function listAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $variable["appointments"] = json_decode( $this->getAps( 1, false ) );
            $variable["link"] ="https://calendar.google.com/calendar/r";
            return $this->view('appointment/list.appointments', $variable);
        }
        return $this->view('not_found');
    }

    public function viewAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            $medical = false;
            if ($medical) {
                $variable["medical_record"] = $medical["considerations"];
            }else{
                $variable["medical_record"]= "-";
            }
            $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
            return $this->view('appointment/view.appointment', $variable);
        }
        return $this->view('not_found');
    }

    public function editAp($id_appointment) {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $variable["appointment"] = $this->appointment->findAppointment($id_appointment);
            $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);
            if ($this->user->havePermissions($id_user, 'appointment.edit')) {
                return $this->view('appointment/edit.appointment', $variable);
            }
            return $this->view('appointment/view.appointment', $variable);
        }
        return $this->view('not_found');
    }

    public function cancelAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            $this->appointment->cancelAp($id_appointment);
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            $variable["link"] =false;
            return $this->view('appointment/list.appointments', $variable);
        }
        return $this->view('not_found');
    }

    public function uptAp() {
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'appointment.edit')) {
                if (isset($_POST["date"])) {
                    $date = $_POST["date"];
                } else {
                    $date = null;
                }
                if (isset($_POST["hour"])) {
                    $hour = $_POST["hour"];
                } else {
                    $hour = null;
                }
                $array = $this->appointment->validateUpdate($_POST["id_appointment"], $date, $hour);
                if ($array["status"]) {     #si salio bien la validacion
                    $variable["appointment"] = $array;
                    $variable["adult"] = $this->user->verifyAdult($variable["appointment"]["id_user"]);

                    $artist = $this->appointment->findCalendar($variable["appointment"]["id_user"]);
                    $ap = $this->appointment->findAppointment($_POST["id_appointment"]);

                    if (isset($ap["id_calendar"])){
                        /* delete calendar */
                        $this->calendar->deleteCalendar($artist["link"],$ap["id_calendar"]);
                        /* calendar */
                        $array = $this->appointment->findAppointment($_POST["id_appointment"]);
                        $link = $this->appointment->findCalendar($array["id_artist"]);
                        $m = $this->calendar->add_turno_calendar($array["id_user"],$date,$hour,$array["id_artist"],$link["link"]);
                        if ($m["ok"] != ''){
                            $this->appointment->insertLink($_POST["id_appointment"],$m["ok"],$m["id_calendar"]);
                        }
                    }

                    return $this->view('appointment/view.appointment', $variable);
                } else {
                    $variable["errors"] = $array;
                    return $this->view('appointment/errors.appointment', $variable);
                }
            }
        }
        return $this->view('not_found');
    }

    public function aceptAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'appointment.acept')) {
                //guardar en el calendar
                $array = $this->appointment->findAppointment($id_appointment);
                $link = $this->appointment->findCalendar($array["id_artist"]);


                $m = $this->calendar->add_turno_calendar($array["id_user"],$array["date"],$array["hour"],$array["id_artist"],$link["link"]);
                if ($m["ok"] != ''){
                    //si salio bien el registro del turno en calendar
                    $this->appointment->insertLink($id_appointment,$m["ok"],$m["id_calendar"]);
                    $result = $this->appointment->changeStatus($id_appointment, $id_user, 'accepted');
                }else{
                    //si hubo error en el calendar
                    $variable["errors"] = $m["error"];
                    return $this->view('appointment/errors.appointment', $variable);
                }
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            $variable["link"] ="https://calendar.google.com/calendar/r";
            return $this->view('/appointment/list.appointments', $variable);
        }
        return $this->view('not_found');
    }

    public function delAp($id_appointment){
        session_start();
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
            if ($this->user->havePermissions($id_user, 'appointment.delete')) {
                $result = $this->appointment->changeStatus($id_appointment, $id_user, 'annulled');
            }
            $variable["appointments"] = $this->appointment->listAppointments($id_user);
            return $this->view('appointment/list.appointments', $variable);
        }
        return $this->view('not_found');
    }

    public function getAps( $page = 1, $json = true ) {
        if ( $json ) {
            session_start();
        }
        if (isset($_SESSION["id_user"])) {
            $id_user = $_SESSION["id_user"];
        }
        $quantity = 6;

        $isArtist = $this->isArtist( $id_user );
        $isAdmin = $this->isAdministrator( $id_user );
        $beginning = ( ( $page * $quantity ) - $quantity );
        $appointments = $this->appointment->getAps( $id_user, $beginning, $quantity, $isArtist, $isAdmin );
        return json_encode( $appointments );
    }
}