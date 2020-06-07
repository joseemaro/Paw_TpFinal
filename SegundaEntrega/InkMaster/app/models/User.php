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
}