<?

use lib\session\Session;
use lib\template\Template;

function v_post() {

    Session::validateSession();

    $template = Template::init("posts/v_post");

    WordpressModel::init();

    $template->render();

}

?>