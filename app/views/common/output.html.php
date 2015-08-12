<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title><?=$code . ' ' . $status?></title>
</head>
<body>
<!-- page content -->
<section id='message'>
    <h1 style="color: #777;"><?= $code . ' ' . $status;?></h1>
    <p style="padding: 10px;background-color: #d9edf7;"><?= $message; ?></p>
</section>
</body>
</html>