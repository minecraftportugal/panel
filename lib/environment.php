<?


class Environment {

    public static function getRequestMethod() {
        return $_SERVER['REQUEST_METHOD'];
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


}


?>
