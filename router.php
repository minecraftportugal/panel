<?

class Router {

  public function __construct () {
  $this->_cenas = [
      'GET' => [],
      'POST' => [],
      'PUT' => [],
      'DELETE' => []
    ];
  }

  public function map ($methods, $pattern, $value) {
    if (!is_array($methods)) $methods = [$methods];

    foreach ($methods as $method) {
      $this->_cenas[$method][] = [$pattern, $value];
    }
  }

  public function match ($method, $key) {
    foreach ($this->_cenas[$method] as $x) {
      list($pattern, $value) = $x;
      if ($pattern == $key) {
        return $value;
      }
    }
  }
}

?>
