<?

use lib\session\Session;

function news_index() {

    Session::validateSession();

    require('templates/news/index.php');
}

?>