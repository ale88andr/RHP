<?php

use Environment\Core\Model;

class User extends Model
{
    public $name;

    public function __construct(){
        parent::__construct();
    }
}