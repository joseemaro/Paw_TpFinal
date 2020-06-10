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
    protected $age;
    protected $num_doc;
    protected $phone;
    protected $direction;
    protected $email;
    protected $photo;
    protected $artist;
    protected $description;

    public function newUser($post) {
        //hacer validaciones y ahi cargar el $parametros
        $parametros = array();
        $this->id = $post["id_user"];
        $parametros["id_user"] = $post["id_user"];
        $this->id = $post["password"];
        $parametros["password"] = $post["password"];
        $this->id = $post["first_name"];
        $parametros["first_name"] = $post["first_name"];
        $this->id = $post["last_name"];
        $parametros["last_name"] = $post["last_name"];
        $this->id = $post["age"];
        $parametros["age"] = $post["age"];
        $this->id = $post["num_doc"];
        $parametros["num_doc"] = $post["num_doc"];
        $this->id = $post["phone"];
        $parametros["phone"] = $post["phone"];
        $this->id = $post["direction"];
        $parametros["direction"] = $post["direction"];
        $this->id = $post["email"];
        $parametros["email"] = $post["email"];
        $this->db->insert($this->table, $parametros);

        return "roto pero tranquilo que está hardcodeado";
    }
    public function find($id_user, $password) {
        $sql = "select count(*) from $this->table where id_user = :1 and password = :2";
        //return $this->db->findUser($this->table, $id_user, $password);
        return $this->db->query($sql, $id_user, $password);
    }

    public function listArtist() {
        return $this->db->findArtist($this->table);
    }
}