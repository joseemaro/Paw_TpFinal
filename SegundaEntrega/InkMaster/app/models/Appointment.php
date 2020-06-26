<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Appointment extends Model
{
    protected $table = 'appointment';
    protected $id;
    protected $local;
    protected $user;
    protected $artist;
    protected $date;
    protected $hour;
    protected $status;
    protected $price;
    protected $parameters = array();
    protected $errors = array();

    public function loadBD($table, $parameters) { #cargar en la bd los medical_record
        #for
    }

    public function validate_local($id_local) { #no se si sirve de algo
        $this->parameters["id_local"] = $id_local;
        return true;
    }

    public function validate_user($id_user) { #no se si sirve de algo
        $this->parameters["id_user"] = $id_user;
        return true;
    }

    public function validate_date($date) { #solo ver formato y si hay error subir a $this->errors
        $this->parameters["date"] = $date;
        return true;
    }

    public function validate_hour($hour) { #solo ver formato y si hay error subir a $this->errors
        $this->parameters["hour"] = $hour;
        return true;
    }

    public function validate_artist($id_artist) { #verificar que ese turno este disponible para ese tatuador y si hay error subir a $this->errors
        $this->parameters["id_artist"] = $id_artist;
        return true;
    }

    public function validate_image($reference_image) { #solo verificar tamaño y extension, solo hay que subir a la bd
        $this->loadBD("reference_image", $reference_image);
        return true;
    }

    public function validate_medical($medical_record) { #no hay nada por verificar, solo hay que subir a la bd
        $this->loadBD("medical_record", $medical_record);
        return true;
    }

    public function validateAll($parameters, $reference_image) {
        $boolean = true;
        if (!empty($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $validate = "validate_" . $parameter;
                $boolean = $boolean && self::$validate($value);
            }
        }
        if (!empty($parameters) && !$boolean) {
            $boolean = $boolean && self::validate_image($reference_image);
        }

        return $boolean;
    }

    public function validateInsert($parameters, $reference_image, $medical_record) {
        $boolean = $this->validateAll($parameters, $reference_image);
        if ($boolean) {
            echo "<br>";
            var_dump($parameters);
            echo "<br>";
            $this->parameters["status"] = 'pending';
            $this->db->insert($this->table, $this->parameters);
            $this->parameters["status"] = true;

            return $this->parameters;
        } else {
            $this->errors["status"] = false;

            return $this->errors;
        }
    }

    public function listAppointments() {
        return $this->db->listAppointment($this->table);
    }
    public function listWaitingAppointments($id) {
        return $this->db->listWaitingAppointment($this->table, $id);
    }
    public function aceptAp($id_appointment){
        return $this->db->aceptAppointment($this->table , $id_appointment);
    }
    public function deleteAp($id_appointment){
        return $this->db->deleteAppointment($this->table , $id_appointment);
    }

    public function viewAp($id_appointment){
        return $this->db->findAppointment($this->table , $id_appointment);
    }
}
