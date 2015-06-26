<?php

use lib\session\Session;
use lib\environment\Environment;
use helpers\notice\NoticeHelper;
use helpers\json\JSONHelper;
use models\logs\Logs;
use models\accounts\Accounts;

function u_user_register () {

    $username = $_POST['username'];
    $email = $_POST['email'];

    $result = Accounts::register($username, $email, $email_ip = true);

    if ($result) {

        Logs::create('register', null, Environment::get('REMOTE_ADDR'), "New user registration: $username / $email");

        NoticeHelper::set('success', 'Verifica o teu email!');

        JSONHelper::respond([
            "action" => "register",
            "status" => "ok",
            "notice" => NoticeHelper::renderObject()
        ]);

    } else {

        JSONHelper::respond([
            "action" => "register",
            "status" => "ko",
            "notice" => NoticeHelper::renderObject()
        ]);

    }
}

?>
