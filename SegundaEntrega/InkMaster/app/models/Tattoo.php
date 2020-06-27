<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Tattoo extends Model
{
    protected $table = 'tattoo';
    protected $id;
    protected $id_artist;
    protected $sector;
    protected $image;
    protected $comment;

    public function validateInsert($parameters) { #realizar las validaciones y realizar el insert
        return $parameters;
    }

    public function getTattoos($beginning, $quantity) {
        return $this->db->getTattoos($this->table, $beginning, $quantity);
    }

    public function countTattoos() {
        return $this->db->countTuples($this->table);
    }
}

