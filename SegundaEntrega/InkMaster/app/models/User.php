<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;
use App\googleAPI\calendar;

class User extends Model
{
    protected $database = 'inkmaster_db';
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
    protected $parameters_calendar;
    protected $parameters_medical;
    protected $return = array();


    public function deleteUser($id_user_v) {
        $gCalendar = new Calendar();

        #anulo turnos
        $today = getdate();
        $year = $today["year"];
        $month = $today["mon"];
        $day = $today["mday"];
        $today = $year . "-" . $month . "-" . $day;
        $turnos = $this->db->simpleQuery("update $this->database.appointment set status = :1 
        where id_user = :2 and date >= :3", ['annulled', $id_user_v, $today]);
        #elimino user
        $turnos = $this->db->simpleQuery("update $this->database.$this->table set enabled = :1 
        where id_user = :2;", [0, $id_user_v]);

        $result = $this->db->query("SELECT appointment.id_calendar as id_c,calendar_link.link as link_c FROM $this->database.appointment INNER JOIN $this->database.calendar_link 
        on appointment.id_artist=calendar_link.id_artist WHERE appointment.id_user='$id_user_v'");

        if ($result){
            foreach($result as $fila){
                if ($fila["id_c"]!= null){
                    $gCalendar->deleteCalendar($fila["link_c"],$fila["id_c"]);   
                }          
            }
        }             
        return $turnos;

    }

    public function validate_user($id_user) {
        $boolean = true;

        if (!empty($id_user)) {
            $pattern = "\"^(?=.{8,20}$)(?![_.])(?!.*[_.]{2})[a-zA-Z0-9. ]+(?<![_.])$\"";
            if (!preg_match($pattern, $id_user)) {
                $error = "El formato de nombre de usuario ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else if (!$this->validate_duplicateUser($id_user)) {
                $this->parameters["id_user"] = $id_user;
                $this->parameters_user["id_user"] = $id_user;
                $this->parameters_medical["id_user"] = $id_user;
            }else{
                $error = "El nombre de usuario no esta disponible";
                array_push($this->return, $error);
                $boolean = false;
            }
        } else {
            $error = "Se precisa que sea ingresado un nombre de usuario";
            array_push($this->return, $error);
            $boolean = false;
        }
        return $boolean;
    }

    public function updMedRec($table ,$id_user, $medical){
        return $this->db->updMedRec($table ,$id_user, $medical);
    }


    public function validate_duplicateUser($id_user){
        $cant = $this->db->simpleQuery("select count(*) as cant from $this->database.$this->table where id_user = :1", [$id_user]);
        $can = $cant['cant'];
        if ($can == "0"){
            return false;
        }else{
            return true;
        }
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
            $this->parameters["password"] = password_hash($this->parameters["password"], PASSWORD_BCRYPT);
            $this->parameters_user["password"] = $this->parameters["password"];
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

    public function validate_photo($photo) {
        $boolean = true;
        if (!empty($photo["name"])) {
            $extension = $photo["type"];
            $extension = strtolower($extension);
            if ($extension != 'image/png' && $extension != 'image/jpg' && $extension != 'image/jpeg') {
                $error = "Solo se permite archivos con extensión JPG y PNG.";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                if ($photo["size"] > 5000000) {
                    $error = "Solo se permite archivos menores o iguales a 5 MB.";
                    array_push($this->return, $error);
                    $boolean = false;
                } else {
                    $this->parameters["photo"] = file_get_contents($photo["tmp_name"]);
                    $this->parameters_user["photo"] = file_get_contents($photo["tmp_name"]);
                }
            }
        }
        return $boolean;
    }

    public function validate_artist($artist) {  #validar si es un artista
        $boolean = true;
        if ($artist != null) {
            $this->parameters["id_artist"] = $this->parameters["id_user"];
            $this->parameters_artist["id_artist"] = $this->parameters["id_user"];
            $this->parameters_calendar["id_artist"] = $this->parameters["id_user"];
        } else {
            $boolean = false;
        }

        return $boolean;
    }

    public function validate_local($id_local) {
        $local = $this->db->simpleQuery("select * from $this->database.local
                                            where id_local = :1", [$id_local]);
        if (isset($local["id_local"])) {
            $this->parameters["id_local"] = $id_local;
            $this->parameters_artist["id_local"] = $id_local;
            return true;
        } else {
            return false;
        }
    }

    public function validate_txt($txt) {    #no se si no generaria inyeccion sql
        $this->parameters["txt"] = $txt;
        $this->parameters_artist["txt"] = $txt;
        return true;
    }

    public function validate_pathology($pathology) {    #no se si no generaria inyeccion sql y manipular para insertar
        $this->parameters["medical_record"] = addslashes($pathology);
        $this->parameters_medical["considerations"] = addslashes($pathology);
        return true;
    }

    public function validate_link($link){
        $boolean = true;

        if (!empty($link)) {
            $pattern = "\"^[a-zA-Z0-9@., ]{3,100}$\"";
            if (!preg_match($pattern, $link))
            {
                $error = "El formato del link ingresado es inválido";
                array_push($this->return, $error);
                $boolean = false;
            } else
                {
                $this->parameters["link"] = $link;
                $this->parameters_calendar["link"] = $link;
            }
        } else {
            $error = "Se precisa que sea ingresada un link de google calendar";
            array_push($this->return, $error);
            $boolean = false;
        }

        return $boolean;
    }

    public function validateAll($parameters) {
        $boolean = true;
        $count = count($parameters);
        if ( $count > 1 || ( $count = 1 && !empty( $parameters['photo']['name'] ) ) ) {
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
            $this->db->insert($this->table, $this->parameters_user);
            $rol_user["id_user"] = $this->parameters_user["id_user"];
            $rol_user["id_rol"] = "user";
            $this->db->insert("rol_user", $rol_user);

            if (isset($this->parameters_artist["id_artist"])) {
                $this->db->insert('artist', $this->parameters_artist);
                $rol_user["id_user"] = $this->parameters_artist["id_artist"];
                $rol_user["id_rol"] = "artist";
                $this->db->insert("rol_user", $rol_user);
            }

            if (isset($this->parameters_calendar["id_artist"])) {
                $this->db->insert('calendar_link', $this->parameters_calendar);
            }

            if (isset($this->parameters_medical["considerations"])) {
                $this->db->insert('medical_record', $this->parameters_medical);
            }

            $status = true;
        } else {
            $status = false;
        }
        array_push($this->return, $status);
        return $this->return;
    }

    public function validateUpdate($id_user, $parameters){
        $this->parameters["id_user"] = $id_user;
        $boolean = $this->validateAll($parameters);
        $count = count($parameters);
        $medical_record = isset($parameters["pathology"]);
        $artist = isset($parameters["artist"]);
        if ($boolean) {
            if ($medical_record) {
                $count = $count - 1;
                $medical_record = $this->db->simpleQuery("select * from $this->database.medical_record where id_user = :1", [$id_user]);
                if ($medical_record) {
                    $this->db->update("update $this->database.medical_record set considerations = :1 
                                    where id_user = :2;", [$this->parameters_medical["considerations"], $id_user]);
                } else {
                    $parameters_medical["id_user"] = $id_user;
                    $parameters_medical["considerations"] = $parameters["pathology"];
                    $this->db->insert('medical_record', $parameters_medical);
                }
            }
            if ($artist) {
                $count = $count - 2;
                $artist = $this->db->simpleQuery("select * from $this->database.artist where id_artist = :1", [$id_user]);
                if ($artist) {
                        $this->db->update("update $this->database.artist set txt = :1
                        where id_artist = :2;", [$parameters["txt"], $id_user]);
                } else {
                    $parameters_artist["id_artist"] = $id_user;
                    $parameters_artist["txt"] = $parameters["txt"];
                    $parameters_artist["id_local"] = $parameters["id_local"];
                    $this->db->insert('artist', $parameters_artist);
                }
            }
            if ( $count > 1 || ( $count = 1 && !empty( $parameters['photo']['name'] ) ) ) {
                //$this->db->genericUpdate($this->table, $id_user, $this->parameters_user);
                $this->db->userUpdate($this->table, $id_user, $this->parameters_user);
            }

            $status = true;
        } else {
            $status = false;
        }
        array_push($this->return, $status);
        return $this->return;
    }

    public function replace($array) {
        for ($i = 0; $i < count($array); $i++) {
            if (isset($array[$i]["photo"])) {
                $array[$i]["photo"] = base64_encode($array[$i]["photo"]);
            }
            if (isset($array[$i]["image"])) {
                $array[$i]["image"] = base64_encode($array[$i]["image"]);
            }
        }
        return $array;
    }

    public function autentication($id_user, $password) {
        $hash = $this->db->autentication($id_user);

        if (!is_null($hash)){
            $enabled = $this->isEnabled($id_user);
            if ($enabled){
                $verify = password_verify($password, $hash["password"]);
                if($verify){
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            }
        }else{
            return false;
        }
        
/*         $verify = password_verify($password, $hash["password"]);
        if ($verify) {
            $enabled = $this->isEnabled($id_user);
            if ($enabled){
                return true;
            }else{
                return false;
            }           
        } else {
            return false;
        } */
    }

    public function listArtists($id_local) {
        $artists = $this->db->query("select * from $this->database.$this->table as u
                                        inner join $this->database.artist as a on (u.id_user = a.id_artist)
                                        where a.id_local = :1 and u.enabled=1;", [$id_local]);
        return $this->replace($artists);
    }

    public function listUsers() {
        $users = $this->db->query("select u.*, a.id_artist, concat(l.direction, ', ', l.province, ', ', l.country) as 'local', a.txt
                                    from $this->database.$this->table as u
                                        left join $this->database.artist as a on (u.id_user = a.id_artist)
                                        left join $this->database.local as l on (a.id_local = l.id_local)
                                        where u.enabled =1
                                        order by id_artist asc, id_user asc");
        return $this->replace($users);
    }

    public function findUser($id_user) {
        $user = $this->db->simpleQuery("select u.*, a.id_artist, concat(l.direction, ', ', l.province, ', ', l.country) as 'local', a.txt, m.considerations
                                        from $this->database.$this->table as u
                                        left join $this->database.artist as a on (u.id_user = a.id_artist)
                                        left join $this->database.local as l on (a.id_local = l.id_local)
                                        left join $this->database.medical_record as m on (u.id_user = m.id_user)
                                        where u.id_user = :1 and u.enabled=1", [$id_user]);
        if (!is_null($user["photo"])) {
            $user["photo"] = base64_encode($user["photo"]);
        }
        if (is_null($user["considerations"])) {
            $user["considerations"] = "-";
        }
        return $user;
    }

    public function findArtist($id_artist) {
        $artist = $this->db->simpleQuery("select * from $this->database.$this->table as u
                                            inner join $this->database.artist as a on (u.id_user = a.id_artist)
                                            where id_artist = :1", [$id_artist]);
        if ($artist) {
            $artist["photo"] = base64_encode($artist["photo"]);
            $artist["tattoos"] = $this->replace($this->db->query("select * from $this->database.tattoo as t
                                                                    where t.id_artist = :1;", [$id_artist]));
        }
        return $artist;
    }

    public function findMedRec($id_user){
        return $this->db->query("select * from $this->database.medical_record where id_user = :1", $id_user);
    }

    public function verifyAdult($id_user) {
        $user = $this->db->simpleQuery("select * from $this->database.$this->table where id_user = :1", [$id_user]);
        $today = getdate();
        $year = $today["year"] - substr($user["born"],0,4);
        $month = $today["mon"] - substr($user["born"],5,2);
        $day = $today["mday"] - substr($user["born"],8,2);

        if (($year < 18) || ($year == 18 && $month < 0) || ($year == 18 && $month == 0 && $day < 0)) {  #si es menor de edad
            return false;
        } else {
            return true;
        }
    }

    public function isArtist($id_user, $id_local) {
        $boolean = true;
        $query = $this->db->simpleQuery("select * from $this->database.$this->table as u
                                        inner join $this->database.artist as a on (u.id_user = a.id_artist)
                                        where a.id_local = :1 and a.id_artist = :2
                                        and u.enabled is true", [$id_local, $id_user]);
        if (!$query) {
            $boolean = false;
        }
        return $boolean;
    }

    public function isAdmin($id_user, $id_local) {
        $boolean = true;
        $query = $this->db->simpleQuery("select * from $this->database.$this->table as u
                                        inner join $this->database.administrator as a on (u.id_user = a.id_administrator)
                                        where a.id_local = :1 and a.id_administrator = :2
                                        and u.enabled is true", [$id_local, $id_user]);
        if (!$query) {
            $boolean = false;
        }
        return $boolean;
    }

    public function isEnabled($id_user){
        $boolean = true;
        $query = $this->db->simpleQuery("select * from $this->database.$this->table where id_user = :1 and enabled =1", [$id_user]);
        if (!$query) {
            $boolean = false;
        }
        return $boolean;
    }

    public function havePermissions($id_user, $id_permission) {
        $boolean = true;
        $query = $this->db->simpleQuery("select * from $this->database.$this->table as u
                                        inner join $this->database.rol_user as rl on (u.id_user = rl.id_user)
                                        inner join $this->database.permission_rol as pr on (rl.id_rol = pr.id_rol)
                                        where u.id_user = :1 and pr.id_permission = :2", [$id_user, $id_permission]);
        if (!$query) {
            $boolean = false;
        }
        return $boolean;
    }

}