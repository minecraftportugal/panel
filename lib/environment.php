<?

namespace lib\environment;

class Environment {

    public static function get($variable) {
        $variable = strtoupper($variable);

        return array_key_exists($variable, $_SERVER) ? $_SERVER[$variable] : null;
    }

    /*
    * @author      Josh Lockhart <info@slimframework.com>
    * @copyright   2011 Josh Lockhart
    * @link        http://www.slimframework.com
    * @license     http://www.slimframework.com/license
    * @version     2.3.0
    * @package     Slim
    *
    * MIT LICENSE
    */
    public static function getPathInfo() {

        if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) === 0) {

            //Without URL rewrite
            $script_name = $_SERVER['SCRIPT_NAME'];

        } else {

            //With URL rewrite
            $script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));

        }

        $path_info = substr_replace($_SERVER['REQUEST_URI'], '', 0, strlen($script_name));

        if (strpos($path_info, '?') !== false) {

            //query string is not removed automatically
            $path_info = substr_replace($path_info, '', strpos($path_info, '?'));

        }

        $script_name = rtrim($script_name, '/');

        $path_info   = '/' . ltrim($path_info, '/');

        return $path_info;
    }

    function getSelfURL() { 
        
        function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

        $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
        
        $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
        
        if (($_SERVER["SERVER_PORT"] == "80") || ($_SERVER["SERVER_PORT"] == "443")) {
        
            $port = "";
        
        } else {
        
            $port = ":" . $_SERVER["SERVER_PORT"];

        }
        
        return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
    }


}


?>
