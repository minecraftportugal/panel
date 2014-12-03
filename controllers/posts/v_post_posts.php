<?

use models\wordpress\WordpressModel;
use lib\session\Session;

function v_post_posts() {

    Session::validateSession();

    WordpressModel::init();

    require('templates/posts/v_post_posts.php');
}

?>