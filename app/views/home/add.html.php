<?php

use Environment\Core\App;
use Environment\Core\Input;
use Environment\Core\Validate;
use Environment\Helpers\Html;
use Environment\Helpers\Link;
use Environment\Helpers\Form;
use Environment\Helpers\Date;
use Environment\Helpers\String;

    App::setTitle('Add users');
    Input::find('users.login');
    if(Input::isSubmit()){
        // echo Input::find('username');
        $check = new Validate;
        $validates_result = $check->validates($_POST['users'], [
            'login' => [ 'presence' => true,
                            'length' => ['minimum' => 3, 'maximum' => 50], // ['in' => '3..50', 'is' => 6]
                            // 'length' => ['in' => '6..50'],
                            // 'length' => ['minimum' => 6, 'maximum' => 10],
                            // 'length' => ['is' => 7],
                            // 'inclusion' =>  ['www', 'us', 'ca', 'jp'],
                            'uniqueness' => 'users'
                            ],
            'password' => [ 'presence' => true,
                            'length' => ['minimum' => 3],
                            'confirmation' => true,
                            // 'numericality' => true
                            ],
            // 'email' => ['format' => '/\A([^@\s]+)@((?:[-a-z0-9]+\.)`[a-z]{2,})\z/i'],
            ]);
        if($validates_result->isValid()){
            $user = new Home();

            try {
                $user->create([
                        'login' => Input::find('login'),
                        'email' => Input::find('email'),
                        'password' => Input::find('password'),
                        'group_id' => 1,
                    ]);

                Redirect::to([  'controller' => 'home',
                                'action' => 'index',
                                'params' => []
                            ]);
            } catch(Exception $e) {
                die($e->getMessage);
            }
        } else {
            echo '<div class="errors">';
            foreach ($validates_result->errors() as $error) {
                echo $error . '</br>';
            }
            echo '</div>';
        }
    }
?>

<form action="" method="post">
    <?= Html::tag('h1', 'H1 content', ['class' => 'h1_html'])?>
    <?= Link::to('home', 'Home page', ['class' => 'h1_html'])?>
    <div class="field">
        <!-- <label for="login">Username</label> -->
        <?= Form::label('users.login', 'Username') ?>
        <?= Form::text('users.login', [
                                    'value' => Input::find('users.login'),
                                    'autocomplete' => 'off',
                                ]);?>
        <!-- <input type="text" name="login" class="login" id="login" value="<?= Input::find('login'); ?>" autocomplete="off"> -->
    </div>

    <div class="field">
        <?= Form::label('users.email', 'Email') ?>
        <?= Form::email('users.email', ['value' => Input::find('users.email')]);?>
        <!-- <input type="email" name="email" class="email" id="email" value="<?= Input::find('email'); ?>" autocomplete="off"> -->
    </div>

    <div class="field">
        <?= Form::label('users.password', 'Type your password') ?>
        <?= Form::password('users.password');?>
        <!-- <label for="password">Type your password</label>
        <input type="password" name="password" class="password" id="password"> -->
    </div>

    <div class="field">
        <?= Form::label('users.password_confirmation', 'Retype your password') ?>
        <?= Form::password('users.password_confirmation');?>
        <!-- <label for="password_confirmation">Retype your password</label>
        <input type="password" name="password_confirmation" class="password" id="password_confirmation"> -->
    </div>

    <div class="field">
        <?= Form::label('users.age', 'Type your age: ') ?>
        <?= Form::numeric('users.age', 5, 100, 1);?>
    </div>

    <div class="field">
        <?= Form::label('users.country', 'Choose your country: ') ?>
        <?= Form::select('users.country', ['Russia', 'Ukraine', 'China']);?>
    </div>

    <div class="field">
        <?= Form::label('users.sex', 'Choose your country: ') ?>
        <?= Form::check_box('users.sex', ['male' => 'Man', 'female' => 'Women'], 'male', [], true);?>
    </div>

    <div class="field">
        <?= Form::label('users.sex', 'Choose your sex: ') ?>
        <?= Form::radio('users.sex', ['male' => 'Man', 'female' => 'Women'], 'male');?>
    </div>

    <div class="field">
        <?= Form::label('users.born', 'Select your bithday: ') ?>
        <?= Form::date('users.born', '1940-01-01');?>
    </div>

    <div class="date">
        <?= Date::current(true, '-') ?>
        <?= Date::now() ?>
        <?= Date::year() ?>
        <?= Date::diff('01.01.2015', '01.01.2016') ?>
    </div>

    <?= Form::hidden('users.surname', Input::find('users.login')) ?>
    <?= String::capitalize(Input::find('users.login')) ?>

    <?= Form::submit('Register') ?>
    <!-- <input type="submit" value="Register"> -->
</form>