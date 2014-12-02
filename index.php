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

/* Error Controllers */
require_once('controllers/v_403_forbidden.php');
require_once('controllers/v_404_not_found.php');
require_once('controllers/v_home.php');
require_once('controllers/v_test_pattern.php');


/* Home */
require_once('controllers/v_home.php');

/* Login / Logout */

require_once('controllers/sessions/v_login.php');
require_once('controllers/sessions/u_login.php');
require_once('controllers/sessions/u_logout.php');

/* * Users * */

/* Novo Registo */
require_once('controllers/users/v_user_register.php');
require_once('controllers/users/u_user_register.php');

/* Perfil e Configuração */
require_once('controllers/users/v_user.php');
require_once('controllers/users/u_user_configure.php');
require_once('controllers/users/v_user_options.php');
require_once('controllers/users/u_user_drops_drop.php');
require_once('controllers/users/u_user_drops_delete.php');
require_once('controllers/users/u_user_reset_password.php');
require_once('controllers/users/u_user_update_irc.php');
require_once('controllers/users/u_user_update_password.php');

/* Posts */
require_once('controllers/posts/v_post_posts.php');
require_once('controllers/posts/v_post.php');

/* Status */
require_once('controllers/status/v_status.php');


/* Directory */
require_once('controllers/directory/v_directory.php');

/* * Widgets * */
/* Players */
require_once('controllers/widgets/v_widget_players.php');

/* IRC */
require_once('controllers/irc/v_irc.php');



/* * Admin * */
/* Registar Utilizador */
require_once('controllers/admin/v_admin_register.php');
require_once('controllers/admin/u_admin_register.php');

/* Contas */
require_once('controllers/admin/v_admin_accounts.php');
require_once('controllers/admin/u_admin_accounts.php');

/* Sessões */
require_once('controllers/admin/v_admin_sessions.php');
require_once('controllers/admin/u_admin_sessions.php');

/* Drops */
require_once('controllers/admin/v_admin_drops.php');
require_once('controllers/admin/u_admin_drops.php');

/* Logs */
require_once('controllers/admin/v_admin_logs.php');
require_once('controllers/admin/u_admin_logs.php');

/* Endereços IP */
require_once('controllers/admin/v_admin_ip_addresses.php');

/* */

/* */
/* Test Purposes */
require_once('controllers/test/v_test.php');

/* Maps */
require_once('controllers/maps/index.php');

/* Launcher */
require_once('controllers/launcher/index.php');





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

/* Home */
$r->map('GET',  '', 'v_home');

/* Login / Logout */
$r->map('GET',  '/login', 'v_login');
$r->map('POST', '/login', 'u_login');
$r->map('POST', '/logout', 'u_logout');

/* * Utilizadores * */

/* Novo Registo */
$r->map('GET',  '/register', 'v_user_register');
$r->map('POST', '/register', 'u_user_register');

/* Perfil e Configuração */
$r->map('GET',  '/profile', 'v_user');
$r->map('GET',  '/options', 'v_user_options');
$r->map('POST', '/users/drop_items', 'u_user_drops_drop');
$r->map('POST', '/users/delete_drops', 'u_user_drops_delete');
$r->map('POST', '/users/configure', 'u_user_configure');
$r->map('POST', '/reset_password', 'u_user_reset_password');
$r->map('POST', '/users/update_password', 'u_user_update_password');
$r->map('POST', '/users/update_irc', 'u_user_update_irc'); // Should be a put -- LOL REST

/* Posts */
$r->map('GET',  '/posts', 'v_post_posts');
$r->map('GET',  '/posts/show', 'v_post');

/* Status */
$r->map('GET',  '/status', 'v_status');

/* Directory */
$r->map('GET',  '/directory', 'v_directory');

/* * Widgets * */
/* Players */
$r->map('GET', '/widgets/players', 'v_widget_players');

/* IRC */
$r->map('GET', '/irc', 'irc_index');



/* * Admin * */

/* Registar Utilizador */
$r->map('GET', '/admin/register', 'v_admin_register');
$r->map('POST', '/admin/register', 'u_admin_register');

/* Contas */
$r->map('GET',  '/admin/accounts', 'v_admin_accounts');
$r->map('POST', '/admin/accounts', 'u_admin_accounts');

/* Sessões */
$r->map('GET',  '/admin/sessions', 'v_admin_sessions');
$r->map('POST', '/admin/sessions', 'u_admin_sessions');

/* Drops */
$r->map('GET',  '/admin/drops', 'v_admin_drops');
$r->map('POST', '/admin/drops', 'u_admin_drops');

/* Logs */
$r->map('GET',  '/admin/logs', 'v_admin_logs');
$r->map('POST', '/admin/logs', 'u_admin_logs');

/* Endereços IP */
$r->map('GET',  '/admin/ip_addresses', 'v_ip_addresses');


/* Test Purposes */
$r->map('GET', '/test', 'test_index');

/* Maps */
$r->map('GET',  '/maps', 'maps_index');

/* Launcher */
$r->map('GET', '/launcher', 'launcher_index');

$r->map('GET', '/forbidden', 'forbidden');

$r->map('GET', '/testpattern', 'testpattern');

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
