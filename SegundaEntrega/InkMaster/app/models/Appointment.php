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
    protected $errors = array();

    public function loadMedicalRecord($medical_record) { #cargar en la bd los medical_record

    }

    public function parameters() {
        $paremeters = array();  #cargar el array con todos los parametros, incluidos los de la clase, user y artist (creo)
        $paremeters["status"] = true;
        return $paremeters;
    }

    public function validate_local($local) { #no se si sirve de algo
        return true;
    }

    public function validate_user($user) { #no se si sirve de algo
        return true;
    }

    public function validate_date($date) { #solo ver formato y si hay error subir a $this->errors
        return true;
    }

    public function validate_hour($hour) { #solo ver formato y si hay error subir a $this->errors
        return true;
    }

    public function validate_artist($artist) { #verificar que ese turno este disponible para ese tatuador y si hay error subir a $this->errors
        return true;
    }

    public function validate_image($reference_image) { #no hay nada por verificar, solo hay que subir a la bd
        return true;
    }

    public function validateAll($parameters, $reference_image) {
        $boolean = false;
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
            $this->db->insert($this->table, $parameters);
            $this->loadMedicalRecord($medical_record);

            return $this->parameters();
        } else {
            $this->errors["status"] = false;

            return $this->errors;
        }
    }
}
