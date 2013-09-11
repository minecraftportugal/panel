<?
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

function getPathInfo() {
  if (strpos($_SERVER['REQUEST_URI'], $_SERVER['SCRIPT_NAME']) === 0) {
      $script_name = $_SERVER['SCRIPT_NAME']; //Without URL rewrite
  } else {
      $script_name = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])); //With URL rewrite
  }

  $path_info = substr_replace($_SERVER['REQUEST_URI'], '', 0, strlen($script_name));
  if (strpos($path_info, '?') !== false) {
      $path_info = substr_replace($path_info, '', strpos($path_info, '?')); //query string is not removed automatically
  }
  $script_name = rtrim($script_name, '/');
  $path_info   = '/' . ltrim($path_info, '/');

  return $path_info;
}

?>
