<?

class Route {

    public function __construct($pattern, $value, $phpfile) {

        $this->_pattern = $pattern;
        $this->_value = $value;
        $this->_phpfile = $phpfile;

    }
}

class Router {

    public function __construct() {

        $this->_cenas = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => []
        ];

    }

    public function map ($methods, $pattern, $value, $phpfile = null) {

        if (!is_array($methods)) $methods = [$methods];

        foreach ($methods as $method) {

            $this->_cenas[$method][] = new Route($pattern, $value, $phpfile);

        }

    }

    public function match ($method, $key) {

        foreach ($this->_cenas[$method] as $route) {


            if ($route->_pattern == $key) {

               if (!is_null($route->_phpfile)) {
                   require_once($route->_phpfile);
               }

               return $route->_value;

            }

        }

    }

    public function dispatch() {

        $path = Environment::getPathInfo();

        $path = rtrim($path, '/');
        $method = Environment::getRequestMethod();

        $x = $this->match($method, $path);

        // match route
        if ($x != NULL) {

            $x();

        }

        // else 404
        else {

            require_once("controllers/v_404_not_found.php");
            v_404_not_found();

        }

    }
}

?>
