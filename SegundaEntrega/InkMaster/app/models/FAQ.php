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
}