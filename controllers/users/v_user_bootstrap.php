<?

use lib\session\Session;
use lib\template\Template;
use models\account\variables\AccountVariables;
use helpers\notice\NoticeHelper;

function v_user_bootstrap() {

    Session::validateSession();

    $default = [
        "background" => [
            "image" => "http://www.nocturnar.com/imagenes/fondos-de-pantalla-de-minecraft-Steve-Minecraft-Wallpapers-HD-Wallpaper.jpg",
            "backgroundRepeat" => "no-repeat",
            "backgroundPosition" => "center center",
            "backgroundAttachment" => "fixed",
            "backgroundSize" => "cover"
        ],
        "sounds" => true
    ];

    $json = AccountVariables::getValue(Session::get("id"), "userdata");
    $json = json_decode($json, true);
    if (is_null($json)) {
        $json = json_encode($default);
        AccountVariables::setValue(Session::get("id"), "userdata", $json);
    }

    header('Content-Type: application/json');
    echo $json;

}

?>
