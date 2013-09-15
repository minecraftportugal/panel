<?

require_once('config.php');
require_once('lib.php');

function users_skin() {
  global $cfg_web_root;

  validateSession();

  $seconds_to_cache = 60*60*24*7;//duration of the cache sent to the browser

  if (!isset($_GET['id']) || ($id = intval($_GET['id'])) <= 0)
  {
    http_response_code(404);
    return;
  }  

  $p = getUserById($id);
  if (!$p)
  {
    http_response_code(404);
    return;
  }

  $cs = curl_init("http://s3.amazonaws.com/MinecraftSkins/".$p['playername'].".png");

  // from 3d.php
  //cache
  //$seconds_to_cache = 60*60*24*7;//see at the begining of the file
  if($seconds_to_cache > 0) {
    $ts = gmdate("D, d M Y H:i:s", time() + $seconds_to_cache) . ' GMT';
    header('Expires: ' . $ts);
    header('Pragma: cache');
    header('Cache-Control: max-age=' . $seconds_to_cache);
  }

  header('Content-type: image/png');
  curl_exec($cs);

  curl_close($cs);
}

?>
