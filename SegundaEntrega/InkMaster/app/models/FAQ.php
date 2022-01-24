<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;


class FAQ extends Model
{
    protected $database = DB_NAME;
    protected $table = 'faq';
    protected $id;
    protected $question;
    protected $answer;
    protected $summary;


public function listFaq() {
    return $this->db->selectAll( $this->table );
}

public function newVisit($id_faq){
    return $this->db->update("update $this->database.$this->table set visits = visits+1 
                                    where id_faq = :1;", [ $id_faq ]);
}

public function find($id_faq) {
    $id_faq = intval($id_faq);
    return $this->db->simpleQuery("select * from $this->database.$this->table where id_faq = :1", [$id_faq]);
}

public function select( $query ) {
    return $this->db->query( $query );
}

public function delFaq($id){
    return $this->db->delFaq($this->table, $id);
}

public function newFaq( $parameters ) {
    return $this->db->insert( $this->table, $parameters );
}

public function updateFaq( $id_faq, $parameters ) {
    return $this->db->update("update $this->database.$this->table set question = :1, summary = :2, answer = :3
                                    where id_faq = :4;", [ $parameters["question"], $parameters["summary"], $parameters["answer"], $id_faq]);
}

public function genSeoJsonFaq($faqs){
    $arrayaux = array();
    foreach ( $faqs["faqs"] as $faq ){
        $aux = array(
            "@type" => "Question",
            "name"=> $faq["question"],
            "acceptedAnswer"=> [
                "@type"=> "Answer",
                "text" => $faq["answer"]
            ]
        );
        array_push($arrayaux, $aux);
    };
    $obj = [
        "@context" => "https://schema.org",
        "@type" => "FAQPage",
        "mainEntity" => $arrayaux,
    ];
    $dataJson = json_encode($obj);
    $file = './public/js/SEO/seoFaqs.jsonld';
    file_put_contents($file, $dataJson);
    }
}