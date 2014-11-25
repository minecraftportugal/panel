<?
require_once('lib/sessions.php');

function posts_index() {

    validateSession();

    require('templates/posts/index.php');
}

?>