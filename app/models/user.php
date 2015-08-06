<?php

use Environment\Core\Model;

class User extends Model
{
    // Validate rules
    public $validate = [
        'login' => [
            'length'        => ['in' => '3..60'],
            'uniqueness'    => 'users'
        ],
        'email' => [
            'uniqueness'    => 'users',
            'format'        => '/\A([^@\s]+)@((?:[-a-z0-9]+\.)`[a-z]{2,})\z/i'
        ],
        'password' => [
            'length'        => ['minimum' => 6],
            'confirmation'  => true
        ]
    ];

    public function __construct(){
        parent::__construct();
    }
}