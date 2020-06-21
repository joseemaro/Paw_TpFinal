<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class User extends Model
{
    protected $table = 'user';
    protected $id;
    protected $password;
    protected $first_name;
    protected $last_name;
    protected $born;
    protected $num_doc;
    protected $phone;
    protected $direction;
    protected $email;
    protected $photo;
    protected $artist;
    protected $id_local;
    protected $description;
    protected $parameters;
    protected $parameters_user;
    protected $parameters_artist;
    protected $return = array();

    public function validate_user($id_user) {
        $boolean = true;

        if (!empty($id_user)) {
            $pattern = "\"^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9._ ]+(?<![_.])$\"";
            if (!preg_match($pattern, $id_user)) {
                $error = "El formato de nombre de usuario ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["id_user"] = $id_user;
                $this->parameters_user["id_user"] = $id_user;
            }
        } else {
            $error = "Se precisa que sea ingresado un nombre de usuario";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_password($password) {
        $boolean = true;

        if (!empty($password)) {
            $pattern = "\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\"";
            if (!preg_match($pattern, $password)) {
                $error = "El formato de la contraseña ingresada es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["password"] = $password;
                $this->parameters_user["password"] = $password;
            }
        } else {
            $error = "Se precisa que sea ingresada una contraseña";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_confirm_password($confirmPassword) {
        $boolean = true;

        if (!empty($confirmPassword)) {
            $pattern = "\"(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}\"";
            if (!preg_match($pattern, $confirmPassword)) {
                unset($this->parameters["password"]);
                unset($this->parameters_user["password"]);
                $error = "El formato de la contraseña ingresada es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } elseif ($this->parameters["password"] != $confirmPassword) {
                unset($this->parameters["password"]);
                unset($this->parameters_user["password"]);
                $error = "Se precisa que reescriba la contraseña previamente ingresada";
                array_push($this->return, $error);
                $boolean = false;
            }
        } else {
            unset($this->parameters["password"]);
            unset($this->parameters_user["password"]);
            $error = "Se precisa que reescriba la contraseña previamente ingresada";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_first_name($first_name) {
        $boolean = true;

        if (!empty($first_name)) {
            $pattern = "\"^[a-zA-Z ]{3,30}$\"";
            if (!preg_match($pattern, $first_name)) {
                $error = "El formato del nombre ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["first_name"] = $first_name;
                $this->parameters_user["first_name"] = $first_name;
            }
        } else {
            $error = "Se precisa que sea ingresado un nombre";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_last_name($last_name) {
        $boolean = true;

        if (!empty($last_name)) {
            $pattern = "\"^[a-zA-Z ]{3,30}$\"";
            if (!preg_match($pattern, $last_name)) {
                $error = "El formato del apellido ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["last_name"] = $last_name;
                $this->parameters_user["last_name"] = $last_name;
            }
        } else {
            $error = "Se precisa que sea ingresado un apellido";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_born($born) {
        $boolean = true;

        if (!empty($born)) {
            $this->parameters["born"] = $born;
            $this->parameters_user["born"] = $born;
        } else {
            $error = "Se precisa que sea ingresada una fecha de nacimiento";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_nro_doc($nro_doc) {
        $boolean = true;

        if (!empty($nro_doc)) {
            $pattern = "\"^\d{8}(?:[-\s]\d{4})?$\"";
            if (!preg_match($pattern, $nro_doc)) {
                $error = "El formato del número de documento ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["nro_doc"] = $nro_doc;
                $this->parameters_user["nro_doc"] = $nro_doc;
            }
        } else {
            $error = "Se precisa que sea ingresado un número de documento";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_phone($phone) {
        $boolean = true;

        if (!empty($phone)) {
            $pattern = "\"^(?:(?:00)?549?)?0?(?:11|[2368]\d)(?:(?=\d{0,2}15)\d{2})??\d{8}$\"";
            if (!preg_match($pattern, $phone)) {
                $error = "El formato del número de teléfono ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["phone"] = $phone;
                $this->parameters_user["phone"] = $phone;
            }
        } else {
            $error = "Se precisa que sea ingresado un número de teléfono";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_direction($direction) {
        $boolean = true;

        if (!empty($direction)) {
            $pattern = "\"^[a-zA-Z0-9 ]{3,50}$\"";
            if (!preg_match($pattern, $direction)) {
                $error = "El formato de la dirección ingresada es inválida";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["direction"] = $direction;
                $this->parameters_user["direction"] = $direction;
            }
        } else {
            $error = "Se precisa que sea ingresada una dirección";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_email($email) {
        $boolean = true;

        if (!empty($email)) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "El formato del email ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                $this->parameters["email"] = $email;
                $this->parameters_user["email"] = $email;
            }
        } else {
            $error = "Se precisa que sea ingresado un email";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_photo($photo) {    #revisar la extension y tamaño
        $this->parameters["photo"] = $photo;
        $this->parameters_user["photo"] = $photo;
        return true;
    }

    public function validate_artist($artist) {
        $boolean = true;

        if ($artist) {
            $this->parameters["id_artist"] = $this->parameters["id_user"];
            $this->parameters_artist["id_artist"] = $this->parameters["id_user"];
        } else {
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_local($id_local) {     #revisar que sea el id de un local ya registrado
        $this->parameters["id_local"] = $id_local;
        $this->parameters_artist["id_local"] = $id_local;
        return true;
    }

    public function validate_txt($txt) {    #no se si no generaria inyeccion sql
        $this->parameters["txt"] = $txt;
        $this->parameters_artist["txt"] = $txt;
        return true;
    }

    public function validate_pathology($pathology) {    #no se si no generaria inyeccion sql
        $this->parameters["pathology"] = $pathology;
        return true;
    }

    public function validateAll($parameters) {
        $boolean = true;
        if (!empty($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $validate = "validate_" . $parameter;
                $boolean = $boolean && self::$validate($value);
            }
        }

        return $boolean;
    }

    public function validateInsert($parameters) {
        $boolean = $this->validateAll($parameters);
        if ($boolean) {
            $parameters_user = $this->parameters_user;
            $this->db->insert('user', $parameters_user);

            if (isset($this->parameters_artist["id_artist"])) {
                $parameters_artist = $this->parameters_artist;
                $this->db->insert('artist', $parameters_artist);
            }

            $status = true;
        } else {
            $status = false;
        }
        array_push($this->return, $status);
        return $this->return;
    }

    public function autentication($id_user, $password) {
        return $this->db->autentication($id_user, $password);
    }

    public function listArtists($id_local) {
        return $this->db->listArtists($this->table, $id_local);
    }

    public function findUser($id) {
        return $this->db->findUser($this->table, $id);
    }

    public function findArtist($id) {
        return $this->db->findArtist($this->table, $id);
    }
}