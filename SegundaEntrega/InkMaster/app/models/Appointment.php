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
    protected $return = array();

    public function validate_local($id_local) {
        $boolean = false;
        $count = $this->db->countTuples('local');
        $locals = $this->db->selectAll('local');
        if ($count == 0) {
            $error = "No se encuentran locales registrados";
            array_push($this->return, $error);
        } elseif ($count > 1) {
            foreach ($locals as $local) {
                if ($id_local == $local["id_local"]) {
                    $boolean = true;
                    $this->parameters["id_local"] = $id_local;
                }
            }
            if (!$boolean) {
                $error = "El local ingresado es inválido";
                array_push($this->return, $error);
            }
        } else {
            if ($locals["id_local"] == $id_local) {
                $boolean = true;
                $this->parameters["id_local"] = $id_local;
            } else {
                $error = "El local ingresado es inválido";
                array_push($this->return, $error);
            }
        }
        return $boolean;
    }

    public function validate_user($id_user) {
        $boolean = false;
        $count = $this->db->countTuples('user');
        $users = $this->db->selectAll('user');
        if ($count == 0) {
            $error = "No se encuentran usuarios registrados";
            array_push($this->return, $error);
        } elseif ($count > 1) {
            foreach ($users as $user) {
                if ($id_user == $user["id_user"]) {
                    $boolean = true;
                    $this->parameters["id_user"] = $id_user;
                }
            }
            if (!$boolean) {
                $error = "El usuario ingresado es inválido";
                array_push($this->return, $error);
            }
        } else {
            if ($users["id_user"] == $id_user) {
                $boolean = true;
                $this->parameters["id_user"] = $id_user;
            } else {
                $error = "El local ingresado es inválido";
                array_push($this->return, $error);
            }
        }
        return $boolean;
    }

    public function validate_date($date) {
        $boolean = false;
        if(empty($date)){
            $error = "No se ha indicado la fecha del turno";
            array_push($this->return, $error);
        } else {
            $today = getdate();
            $year = substr($date,0,4);
            $month = substr($date,5,2);
            $day = substr($date,8,2);
            if (($year < $today["year"]) || ($year == $today["year"] && $month < $today["mon"]) || ($year == $today["year"] && $month < $today["mon"] && $day <= $today["mday"])) {
                $error = "La reserva del turno debe ser realizada con por lo menos un día de anticipación";
                array_push($this->return, $error);
            } else {
                $days = array('0','1','2','3','4','5','6');
                $wday = $days[date('N', strtotime($date))];
                if ($wday == 0 || $wday == 6) {
                    $error = "Solo se pueden reservar turnos días de semana";
                    array_push($this->return, $error);
                } else {
                    $this->parameters["date"] = $date;
                    $boolean = true;
                }
            }
        }
        return $boolean;
    }

    public function validate_hour($hour) {
        $boolean = false;
        $pattern="/^([0][9]|[1][0-7])[\:]([0-5][0-9])$/";
        if (empty($hour)) {
            $error = "No se ha indicado el horario del turno";
            array_push($this->return, $error);
        } else {
            if (!preg_match($pattern, $hour)) {
                $error = "La hora ingresada está fuera del horario laboral";
                array_push($this->return, $error);
            } else {
                $this->parameters["hour"] = $hour;
                $boolean = true;
            }
        }
        return $boolean;
    }

    public function validate_artist($id_artist) {
        $boolean = false;
        $count_artists = $this->db->countTuples('artist');
        $artists = $this->db->selectAll('artist');
        if ($count_artists == 0) {
            $error = "No se encuentran artistas registrados";
            array_push($this->return, $error);
        } elseif ($count_artists > 1) {
            foreach ($artists as $artist) {
                if ($id_artist == $artist["id_artist"]) {
                    $boolean = true;
                }
            }
            if (!$boolean) {
                $error = "El usuario ingresado es inválido";
                array_push($this->return, $error);
            }
        } else {
            if ($artists["id_artist"] == $id_artist) {
                $boolean = true;
            } else {
                $error = "El local ingresado es inválido";
                array_push($this->return, $error);
            }
        }
        if ($boolean) {
            $count = $this->db->repeatAppointment($this->table, $id_artist, $this->parameters["date"], $this->parameters["hour"]);
            if ($count["cant"] > 0) {
                $boolean = false;
                $error = "Ya se encuentra un turno registrado en esta fecha y horario para este artista";
                array_push($this->return, $error);
            } else {
                $this->parameters["id_artist"] = $id_artist;
            }
        }
        return $boolean;
    }

    public function validate_image($reference_image) { #solo verificar tamaño y extension, solo hay que subir a la bd
        var_dump("entra a reference_image");
        $parameters["id_appointment"] = $this->parameters["id_appointment"];
        $parameters["image"] = $reference_image;
        $this->db->insert("reference_image", $parameters);
        $this->return["tatto"] = base64_encode($parameters["image"]);
        return true;
    }

    public function validate_medical($medical_record) { #validar el textarea
        var_dump("entra a medical_record");
        $parameters["id_user"] = $this->parameters["id_user"];
        $parameters["considerations"] = $medical_record;
        $this->db->insert("medical_record", $parameters);
        $this->return["medical_record"] = $parameters["considerations"];
        return true;
    }

    public function validate_tattoo($tattoo) { #validar el tattoo
        var_dump("entra a tattoo");
        $parameters["id_artist"] = $this->parameters["id_artist"];
        $parameters["id_appointment"] = $this->parameters["id_appointment"];
        $parameters["sector"] = $tattoo["sector"];
        $parameters["image"] = $tattoo["image"];
        $parameters["txt"] = $tattoo["txt"];
        $this->db->insert("tattoo", $parameters);
        $this->return["tatto"] = base64_encode($parameters["image"]);
        return true;
    }

    public function update() {  #insertar medical_record, reference_images y tattoo

    }

    public function validateAll($parameters = null, $reference_image = null, $medical_record = null, $tattoo = null) {
        $boolean = true;
        if (!is_null($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $validate = "validate_" . $parameter;
                $boolean = $boolean && self::$validate($value);
            }
        } else {
            $boolean = false;
        }
        if (!is_null($reference_image) && !$boolean) {
            $boolean = $boolean && self::validate_image($reference_image);
        }
        if (!is_null($medical_record) && !$boolean) {
            $boolean = $boolean && self::validate_medical($medical_record);
        }
        if (!is_null($tattoo) && !$boolean) {
            $boolean = $boolean && self::validate_tattoo($tattoo);
        }
        return $boolean;
    }

    public function validateInsert($parameters, $reference_image = null, $medical_record = null) {
        $boolean = $this->validateAll($parameters, $reference_image, $medical_record);
        if ($boolean) {
            $this->parameters["status"] = 'pending';
            $this->db->insert($this->table, $this->parameters);
            $this->parameters["status"] = true;

            return $this->parameters;
        } else {
            $this->return["status"] = false;

            return $this->return;
        }
    }

    public function validateUpdate($id_appointment, $reference_image = null, $medical_record = null, $tattoo = null) {
        $appointment = $this->db->simpleQuery("select * from inkmaster_db.$this->table
                                                where id_appointment = :1 and status <> 'annulled';", [$id_appointment]);
        if ($appointment) {
            $this->parameters = $this->db->simpleQuery("select * from inkmaster_db.$this->table where id_appointment = :1", [$id_appointment]);
            var_dump($this->parameters);
            $boolean = true;
            if (!is_null($reference_image) && $boolean) {
                $boolean = $boolean && $this->validate_image($reference_image);
            }
            if (!is_null($medical_record) && $boolean) {
                $boolean = $boolean && $this->validate_medical($medical_record);
            }
            if (!is_null($tattoo) && $boolean) {
                $boolean = $boolean && $this->validate_tattoo($tattoo);
            }
            if ($boolean) {
                $this->update();
                $this->parameters["status"] = true;

                $this->parameters = $this->findAppointment($id_appointment);
                return $this->parameters;
            } else {
                $this->return["status"] = false;

                return $this->return;
            }
        }
        $error = "El turno que desea modificar se encuentra anulado";
        array_push($this->return, $error);
        $this->return["status"] = false;
        return $this->return;
    }

    public function encodeImages($array) {
        for ($i = 0; $i < count($array); $i++) {
            if (isset($array[$i]["image"])) {
                $array[$i]["image"] = base64_encode($array[$i]["image"]);
            }
        }
        return $array;
    }

    public function listAppointments($id_user) {
        $sql = "select r.id_rol from inkmaster_db.user as u
                inner join inkmaster_db.rol_user as r on (u.id_user = r.id_user)
                where u.id_user = :1 and u.enabled is true
                and r.id_rol =";
        if ($this->db->query("$sql 'artist'", [$id_user])) {
            return $this->db->query("select * from inkmaster_db.$this->table as a 
                                        inner join inkmaster_db.user as u on (u.id_user = a.id_user)
                                        where a.id_artist = :1
                                        order by a.status desc, a.date asc, a.hour asc;", [$id_user]);
        } elseif ($this->db->query("$sql 'administrator'", [$id_user])) {
            return $this->db->query("select * from inkmaster_db.$this->table as a
                                        inner join inkmaster_db.user as u on (a.id_user = u.id_user)
                                        order by a.status desc, a.date asc, a.hour asc;");
        } elseif ($this->db->query("$sql 'user'", [$id_user])) {
            return $this->db->query("select * from inkmaster_db.$this->table as a
                                        inner join inkmaster_db.user as u on (a.id_user = u.id_user)
                                        where a.id_user = :1
                                        order by a.status desc, a.date asc, a.hour asc;", [$id_user]);
        }
        return null;
    }

    public function changeStatus($id_appointment, $id_artist, $status){
        return $this->db->update("update inkmaster_db.$this->table set status = :1 
                                    where id_appointment = :2 and id_artist = :3 
                                    and status = 'pending';", [$status, $id_appointment, $id_artist]);
    }

    public function findAppointment($id_appointment){
        $appointment = $this->db->simpleQuery("select * from inkmaster_db.$this->table as a
                                                inner join inkmaster_db.user as u on (a.id_user = u.id_user)
                                                where a.id_appointment = :1;", [$id_appointment]);
        $tattoo = $this->db->simpleQuery("select * from inkmaster_db.tattoo
                                                    where id_appointment = :1;", [$id_appointment]);
        if (isset($tattoo["image"])) {
            $tattoo["image"] = base64_encode($tattoo["image"]);
        }
        if ($tattoo) {
            $appointment["tattoo"] = $tattoo;
        }
        $reference_images = $this->db->query("select * from inkmaster_db.reference_image
                                                    where id_appointment = :1;", [$id_appointment]);
        if ($tattoo) {
            $appointment["reference_images"] = $this->encodeImages($reference_images);
        }
        return $appointment;
    }

}
