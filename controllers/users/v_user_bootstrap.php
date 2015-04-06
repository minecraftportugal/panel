<?

use lib\session\Session;
use lib\template\Template;
use models\account\variables\AccountVariables;
use helpers\arguments\ArgumentsHelper;

function v_user_bootstrap() {

    Session::validateSession();


    $parameters = ArgumentsHelper::process($_GET, [
        "timestamp" => 0,
    ]);

    $default = [
        "timestamp" => $parameters['timestamp'],
        "widgets" => null,
        "desktop" => null
    ];

    $json = AccountVariables::getValue(Session::get("id"), "bootstrap");
    $json = json_decode($json, true);
    if (is_null($json)) {
        $json = json_encode($default);
    }

    Template::json($json);

}

?>
