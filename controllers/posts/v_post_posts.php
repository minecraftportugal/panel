<?

use lib\session\Session;
use lib\template\Template;

function v_post_posts() {

    Session::validateSession();

    $template = Template::init('posts/v_post_posts', WP_LOCATION . '/wp-config.php');

    $template->assign('args', [
        //'cat' => 13,
        'posts_per_page' => 10
    ]);

    $template->render();

}

?>
