<?

session_start();

require_once('router.php');

require_once('controllers/home.php');
require_once('controllers/sessions/new.php');
require_once('controllers/sessions/create.php');
require_once('controllers/sessions/destroy.php');
require_once('controllers/users/new.php');
require_once('controllers/users/create.php');
require_once('controllers/admin/index.php');
require_once('controllers/admin/configure.php');

$r = new Router();

$r->map('GET',  '/', 'home');
$r->map('GET',  '/login', 'sessions_new');
$r->map('POST', '/login', 'sessions_create');
$r->map('POST', '/logout', 'sessions_destroy');
$r->map('GET',  '/register', 'users_new');
$r->map('POST', '/register', 'users_create');
$r->map('GET',  '/admin', 'admin_index');
$r->map('POST', '/admin/configure', 'admin_configure');

$path = $_SERVER['PATH_INFO'];
if ($path == NULL) $path = '/';
$method = $_SERVER['REQUEST_METHOD'];

$x = $r->match($method, $path);

if ($x != NULL) $x();
// else 404

?>
