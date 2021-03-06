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

public function newVisit($id_faq){
    return $this->db->simpleQuery("update inkmaster_db.$this->table set visits=visits+1 where id_faq = :1", [ $id_faq]);
}

public function find($id_faq) {
    $id_faq = intval($id_faq);
    return $this->db->simpleQuery("select * from inkmaster_db.$this->table where id_faq = :1", [$id_faq]);
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