<?

use lib\session\Session;
use lib\template\Template;

function v_post() {

    Session::validateSession();

    $template = Template::init('posts/v_post', WP_LOCATION . '/wp-config.php');

    $template->assign('args', [
        'post_name' => 'novos-tesouros-no-limbo',//$_GET['id'],
        'posts_per_page' => 1
    ]);

    $template->render();

}

?>