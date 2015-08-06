<?php

use Environment\Core\Controller;
use Environment\Core\Route;
use Environment\Core\Validate;
use Environment\Core\Input;
use Environment\Core\Database;
use Environment\Helpers\Params;
use Environment\Helpers\Hash;

class Users extends Controller
{
    private $errors = [];

    public function login()
    {
        if(Input::isSubmit('post')){
            if($this->loginUser(Input::find('users'))){
                Route::to('index:root');
            } else {
                $this->errors[] = 'User Or Password Incorrect';
                $this->render('login', ['errors' => $this->errors]);
            }
        } else {
            $this->render('login');
        }
    }

    public function register()
    {
        if(Input::isSubmit('post')){
            if ($this->createUser(Input::find('users'))) {
                Route::to('index:root');
            } elseif (!empty($this->errors)){
                $this->render('register', ['errors' => $this->errors]);
            }
        }
        $this->render('register');
    }

    public function createUser($user = [])
    {
        $model = $this->model();

        $check = new Validate();
        $params = $check->validates($user,$this->model()->validate);
        if($params->isValid()) {
            $user['password'] = password_hash(Hash::get($user, 'password'), PASSWORD_DEFAULT);
            try {
                $model->insert(Params::permit($user, ['login', 'email', 'password']));
                $this->loginUser(['login' => Hash::get($user, 'login'), 'password' => Hash::get($user, 'password_confirmation')]);
                return true;
            } catch (Exception $e){
                echo $e->getMessage();
                return false;
            }
        } else {
            $this->errors = $params->errors();
            return false;
        }
    }

    public function loginUser($user = [])
    {
        $model = $this->model();
        try {
            $result = $model->find(['login' => $user['login']]);
            if(!empty($result)){
                if(password_verify(Hash::get($user, 'password'), $result->password)){
                    $_SESSION['users'] = $result->id;
                    return true;
                } else {
                    return false;
                }
            }
        } catch(Exception $e) {
            echo $e->getMessage();
            return false;
        }
    }

    public static function current()
    {
        $stmt = Database::connect();;
        if(isset($_SESSION['users'])){
            $stmt->prepare('SELECT * FROM users WHERE id = :id');
            $stmt->execute(array(':id', $_SESSION['user']));
            return $stmt->fetch(PDO::FETCH_OBJ);
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