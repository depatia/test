<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация</title>
    <meta name="description" content="Регистрация" />
    <link rel="stylesheet" href="/public/css/main.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" type="text/css" charset="utf-8">
</head>
<body>
<?php require_once 'public/blocks/header.php'; ?>

<div class="container main">
    <h1>Регистрация</h1>
    <form action="/user/reg" method="post" class="form-control">
        <input type="text" name="name" placeholder="Введите логин" value="<?=$_POST['name']?>"><br>
        <input type="text" name="tel" placeholder="Введите телефон" value="<?=$_POST['tel']?>"><br>
        <input type="email" name="email" placeholder="Введите email" value="<?=$_POST['email']?>"><br>
        <input type="password" name="pass" placeholder="Введите пароль" value="<?=$_POST['pass']?>"><br>
        <input type="password" name="re_pass" placeholder="Подтвердите пароль" value="<?=$_POST['re_pass']?>"><br>
        <div class="error"><?=$data['message']?></div>
        <button class="btn" id="send">Регистрация</button>
    </form>
</div>
</body>
</html>