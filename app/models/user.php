<?php

use Environment\Core\Model;
use Environment\Core\Database;

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

    public static function current()
    {
        if(isset($_SESSION['users'])){
            $stmt = Database::connect();
            $stmt->query('SELECT * FROM users WHERE id = :id', ['id' => $_SESSION['users']]);
            return $stmt->results();
        } else {
            return false;
        }
    }
}