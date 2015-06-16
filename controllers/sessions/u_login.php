<?

use lib\session\Session;
use lib\environment\Environment;
use models\logs\Logs;
use helpers\notice\NoticeHelper;
use helpers\json\JSONHelper;

function u_login() {

    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $valid = Session::validateLogin($username, $password);

    if ($valid) {

        Logs::create('login', Session::get('id'), Environment::get('REMOTE_ADDR'), "");

        NoticeHelper::set('success', 'yay!');

        JSONHelper::respond([
            "action" => "login",
            "status" => "ok",
            "notice" => NoticeHelper::renderObject()
        ]);

    } else {

        Logs::create('failed_login', null, Environment::get('REMOTE_ADDR'), "Username: $username, Password: $password");

        NoticeHelper::set('error', 'username/password inválidos');

        JSONHelper::respond([
            "action" => "login",
            "status" => "ko",
            "notice" => NoticeHelper::renderObject()
        ]);

    }
}

?>
