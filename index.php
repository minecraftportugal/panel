<?

session_start();

require_once('config.php');
require_once('bootstrap.php');
require_once('environment.php');
require_once('router.php');

require('lib/xauth.php');

/* Wordpress */
if (WP_ENABLED) {
    require_once(WP_LOCATION . "/wp-config.php");
}
require_once('models/wordpress.php');

require_once('models/account.php');
require_once('models/session.php');
require_once('models/drop.php');
require_once('models/log.php');

require_once('controllers/home.php');

require_once('controllers/status/index.php');

require_once('controllers/posts/index.php');
require_once('controllers/posts/show.php');

require_once('controllers/sessions/new.php');
require_once('controllers/sessions/create.php');
require_once('controllers/sessions/destroy.php');
require_once('controllers/sessions/configure.php');

require_once('controllers/users/new.php');
require_once('controllers/users/create.php');
require_once('controllers/users/show.php');
require_once('controllers/users/drop_items.php');
require_once('controllers/users/update.php');
require_once('controllers/users/configure.php');
require_once('controllers/users/options.php');
require_once('controllers/users/reset_password.php');

require_once('controllers/admin/ip_addresses.php');
require_once('controllers/admin/accounts.php');
require_once('controllers/admin/drops.php');
require_once('controllers/admin/sessions.php');
require_once('controllers/admin/configure.php');
require_once('controllers/admin/register.php');
require_once('controllers/admin/delete_drops.php');
require_once('controllers/admin/delete_logs.php');
require_once('controllers/admin/logs.php');

require_once('controllers/directory/index.php');

require_once('controllers/maps/index.php');

require_once('controllers/irc/index.php');

require_once('controllers/widgets/players.php');

require_once('controllers/launcher/index.php');

require_once('controllers/errors.php');

require_once('controllers/test/index.php');


require_once('helpers/mail.php');
require_once('helpers/flash.php');
require_once('helpers/pagination.php');
require_once('helpers/arguments.php');
require_once('helpers/notice.php');
require_once('helpers/minotar.php');
require_once('helpers/table.php');
require_once('helpers/dynmap.php');
require_once('helpers/datetime.php');

$r = new Router();

$r->map('GET',  '', 'home');

$r->map('GET',  '/status', 'status_index');

$r->map('GET',  '/login', 'sessions_new');
$r->map('POST', '/login', 'sessions_create');
$r->map('POST', '/logout', 'sessions_destroy');
$r->map('POST', '/sessions/configure', 'sessions_configure');

$r->map('GET',  '/register', 'users_new');
$r->map('GET',  '/profile', 'users_show');

$r->map('POST', '/register', 'users_create');
$r->map('POST', '/reset_password', 'users_reset_password');

$r->map('GET',  '/options', 'users_options_show');
$r->map('POST', '/users/update_irc', 'users_update_irc'); // Should be a put -- LOL REST
$r->map('POST', '/users/update_password', 'users_update_password');
$r->map('POST', '/users/configure', 'users_configure');
$r->map('POST', '/users/drop_items', 'users_drop_items');
$r->map('POST', '/users/delete_drops', 'users_delete_drops');

$r->map('GET',  '/admin/accounts', 'admin_accounts');
$r->map('GET',  '/admin/sessions', 'admin_sessions');
$r->map('GET',  '/admin/drops', 'admin_drops');
$r->map('GET',  '/admin/logs', 'admin_logs');
$r->map('GET',  '/admin/ip_addresses', 'admin_ip_addresses');

$r->map('GET',  '/posts', 'posts_index');
$r->map('GET',  '/posts/show', 'posts_show');

$r->map('POST', '/admin/configure', 'admin_configure');
$r->map('POST', '/admin/register', 'admin_register');
$r->map('POST', '/admin/delete_drops', 'admin_delete_drops');
$r->map('POST', '/admin/delete_logs', 'admin_delete_logs');

$r->map('GET',  '/directory', 'directory_index');

$r->map('GET',  '/maps', 'maps_index');

$r->map('GET',  '/widgets/players', 'widgets_players');

$r->map('GET', '/irc', 'irc_index');

$r->map('GET', '/launcher', 'launcher_index');

$r->map('GET', '/forbidden', 'forbidden');

$r->map('GET', '/testpattern', 'testpattern');

$r->map('GET', '/test', 'test_index');

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
