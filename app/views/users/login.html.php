<?php

use Environment\Core\App;
use Environment\Core\Input;
use Environment\Helpers\Html;
use Environment\Helpers\Form;

App::setTitle('Login');
?>
<div class="row">
    <div class="col-md-4 col-md-offset-4">
        <?= include_once '_errors.html.php' ?>
        <?= Html::tag('h1', 'Login as users', ['class' => 'text-center text-warning'])?>
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
                <?= Form::label('users.password', 'Password :') ?>
                <?= Form::password('users.password', [
                    'class'         => 'form-control',
                    'autocomplete'  => 'off',
                    'placeholder'   => 'Type your password',
                ]);?>
            </div>
            <div class="text-center">
                <?= Form::submit('Login', ['class' => 'btn btn-lg btn-success']) ?>
            </div>
        </form>
    </div>
</div>
