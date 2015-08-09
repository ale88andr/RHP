<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Project name</a>
        </div>

        <div id="navbar" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <li class="active"><a href="#">Home</a></li>
                <li><a href="#about">About</a></li>
                <li><a href="#contact">Contact</a></li>
            </ul>

            <ul class="nav navbar-nav pull-right">
                <? $currentUser = User::current(); ?>
                <? if($currentUser): ?>
                    <li class="active"><a href="#">You login as: <?= $currentUser->login;?></a></li>
                    <li><?= \Environment\Helpers\Link::to('users/logout', 'Exit');?></li>
                <? else: ?>
                    <li class="active"><?= \Environment\Helpers\Link::to('users/login', 'Login');?></li>
                    <li><?= \Environment\Helpers\Link::to('users/register', 'Register');?></li>
                <? endif; ?>
            </ul>
        </div>
    </div>
</nav>