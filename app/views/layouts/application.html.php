<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?=$app->title('title')?></title>
    <!-- <link rel="stylesheet" href="style.css"> -->
    <!-- <script src="script.js"></script> -->
    <?//=Environment\Helpers\Html::importCss('app');?>
  </head>
  <body>
    <!-- page content -->
    <section id='content'>
      <?= $app->content ?>
    </section>
  </body>
</html>