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
    protected $errors;

    public function validate_user($id_user) {   #no se si sirve
        $this->parameters["id_user"] = $id_user;
        $this->parameters_user["id_user"] = $id_user;
        return true;
    }

    public function validate_password($password) {  #encriptar la password y revisar formato previamente revisado por js
        $this->parameters["password"] = $password;
        $this->parameters_user["password"] = $password;
        return true;
    }

    public function validate_first_name($first_name) {  #revisar formato
        $this->parameters["first_name"] = $first_name;
        $this->parameters_user["first_name"] = $first_name;
        return true;
    }

    public function validate_last_name($last_name) {    #revisar formato
        $this->parameters["last_name"] = $last_name;
        $this->parameters_user["last_name"] = $last_name;
        return true;
    }

    public function validate_born($born) {  #revisar formato y revisar que tenga por lo menos 10 o X años previamente revisado por js
        $this->parameters["born"] = $born;
        $this->parameters_user["born"] = $born;
        return true;
    }

    public function validate_nro_doc($nro_doc) {    #revisar formato aunque no se si sirve
        $this->parameters["nro_doc"] = $nro_doc;
        $this->parameters_user["nro_doc"] = $nro_doc;
        return true;
    }

    public function validate_phone($phone) {    #revisar formato
        $this->parameters["phone"] = $phone;
        $this->parameters_user["phone"] = $phone;
        return true;
    }

    public function validate_direction($direction) {    #revisar formato
        $this->parameters["direction"] = $direction;
        $this->parameters_user["direction"] = $direction;
        return true;
    }

    public function validate_email($email) {    #revisar formato
        $this->parameters["email"] = $email;
        $this->parameters_user["email"] = $email;
        return true;
    }

    public function validate_photo($photo) {    #no se que revisar aparte de la extension y tamaño
        $this->parameters["photo"] = $photo;
        $this->parameters_user["photo"] = $photo;
        return true;
    }

    public function validate_artist($artist) {  #crear un id_artist en $parameters_artist
        $this->parameters["id_artist"] = $this->parameters["id_user"];
        $this->parameters_artist["id_artist"] = $this->parameters["id_user"];
        return true;
    }

    public function validate_local($id_local) {     #revisar formato
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
            var_dump($parameters_user);
            echo "<br>";
            $this->db->insert('user', $parameters_user);

            if (isset($this->parameters_artist["id_artist"])) {
                $parameters_artist = $this->parameters_artist;
                var_dump($parameters_artist);
                echo "<br>";
                $this->db->insert('artist', $parameters_artist);
            }

            $this->parameters["status"] = true;

            return $this->parameters;
        } else {
            $this->errors["status"] = false;

            return $this->errors;
        }
    }

    public function autentication($id_user, $password) {
        return $this->db->autentication($id_user, $password);
    }

    public function listArtist() {
        return $this->db->selectArtists($this->table);
    }
}