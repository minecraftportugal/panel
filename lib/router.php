<?

namespace lib\router;

use lib\environment\Environment;

class Route {

    public function __construct($pattern, $value, $phpfile) {

        $this->_pattern = $pattern;
        $this->_value = $value;
        $this->_phpfile = $phpfile;

    }
}

class Router {

    public function __construct() {

        $this->_methods = [
            'GET' => [],
            'POST' => [],
            'PUT' => [],
            'DELETE' => [],
            'OPTIONS' => []
        ];

    }

    public function map ($methods, $pattern, $value, $phpfile = null) {

        if (!is_array($methods)) $methods = [$methods];

        foreach ($methods as $method) {

            $this->_methods[$method][] = new Route($pattern, $value, $phpfile);

        }

    }

    public function match($method, $key) {

        if (array_key_exists($method, $this->_methods)) {

            foreach ($this->_methods[$method] as $route) {

                if ($route->_pattern == $key) {

                    if (!is_null($route->_phpfile)) {
                        require_once($route->_phpfile);
                    }

                    return $route->_value;

                }

            }
        }

        return null;

    }

    public function dispatch() {

        $path = Environment::getPathInfo();

        $path = rtrim($path, '/');

        $method = Environment::get('request_method');

        $callback = $this->match($method, $path);

        // match route
        if (!is_null($callback)) {

            $callback();

        }

        // else 404
        else {

            require_once('controllers/v_404_not_found.php');

            v_404_not_found();

        }

    }
}

?>
