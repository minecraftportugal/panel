<?

use lib\session\Session;

function v_post() {

    Session::validateSession();

    WordpressModel::init();

    require('templates/posts/v_post.php');

}

?>