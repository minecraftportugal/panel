<?

use lib\session\Session;

function v_post_posts() {

    Session::validateSession();

    require('templates/posts/v_post_posts.php');
}

?>