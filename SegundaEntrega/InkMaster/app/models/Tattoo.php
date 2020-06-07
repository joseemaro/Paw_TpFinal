<?php

namespace App\models;

use App\Core\Model;
use App\Core\App;

class Tattoo extends Model
{
    protected $table = 'tattoo';
    protected $id;
    protected $appointment;
    protected $sector;
    protected $image;
    protected $comment;
}