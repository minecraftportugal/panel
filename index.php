<?

session_start();

require_once('config.php');
require_once('bootstrap.php');
require_once('environment.php');
require_once('router.php');

if ($cfg_wp_enabled) {
  require_once("$cfg_wp_location/wp-config.php");
  $wp->init(); $wp->parse_request(); $wp->query_posts();
  $wp->register_globals(); $wp->send_headers();
}



require_once('controllers/home.php');
require_once('controllers/news/index.php');

require_once('controllers/sessions/new.php');
require_once('controllers/sessions/create.php');
require_once('controllers/sessions/destroy.php');
require_once('controllers/sessions/configure.php');

require_once('controllers/users/new.php');
require_once('controllers/users/create.php');
require_once('controllers/users/show.php');
require_once('controllers/users/skin.php');
require_once('controllers/users/drop_items.php');

require_once('controllers/users/update.php');
require_once('controllers/users/configure.php');
require_once('controllers/users/reset_password.php');

require_once('controllers/admin/index.php');
require_once('controllers/admin/configure.php');
require_once('controllers/admin/register.php');

require_once('controllers/directory/index.php');

require_once('controllers/maps/index.php');

require_once('controllers/irc/index.php');

require_once('controllers/webchat/index.php');

require_once('controllers/widgets/players.php');

require_once('controllers/errors.php');

require_once('lib/flash.php');


$r = new Router();

$r->map('GET',  '', 'home');
$r->map('GET',  '/news', 'news_index');

$r->map('GET',  '/login', 'sessions_new');
$r->map('POST', '/login', 'sessions_create');
$r->map('POST', '/logout', 'sessions_destroy');
$r->map('POST', '/sessions/configure', 'sessions_configure');

$r->map('GET',  '/register', 'users_new');
$r->map('GET',  '/profile', 'users_show');
$r->map('GET',  '/profile/skin', 'users_skin');
$r->map('POST', '/register', 'users_create');
$r->map('POST', '/reset_password', 'users_reset_password');

$r->map('POST', '/users/update_irc', 'users_update_irc'); // Should be a put -- LOL REST
$r->map('POST', '/users/update_password', 'users_update_password');
$r->map('POST', '/users/configure', 'users_configure');
$r->map('POST', '/users/drop_items', 'users_drop_items');
$r->map('POST', '/users/delete_drops', 'users_delete_drops');

$r->map('GET',  '/admin', 'admin_index');
$r->map('POST', '/admin/configure', 'admin_configure');
$r->map('POST', '/admin/register', 'admin_register');

$r->map('GET',  '/directory', 'directory_index');

$r->map('GET',  '/maps', 'maps_index');

$r->map('GET',  '/widgets/players', 'widgets_players');

$r->map('GET', '/irc', 'irc_index');
$r->map('GET', '/webchat', 'webchat_index');

$r->map('GET', '/forbidden', 'forbidden');

$path = getPathInfo();
$path = rtrim($path, '/');

$method = $_SERVER['REQUEST_METHOD'];

$x = $r->match($method, $path);

// match route
if ($x != NULL) {
	$x();
} 

// else 404
else {
	notfound();
}

?>
