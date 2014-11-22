<?
require_once('config.php');
require_once('lib/sessions.php');

function news_index() {
    global $cfg_wp_enabled, $cfg_wp_location, $cfg_wp_url;

    validateSession();

    require('templates/news/index.php');
}

?>