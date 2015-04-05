<?

namespace lib\template;

class Template {

    public function __construct($name, $require = null) {

        $this->_name = "templates/$name.php";
        $this->_require = $require;
        $this->_map = [];

        assert(file_exists($this->_name));

    }

    public function __toString() {

        ob_start();

        $this->render();

        $result = ob_get_contents();

        ob_end_clean();

        return $result;
    }

    public function assign($variable, $value) {
        
        $this->_map[$variable] = $value;

    }
    
    public function render($http_response_code = null) {

        extract($this->_map);

        if (!is_null($http_response_code)) {
            http_response_code($http_response_code); 
        }

        if (!is_null($this->_require)) {
            require_once($this->_require);
        }

        require($this->_name);

    }

    public function json($json) {
        header('Content-Type: application/json');
        echo $json;
    }

    public static function init($name, $require = null) {

        return new Template($name, $require);

    }

}

?>
