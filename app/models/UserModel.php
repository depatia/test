<?php

    require 'DB.php';
class UserModel {
    private $name;
    private $tel;
    private $email;
    private $pass;
    private $re_pass;
    private $_db = null;

    public function __construct() {
        $this->_db = DB::getInstance();
    }

    public function setData($name, $tel, $email, $pass, $re_pass) {
        $this->name = $name;
        $this->tel = $tel;
        $this->email = $email;
        $this->pass = $pass;
        $this->re_pass = $re_pass;
    }



    public function validForm() {
        $result = $this->_db->query("SELECT * FROM `users`");
        $user = $result->fetch(PDO::FETCH_ASSOC);

        if(strlen($this->name) < 3)
            return "Логин слишком короткий";
        elseif($user['name'] == $this->name)
            return "Пользователь с таким логином уже зарегистрирован";
        elseif(strlen($this->tel) < 9)
            return "Телефон слишком короткий";
        elseif(!is_numeric($this->tel))
            return "Вы ввели не телефон";
        elseif($user['tel'] == $this->tel)
            return "Пользователь с таким телефоном уже зарегистрирован";
        elseif(strlen($this->email) < 5)
            return "Почта слишком короткая";
        elseif($user['email'] == $this->email)
            return "Пользователь с такой почтой уже зарегистрирован";
        elseif(strlen($this->pass) < 5)
            return "Пароль не менее 5 символов";
        elseif($this->pass != $this->re_pass)
            return "Пароли не совпадают";
        else
            return "Верно";
    }

    public function addUser() {
        $sql = "INSERT INTO users(name, tel, email, pass) VALUES(:name, :tel, :email, :pass)";

        $query = $this->_db->prepare($sql);

        $pass = password_hash($this->pass, PASSWORD_DEFAULT);
        $query->execute(['name' => $this->name, 'tel' => $this->tel, 'email' => $this->email, 'pass' => $pass]);

        $this->setAuth($this->email);
    }

    public function getUserData($new_name, $new_tel, $new_email, $old_pass, $new_pass) {
        $this->new_name = $new_name;
        $this->new_tel = $new_tel;
        $this->new_email= $new_email;
        $this->old_pass = $old_pass;
        $this->new_pass = $new_pass;
    }

    public function checkForm() {
        $checkUsers = $this->_db->query("SELECT * FROM `users`");
        $check = $checkUsers->fetch(PDO::FETCH_ASSOC);

        if($this->new_name != '' && strlen($this->new_name) < 3)
            return "Логин слишком короткий";
        elseif($this->new_name != '' && $check['name'] == $this->new_name)
            return "Пользователь с таким логином уже зарегистрирован";
        elseif($this->new_tel != '' && strlen($this->new_tel) < 9)
            return "Телефон слишком короткий";
        elseif($this->new_tel != '' && !is_numeric($this->new_tel))
            return "Вы ввели не телефон";
        elseif($this->new_tel != '' && $check['tel'] == $this->new_tel)
            return "Пользователь с таким телефоном уже зарегистрирован";
        elseif($this->new_email != '' && strlen($this->new_email) < 5)
            return "Почта слишком короткая";
        elseif($this->new_email != '' && $check['email'] == $this->new_email)
            return "Пользователь с такой почтой уже зарегистрирован";
        elseif($this->new_pass != '' && strlen($this->new_pass) < 5)
            return "Пароль не менее 5 символов";
        elseif($this->old_pass != '' && !password_verify($this->old_pass, $check['pass']))
            return "Неверный старый пароль";
        else
            return "Верно";
    }

    public function editUser($id) {
        $passhash = password_hash($this->new_pass, PASSWORD_DEFAULT);

        if($this->new_name != '') {
            $sql = "UPDATE users SET name = :name WHERE id = :id";
            $query = $this->_db->prepare($sql);
            $query->execute(['name' => $this->new_name, 'id' => $id]);
            header('Location: /user/dashboard');
        }
        if($this->new_tel != '') {
            $sql = "UPDATE users SET tel = :tel WHERE id = :id";
            $query = $this->_db->prepare($sql);
            $query->execute(['tel' => $this->new_tel, 'id' => $id]);
            header('Location: /user/dashboard');
        }
        if($this->new_email != '') {
            $sql = "UPDATE users SET email = :email WHERE id = :id";
            $query = $this->_db->prepare($sql);
            $query->execute(['email' => $this->new_email, 'id' => $id]);
            return $this->setAuth($this->new_email);
        }
        if($this->new_pass != '') {
            $sql = "UPDATE users SET pass = :pass WHERE id = :id";
            $query = $this->_db->prepare($sql);
            $query->execute(['pass' => $passhash, 'id' => $id]);
            header('Location: /user/dashboard');
        }
       }

    public function getUser() {
        $email = $_COOKIE['login'];
        $result = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$email'");
        return $result->fetch(PDO::FETCH_ASSOC);
    }
    public function logOut() {
        setcookie('login', $this->email, time() - 3600, '/');
        unset($_COOKIE['login']);
        header('Location: /user/auth');
    }

    public function auth($login, $pass) {
        $result = $this->_db->query("SELECT * FROM `users` WHERE `email` = '$login' OR `tel` = '$login'");
        $user = $result->fetch(PDO::FETCH_ASSOC);
        $email = $user['email'];

        if($user['email'] == '')
            return 'Пользователя с таким email или телефоном не существует';

        elseif(password_verify($pass, $user['pass']))
            $this->setAuth($email);

        else
            return 'Пароли не совпадают';
    }

    public function setAuth($email) {
        setcookie('login', $email, time() + 3600, '/');
        header('Location: /user/dashboard');
    }

}
