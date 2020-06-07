<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Local extends Model
{
    protected $table = 'local';
    protected $id;
    protected $direction;
    protected $province;
    protected $country;
    protected $phone;
    protected $email;
    protected $description;
}
