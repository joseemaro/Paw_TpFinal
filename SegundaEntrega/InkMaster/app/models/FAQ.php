<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;


class FAQ extends Model
{
    protected $table = 'faq';
    protected $id;
    protected $question;
    protected $answer;
    protected $summary;


public function listFaq() {
    return $this->db->selectAll($this->table);
}

public function find($id) {
    $id = intval($id);
    return $this->db->findId($this->table, $id);
}

}