<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$app->title('title')?></title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <script src="script.js"></script> -->
    <?=Environment\Helpers\Html::useCdn('http://ajax.aspnetcdn.com/ajax/jQuery/jquery-2.1.4.min.js');?>
    <?=Environment\Helpers\Html::useCdn('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css');?>
    <?=Environment\Helpers\Html::useCdn('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js');?>
  </head>
  <body>
    <!-- page content -->
    <section id='content'>
      <?= $app->content ?>
    </section>
  </body>
</html>