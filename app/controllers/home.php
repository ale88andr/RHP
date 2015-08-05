<?php

use Environment\Core\Controller;

class Home extends Controller
{
    public function index($id = '', $slug = ''){
//        $users = $this->model('User');
        $user->name = $id;
//        $result = $users->find(1, ['login', 'created_at']);
        // $result = $users->all(['login', 'created_at']);
        // var_dump($result);
        // $result = $users->insert(['login' => 'Mr.Douglass']);
        // // $result = $users->all(['login', 'created_at']);
        // $result2 = $users->update(['login' => 'Mr.Douglass'], ['name' => 'Michael']);
//        var_dump($result);
        // var_dump($result2);
        $this->render('index', ['name' => $user->name]);
    }

    public function add(){
        // App::setLayout('public');
        $this->render('add');
    }

    public function create($user = []) {
//        $model = $this->model('User');
        if(!$model->insert($user)) {
            throw new Exception('There was problem creating user.');
        }
    }
}