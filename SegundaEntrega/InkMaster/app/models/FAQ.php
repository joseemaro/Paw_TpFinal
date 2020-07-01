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

public function delFaq($id){
    return $this->db->delFaq($this->table, $id);
}

public function newFaq($parameters){
        return $this->db->insert($this->table, $parameters);
}

public function updateFaq($id_faq,$parameters){
    return $this->db->updFaq($this->table, $id_faq, $parameters);
}

}