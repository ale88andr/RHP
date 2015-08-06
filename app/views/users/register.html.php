<?php

use Environment\Core\App;
use Environment\Core\Input;
use Environment\Core\Validate;
use Environment\Helpers\Html;
use Environment\Helpers\Link;
use Environment\Helpers\Form;
use Environment\Helpers\Date;
use Environment\Helpers\String;

App::setTitle('Register User');
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?= include '_errors.html.php' ?>
        <?= Html::tag('h1', 'Register new users', ['class' => 'text-center text-info'])?>
        <form action="" method="post">
            <div class="form-group">
                <?= Form::label('users.login', 'Username :') ?>
                <?= Form::text('users.login', [
                    'class'         => 'form-control',
                    'value'         => Input::find('users.login'),
                    'placeholder'   => 'Type your login',
                ]);?>
            </div>
            <div class="form-group">
                <?= Form::label('users.email', 'Email :') ?>
                <?= Form::email('users.email', [
                    'class'         => 'form-control',
                    'value'         => Input::find('users.email'),
                    'placeholder'   => 'Type your email',
                ]);?>
            </div>
            <div class="form-group">
                <?= Form::label('users.password', 'Password :') ?>
                <?= Form::password('users.password', [
                    'class'         => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Type your password',
                ]);?>
            </div>
            <div class="form-group">
                <?= Form::label('users.password_confirmation', 'Confirm password :') ?>
                <?= Form::password('users.password_confirmation', [
                    'class'         => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Retype your password',
                ]);?>
            </div>
            <div class="text-center">
                <?= Form::submit('Register', ['class' => 'btn btn-lg btn-warning']) ?>
            </div>
        </form>
    </div>
</div>
