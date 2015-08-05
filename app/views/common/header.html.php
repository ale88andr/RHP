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
                <li class="active"><?= \Environment\Helpers\Link::to('users/login', 'Login');?></li>
                <li><?= \Environment\Helpers\Link::to('users/register', 'Register');?></li>
            </ul>
        </div>
    </div>
</nav>