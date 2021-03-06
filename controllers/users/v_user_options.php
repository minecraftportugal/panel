<?

use lib\session\Session;
use lib\template\Template;
use models\accounts\Accounts;
use helpers\notice\NoticeHelper;

function v_user_options() {

    Session::validateSession();

    $template = Template::init('users/v_user_options');

    $player = Accounts::first(["id" => Session::get("id")]);

    $notices = NoticeHelper::render();

    $template->assign('player', $player);

    $template->assign('notices', $notices);
    
    $xsrf_token = Session::getXSRFToken();

    $template->assign('xsrf_token', $xsrf_token);

    /* background images */
    $images = [
      ["name" => "Ilha Morena", "filename" => "bg5.jpg"],
      ["name" => "Limbo Church Night", "filename" => "bg6.jpg"],
      ["name" => "Na Colina", "filename" => "bg7.jpg"],
      ["name" => "Vila", "filename" => "bg8.jpg"],
    ];


    $template->assign('images', $images);

    $template->render();

}

?>
