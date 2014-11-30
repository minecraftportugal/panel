<?

use lib\session\Session;

function posts_show() {

    Session::validateSession();

    require('templates/posts/show.php');
}

?>