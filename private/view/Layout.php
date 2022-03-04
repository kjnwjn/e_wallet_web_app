<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?= getenv('BASE_URL') ?>style.css">
    <title><?= isset($data['title']) ? $data['title'] : 'Document' ?></title>
</head>

<body>
    <header class="w-100 p-4 d-flex justify-content-center align-items-center">
        <a class="mx-2" href="/">Home</a> |
        <a class="mx-2" href="/news">News</a> |
        <a class="mx-2" href="/404">Not Found</a> |
        <a class="mx-2" href="/login">Login</a> |
        <a class="mx-2" href="/security">Security page</a> |
        <a class="mx-2" href="/about">About</a>
    </header>
    <?php
    isset($data['page']) ?
        include('./private/view/pages/' . $data['page'] . '.php') : null
    ?>
</body>

<script src="<?= getenv('BASE_URL') ?>main.js"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

</html>