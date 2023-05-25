<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Кабинет пользователя</title>
    <meta name="description" content="Кабинет пользователя" />
    <link rel="stylesheet" href="/public/css/main.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/user.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" type="text/css" charset="utf-8">
</head>
<body>
<?php require_once 'public/blocks/header.php'; ?>

<div class="container main">
    <h1>Редактировать профиль</h1>
    <div class="user-info">
        <form action="/user/edit" method="post" class="form-control">
            <p>Ваш логин:  <?=$data['name']?></p>
            <input type="text" name="new_name" placeholder="Введите новый логин" value="<?=$_POST['new_name']?>"><br>

            <p>Ваш телефон:  <?=$data['tel']?></p>
            <input type="text" name="new_tel" placeholder="Введите новый телефон" value="<?=$_POST['new_tel']?>"><br>

            <p>Ваша почта:  <?=$data['email']?></p>
            <input type="email" name="new_email" placeholder="Введите новый email" value="<?=$_POST['new_email']?>"><br>

            <label for="pass">Смена пароля</label>
            <input type="password" name="old_pass" placeholder="Введите старый пароль" value="<?=$_POST['old_pass']?>"><br>
            <input type="password" name="new_pass" placeholder="Введите новый пароль" value="<?=$_POST['new_pass']?>"><br>

            <div class="error"><?=$data['message']?></div>
            <button class="btn" id="send">Сменить</button>
        </form>
    </div>
</div>
</body>
</html>