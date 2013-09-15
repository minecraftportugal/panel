<?

session_start();

require_once('environment.php');
require_once('router.php');

require_once('controllers/home.php');
require_once('controllers/news/index.php');

require_once('controllers/sessions/new.php');
require_once('controllers/sessions/create.php');
require_once('controllers/sessions/destroy.php');

require_once('controllers/users/new.php');
require_once('controllers/users/create.php');
require_once('controllers/users/show.php');
require_once('controllers/users/skin.php');

require_once('controllers/users/update.php');
require_once('controllers/users/reset_password.php');

require_once('controllers/admin/index.php');
require_once('controllers/admin/configure.php');

require_once('controllers/irc/index.php');
require_once('controllers/webchat/index.php');

$r = new Router();

$r->map('GET',  '/', 'home');
$r->map('GET',  '/news', 'news_index');

$r->map('GET',  '/login', 'sessions_new');
$r->map('POST', '/login', 'sessions_create');
$r->map('POST', '/logout', 'sessions_destroy');

$r->map('GET',  '/register', 'users_new');
$r->map('GET',  '/profile', 'users_show');
$r->map('GET',  '/profile/skin', 'users_skin');
$r->map('POST', '/register', 'users_create');
$r->map('POST', '/reset_password', 'users_reset_password');
$r->map('POST', '/users/update', 'users_update'); // Should be a put

$r->map('GET',  '/admin', 'admin_index');
$r->map('POST', '/admin/configure', 'admin_configure');

$r->map('GET', '/irc', 'irc_index');
$r->map('GET', '/webchat', 'webchat_index');

$path = getPathInfo();
$method = $_SERVER['REQUEST_METHOD'];

$x = $r->match($method, $path);

if ($x != NULL) $x();
// else 404

?>
