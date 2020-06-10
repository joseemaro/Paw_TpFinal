<?php
namespace App\Controllers;

use App\Core\Controller;
use App\models\Appointment;

class ApController extends Controller
{
    public function __construct()
    {
        $this->appointment = new Appointment();
    }

    public  function newAp() {
        session_start();
        $session = $_SESSION;
        //buscar si el usuario es menor de 18 años, en tal caso que descargue el formulario
        return view('new.appointment', compact('session'));
    }

    public function saveAp ()
    {
        $parameters = array();
        $parameters["local"] = "local"; #recuperar los datos del local
        $parameters["user"] = $_SESSION["id_user"];
        $parameters["date"] = $_POST["date"];
        $parameters["hour"] = $_POST["hour"];
        $parameters["artist"] = $_POST["artist"];

        $reference_image["reference_image"] = $_FILES;

        $medical_record = $this->medical_reference();
        var_dump($medical_record);

        $array = $this->appointment->validateInsert($parameters, $reference_image, $medical_record);

        session_start();
        $session = $_SESSION;

        if ($array["status"]) {     #si salio bien la validacion
            $parameters = $array;
            return view('view.appointment', compact('session', 'parameters'));
        } else {
            $errors = $array;
            return view('new.appointment', compact('session', 'errors'));
        }
    }

    public function listAp() {
        $appointment = new Appointment();
        $appointments = $appointment->all();
        return view('list.appointments', compact('appointments'));
    }

    public function viewAp() {
        $appointment = new Appointment();
        $ap = $appointment->findid($_GET['id']);
        $diagnostico64 = base64_encode($ap['diagnostico']);
        return view('views.appointment', compact('ap', 'diagnostico64'));
    }

    public function editAp() {
        $appointment = new Appointment();
        $ap = $appointment->findid($_GET['id']);
        $diagnostico64 = base64_encode($ap['diagnostico']);
        return view('edit.appointment', compact('ap', 'diagnostico64'));
    }

    public function uptAp() {
        $appointment = new Appointment();
        $params = $this->comparacion();
        $respuesta = $appointment->validarUpdate($params, $_POST['id']);
        $errores = array_shift($respuesta);
        if ($errores == "Correcto") {
            $ap = $appointment->findid($_POST['id']);
            $diagnostico64 = base64_encode($ap['diagnostico']);
            return view('views.appointment', compact('ap', 'diagnostico64')) ;
        }
        elseif ($errores == "Incorrecto") {
            return view('error.views', compact('respuesta'));
        }
        elseif ($errores == "Imagen Pesada") {
            return view('error.views', compact('respuesta'));
        }
    }

    public function delAp() {
        $appointment = new Appointment();
        $appointment->delete($_GET['id']);
        $appointments = $appointment->all();
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