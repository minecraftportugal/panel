<?
require_once('lib/sessions.php');

function posts_show() {

    validateSession();

    require('templates/posts/index.php');
}

?>