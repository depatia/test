<?php

class User extends Controller {
    public function reg() {

        $data = [];
        if(isset($_POST['name'])) {
            $user = $this->model('UserModel');
            $user->setData($_POST['name'], $_POST['tel'], $_POST['email'], $_POST['pass'], $_POST['re_pass']);

            $isValid = $user->validForm();
            if($isValid == "Верно")
                $user->addUser();
            else
                $data['message'] = $isValid;
        }

        $this->view('user/reg', $data);
    }
    public function dashboard() {
        $data = [];
        $user = $this->model('UserModel');

        if(!isset($_COOKIE['login']))
            header("Location: /home/index");

        if(isset($_POST['exit_btn'])) {
            $user->logOut();
            exit();
        }

        $this->view('user/dashboard', $user->getUser());
    }

    public function edit() {
        $user = $this->model('UserModel');
        $data = $user->getUser();

            $user->getUserData($_POST['new_name'], $_POST['new_tel'], $_POST['new_email'], $_POST['old_pass'],
                $_POST['new_pass']);


        $isCorrect = $user->checkForm();
        if($isCorrect == "Верно")
            $user->editUser($data['id']);
        else
            $data['message'] = $isCorrect;

        if(!isset($_COOKIE['login']))
            header("Location: /home/index");


        $this->view('user/edit', $data);
    }

    public function auth() {
        if(isset($_POST['login'])) {
            $data = [];
            $user = $this->model('UserModel');
            $data['message'] = $user->auth($_POST['login'], $_POST['pass']);
        }

        $this->view('user/auth', $data);
    }
}