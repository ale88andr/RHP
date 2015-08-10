<?php
return [
    'root' => [
                'resource'  => 'home',
                'action'    => 'index',
    ],
    'main' => [
                'resource'  => 'home',
                // 'constraints' => ['id' => '([-_a-z0-9]+)'], // TODO: Need to make functionality
                'only'      => ['index', 'new'],
                'alias'     => ['index' => 'all', 'add' => 'new'],
    ],
    'users'=> [
                'only'      => ['register', 'logout'],
                'alias'     => ['register' => 'registration']
    ],
    'login' => [
                'resource'  => 'users',
                'action'    => 'login',
    ],
];