<?php

use Environment\Core\Controller;
use Environment\Core\Route;

class Users extends Controller
{

    public function login()
    {
        if(isset($_POST['users'])){
            if($this->loginUser($_POST['users'])){
                Route::to('index:root');
            } else {
                $error = '<br><br><br> User Or Password Incorrect';
                $this->render('login', ['error' => $error]);
            }
        } else {
            $this->render('login');
        }
    }

    public function register()
    {
        if(isset($_POST['users'])){
            if($this->createUser($_POST['users'])){
                Route::to('index:root');
            } else {
                $error = '<br><br><br> Something went wrong';
                $this->render('login', ['error' => $error]);
            }
        }
        $this->render('register');
    }

    public function createUser($user = [])
    {
        $user = $this->model();
        if(!empty($user)){
            $user['password'] = password_hash($user['password'], PASSWORD_DEFAULT);
            try {
                $user->insert($user);
                return true;
            } catch (Exception $e){
                echo $e->getMessage();
                return false;
            }
        }
    }

    public function loginUser($user = [])
    {
        $model = $this->model();
        try {
            $result = $model->find(['login' => $user['login']]);
            if(!empty($result)){
                if(password_verify($user['password'], $result['password'])){
                    $_SESSION['users'] = $result['id'];
                    return true;
                } else {
                    return false;
                }
            }
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    public function current_user()
    {
        $user = $this->model('User');
        if(isset($_SESSION['users'])){
            return $user->find(['id' => $_SESSION['users']]);
        } else {
            return false;
        }
    }

    public function logout()
    {
        session_destroy();
        unset($_SESSION['users']);
        return true;
    }
}