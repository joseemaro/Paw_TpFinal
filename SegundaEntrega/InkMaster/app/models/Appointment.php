<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Appointment extends Model
{
    protected $database = DB_NAME;
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
    protected $reference_images = array();
    protected $tattoo;
    protected $medical_record = array();

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
                /* $error = "La hora ingresada está fuera del horario laboral"; */
                $error = $hour;
                array_push($this->return, $error);
            } else {
                $this->parameters["hour"] = $hour;
                $boolean = true;
            }
        }
        return $boolean;
    }
    public function validate_hour_edit($hour) {
        $boolean = false;
        $pattern="/^([0][9]|[1][0-7])[\:]([0-5][0-9])[\:]*([0-5][0-9])*$/";
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
            $count = $this->db->simpleQuery("select count(*) as cant from $this->database.$this->table as ap
                                                where ap.id_artist = :1 and ap.date = :2 and ap.hour = :3;",
                                            [$id_artist, $this->parameters["date"], $this->parameters["hour"]]);
            //$count = $this->db->repeatAppointment($this->table, $id_artist, $this->parameters["date"], $this->parameters["hour"]);
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

    public function validate_reference_images($reference_images) {
        if (isset($reference_images["reference_image"])){
            $reference_images = $reference_images["reference_image"];
            $boolean = true;

        for ($i = 0; $i < count($reference_images["reference_image"]["name"]); $i++) {
            $extension = $reference_images["reference_image"]["type"][$i];
            $extension = strtolower($extension);
            if ($extension != 'image/png' && $extension != 'image/jpg' && $extension != 'image/jpeg') {
                $name = $reference_images["reference_image"]["name"][$i];
                $error = "Solo se permite archivos con extensión JPG y PNG, el cual el archivo $name no cumple"; 
                array_push($this->return, $error);
                $boolean = false;
            } else {
                if ($reference_images["reference_image"]["size"][$i] > 5000000) {
                    $count = count($this->return);
                    if ($count != 0) {
                        $error = "Solo se permite archivos menores o iguales a 10 MB.";
                        array_push($this->return, $error);
                        $boolean = false;
                    }
                } else {
                    $reference_image = file_get_contents($reference_images["reference_image"]["tmp_name"][$i]);
                    array_push($this->reference_images, $reference_image);
                }
            }
        }
        }else{
            $boolean = false;
        }
        

        return $boolean;
    }

    public function encode_images() {
        $array_images = array();
        foreach ($this->reference_images as $reference_image) {
            $reference_image = base64_encode($reference_image);
            array_push($array_images, $reference_image);
        }
        return $array_images;
    }

    public function validate_txt($txt) {
        $this->parameters["txt"] = addslashes($txt);
        return true;
    }

    public function validateAll($parameters = null) {
        $boolean = true;
        if (!is_null($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $validate = "validate_" . $parameter;
                $boolean = $boolean && self::$validate($value);
            }
        } else {
            $boolean = false;
        }
        return $boolean;
    }

    public function validateInsert($parameters) {
        $boolean = $this->validateAll($parameters);
        if ($boolean) {
            $this->parameters["status"] = 'pending';
            $this->db->insert($this->table, $this->parameters);
            $this->parameters["status"] = true;
            if (isset($parameters["reference_images"])){
                $id_appointment = $this->db->simpleQuery("select * from $this->database.$this->table where id_artist = :1 and date = :2 and hour = :3", [$this->parameters["id_artist"], $this->parameters["date"], $this->parameters["hour"]]);
                foreach ($this->reference_images as $image) {
                    $parameters_reference_image["id_appointment"] = $id_appointment["id_appointment"];
                    $parameters_reference_image["image"] = $image;
                    $this->db->insert("reference_image", $parameters_reference_image);
                }
                $this->parameters["reference_images"] = $this->encode_images();
            }

            return $this->parameters;
        } else {
            $this->return["status"] = false;

            return $this->return;
        }
    }

    public function validateUpdate($id_appointment, $date , $hour) {
        $appointment = $this->db->simpleQuery("select * from $this->database.$this->table
                                                where id_appointment = :1 and status <> 'annulled';", [$id_appointment]);
        if ($appointment) {
            $boolean = true;
            if (!is_null($date) && $boolean) {
                $boolean = $boolean && $this->validate_date($date);
            }
            if (!is_null($hour) && $boolean) {
                $boolean = $boolean && $this->validate_hour_edit($hour);
            }
            if ($boolean) {
                if (isset($this->parameters["date"])) {
                    $this->db->update("update $this->database.$this->table set date = :1
                                    where id_appointment = :2;", [$this->parameters["date"], $id_appointment]);
                }
                if (isset($this->parameters["hour"])) {
                    $this->db->update("update $this->database.$this->table set hour = :1
                                    where id_appointment = :2;", [$this->parameters["hour"], $id_appointment]);
                }
                $this->parameters = $this->findAppointment($id_appointment);

                $this->parameters["status"] = true;
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
        $sql = "select r.id_rol from $this->database.user as u
                inner join $this->database.rol_user as r on (u.id_user = r.id_user)
                where u.id_user = :1 and u.enabled is true
                and r.id_rol =";
        $query = "select *, 
                    case when CURDATE() <= date-2 then true 
                    else false end as edit
                    from $this->database.$this->table as a
                    inner join $this->database.user as u on (u.id_user = a.id_user)";
        if ($this->db->query("$sql 'artist'", [$id_user])) {
            return $this->db->query("$query where a.id_artist = :1
                                        order by a.status desc, a.date asc, a.hour asc;", [$id_user]);
        } elseif ($this->db->query("$sql 'administrator'", [$id_user])) {
            return $this->db->query("$query order by a.status desc, a.date asc, a.hour asc;");
        } elseif ($this->db->query("$sql 'user'", [$id_user])) {
            return $this->db->query("$query where a.id_user = :1
                                        order by a.status desc, a.date asc, a.hour asc;", [$id_user]);
        }
        return null;
    }

    public function changeStatus($id_appointment, $id_artist, $status){
        return $this->db->update("update $this->database.$this->table set status = :1 
                                    where id_appointment = :2 and id_artist = :3 
                                    and status = 'pending';", [$status, $id_appointment, $id_artist]);
    }

    public function cancelAp($id_appointment){
        return $this->db->update("update $this->database.$this->table set status = :1 
                                    where id_appointment = :2;", ['annulled', $id_appointment]);
    }

    public function findCalendar($id_artist){
        $tattoo = $this->db->simpleQuery("select * from $this->database.calendar_link
                                                    where id_artist = :1;", [$id_artist]);
        return $tattoo;
    }

    public function insertLink($id_appointment,$link,$id){
        return $this->db->update("update $this->database.$this->table set link = :1, id_calendar = :2
                                    where id_appointment = :3 ;", [$link,$id, $id_appointment]);
    }

    public function findAppointment($id_appointment){
        $appointment = $this->db->simpleQuery("select * from $this->database.$this->table as a
                                                inner join $this->database.user as u on (a.id_user = u.id_user)
                                                where a.id_appointment = :1;", [$id_appointment]);
        $tattoo = $this->db->simpleQuery("select * from $this->database.tattoo
                                                    where id_appointment = :1;", [$id_appointment]);
        if (isset($tattoo["image"])) {
            $appointment["tattoo"] = base64_encode($tattoo["image"]);
        }
        $reference_images = $this->db->query("select image from $this->database.reference_image
                                                    where id_appointment = :1;", [$id_appointment]);
        if ($reference_images) {
            foreach ($reference_images as $reference_image) {
                array_push($this->reference_images, $reference_image["image"]);
            }
            $appointment["reference_images"] = $this->encode_images();
        }

        return $appointment;
    }

    public function notifications_count( $id_user, $isArtist ) {
        if ( $isArtist ) {
            $query = "select count(*) as cant from $this->database.$this->table where id_artist = :1 and status = :2";
            $status = 'pending';
        } else {
            return false;
        }

        $count = $this->db->simpleQuery( $query, [$id_user, $status]);
        if ($count["cant"] > 0) {
            return $count["cant"];
        } else {
            return false;
        }
    }

    public function getAps( $id_user, $beginning, $quantity, $isArtist, $isAdmin ) {
        if ( $isArtist ) {
            return $this->db->querylimit( "select ap.*, u.phone, u.email from $this->database.$this->table as ap
                                        inner join $this->database.user as u on (u.id_user = ap.id_user)
                                        where ap.id_artist = :1
                                        order by ap.status desc, ap.date desc, ap.hour asc
                                        limit :beginning , :quantity", $beginning, $quantity, [ $id_user ] );
        } elseif ( $isAdmin ) {
            return $this->db->querylimit( "select ap.*, u.phone, u.email from $this->database.$this->table as ap
                                        inner join $this->database.user as u on (u.id_user = ap.id_user)
                                        order by ap.status desc, ap.date desc, ap.hour asc
                                        limit :beginning , :quantity", $beginning, $quantity );
        } else {
            return $this->db->querylimit( "select ap.*, u.phone, u.email from $this->database.$this->table as ap
                                        inner join $this->database.user as u on (u.id_user = ap.id_user)
                                        where ap.id_user = :1
                                        order by ap.status desc, ap.date desc, ap.hour asc
                                        limit :beginning , :quantity", $beginning, $quantity, [ $id_user ] );
        }
    }

}
