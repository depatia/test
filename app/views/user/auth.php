<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <meta name="description" content="Авторизация" />
    <link rel="stylesheet" href="/public/css/main.css" type="text/css" charset="utf-8">
    <link rel="stylesheet" href="/public/css/form.css" type="text/css" charset="utf-8">
    <script src="https://captcha-api.yandex.ru/captcha.js" defer></script>
</head>
<body>

<?php require_once 'public/blocks/header.php'; ?>
<div class="container main">
    <h1>Авторизация</h1>
    <form action="/user/auth" method="post" class="form-control">
        <input id="csrf_token" name="csrf_token" type="hidden" />
        <input type="text" name="login" placeholder="Введите email или телефон" value="<?=$_POST['login']?>"><br>
        <input type="password" name="pass" placeholder="Введите пароль" value="<?=$_POST['pass']?>"><br>
        <div
            style="height: 100px"
            id="captcha-container"
            class="smart-captcha"
            data-sitekey="ysc1_fFXPxzQ5fJAYhXlHS552SSQfcPcKBTlpMiVlAyLv83687ee6"
        ></div>

        <?php

        define('SMARTCAPTCHA_SERVER_KEY', 'ysc2_fFXPxzQ5fJAYhXlHS552EO7VIwQqjTBKcMElLr8V442dba2d');

        function check_captcha($token) {
            $ch = curl_init();
            $args = http_build_query([
                "secret" => SMARTCAPTCHA_SERVER_KEY,
                "token" => $token,
                "ip" => $_SERVER['REMOTE_ADDR'], // Нужно передать IP пользователя.
                // Как правильно получить IP зависит от вашего прокси.
            ]);
            curl_setopt($ch, CURLOPT_URL, "https://captcha-api.yandex.ru/validate?$args");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_TIMEOUT, 1);

            $server_output = curl_exec($ch);
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            if ($httpcode !== 200) {
                echo "Allow access due to an error: code=$httpcode; message=$server_output\n";
                return true;
            }
            $resp = json_decode($server_output);
            return $resp->status === "ok";
        }

        $token = $_POST['smart-token'];
        if (check_captcha($token)) {
            echo "Passed\n";
        } else {
            echo "Robot\n";
        }

        ?>
        <div class="error"><?=$data['message']?></div>
        <button class="btn" id="send">Авторизация</button>
    </form>

</body>
</html>