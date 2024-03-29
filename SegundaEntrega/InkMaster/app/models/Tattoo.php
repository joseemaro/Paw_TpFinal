<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Tattoo extends Model
{
    protected $database = DB_NAME;
    protected $table = 'tattoo';
    protected $id;
    protected $id_artist;
    protected $sector;
    protected $image;
    protected $comment;
    protected $parameters;
    protected $return = array();

    public function validate_image($image) {
        $boolean = true;
        if (!empty($image["image"]["name"])) {
            $extension = $image["image"]["type"];
            $extension = strtolower($extension);
            if ($extension != 'image/png' && $extension != 'image/jpg' && $extension != 'image/jpeg') {
                $error = "Solo se permite archivos con extensión JPG y PNG.";
                array_push($this->return, $error);
                $boolean = false;
            } else {
                if ($image["image"]["size"] > 8000000) {
                    $count = count($this->return);
                    if ($count != 0) {
                        $error = "Solo se permite archivos menores o iguales a 8 MB.";
                        array_push($this->return, $error);
                        $boolean = false;
                    }
                } else {
                    $this->parameters["image"] = file_get_contents($image["image"]["tmp_name"]);
                }
            }
        }
        return $boolean;
    }

    function validate_sector($sector) {
        $boolean = true;
        $sector = strtolower($sector);
        if (!empty($sector) && ($sector != "cabeza" && $sector != "espalda" && $sector != "brazo" && $sector != "pecho" && $sector != "panza" && $sector != "costillas" && $sector != "pierna" && $sector != "pie" && $sector != "otro")){
            $error = "Sector inválido";
            array_push($this->return, $error);
            $boolean= false;
        } else {
            $this->parameters["sector"] = $sector;
        }
        return $boolean;
    }

    public function validate_txt($txt) {
        $this->parameters["txt"] = $txt;
        return true;
    }

    public function validate_artist($artist) {
        $this->parameters["id_artist"] = $artist;
        return true;
    }

    public function validateAll($parameters) {
        $boolean = true;
        if (!empty($parameters)) {
            foreach ($parameters as $parameter => $value) {
                $validate = "validate_" . $parameter;
                $boolean = $boolean && self::$validate($value); //aca esta el problema, en el ultimo parametro
            }
        }
        return $boolean;
    }

    public function validateInsert($parameters) { #realizar las validaciones y realizar el insert
        $boolean = $this->validateAll($parameters);
        $this->parameters["id_artist"] = $parameters["artist"];
        if ($boolean) {
            $this->db->insert($this->table, $this->parameters);
            $status = true;
        } else {
            $status = false;
        }
        array_push($this->return, $status);
        return $this->return;
    }

    public function getTattoos($beginning, $quantity) {

        $array = $this->db->getTattoos($this->table, $beginning, $quantity);    #probar cambiar esto por un query aca o en el mismo querybuilder

        for ($i = 0; $i < count($array); $i++) {
            $array[$i]["image"] = base64_encode($array[$i]["image"]);
        }
        return $array;
    }

    public function listTattoos() {
        return $this->db->selectAll( $this->table );
    }

    public function listTattoosFindArtist( $id_artist ) {
        $query = "select * from $this->database.$this->table
                    where id_artist = :1
                    order by id_tattoo asc;";
        return $this->db->query($query, [$id_artist]);
    }

    public function countTattoos() {
        return $this->db->countTuples($this->table);
    }

    public function verifyArtist( $id_tattoo, $id_artist ) {
        $count = $this->db->simpleQuery( "select count(*) as cant from $this->database.$this->table
                                                where id_artist = :1 and id_tattoo = :2;", [$id_artist, $id_tattoo] );
        if ( $count['cant'] > 0 ) {
            $bool = true;
        } else {
            $bool = false;
        }
        return $bool;
    }

    public function deleteTattoo( $id_tattoo ) {
        return $this->db->deleteFromID( "tattoo", $id_tattoo, "where id_tattoo = :id" );
    }
}

