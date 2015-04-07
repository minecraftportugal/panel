<?

use lib\session\Session;
use lib\template\Template;
use models\account\variables\AccountVariables;
use helpers\notice\NoticeHelper;

function u_user_bootstrap() {

    Session::validateSession();
    Session::validateXSRFToken();

    return;

    $parameters = ArgumentsHelper::process($_POST, [
        "data" => null,
    ]);

    if (!is_null($parameters["data"])) {

        $status = AccountVariables::setValue(Session::get("id"), "bootstrap", $parameters["data"]);

        if ($status) {
            Template::json(["status" => "ok"]);
        } else {
            Template::json(["status" => "ko"]);
        }

    }

}

?>
