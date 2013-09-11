<?

session_start();

require_once('router.php');

require_once('controllers/home.php');
require_once('controllers/sessions/new.php');
require_once('controllers/sessions/create.php');
require_once('controllers/sessions/destroy.php');
require_once('controllers/users/new.php');
require_once('controllers/users/create.php');

$r = new Router();

$r->map('GET', '/', 'home');
$r->map('GET', '/login', 'sessions_new');
$r->map('POST', '/login', 'sessions_create');
$r->map('POST', '/logout', 'sessions_destroy');
$r->map('GET', '/register', 'users_new');
$r->map('POST', '/register', 'users_create');

$path = $_SERVER['PATH_INFO'];
if ($path == NULL) $path = '/';
$method = $_SERVER['REQUEST_METHOD'];

$x = $r->match($method, $path);

if ($x != NULL) $x();
// else 404

?>
