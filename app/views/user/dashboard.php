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
    <h1>Кабинет пользователя</h1>
    <div class="user-info">
        <h1>Привет, <?=$data['name']?></h1>
        <form action="/user/dashboard" method="post">
            <input type="hidden" name="exit_btn">
        <button class="btn" type="submit">Выйти</button>
        </form>
    </div>
</div>
</body>
</html>