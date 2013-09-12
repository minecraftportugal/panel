<?

require('config.php');
require('lib/xauth.php');

/*
 * validateLogin: validates user logins
 */
function validateLogin($username, $password) {
  global $cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass, $cfg_mysql_db;
  $con = mysql_connect($cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass) or die(mysql_error());

  $val = NULL;
  $username = s($username);
  $password = s($password);
  
  $q = "SELECT id, playername, password, admin FROM accounts WHERE playername = '$username' AND active=1;";
  list($result, $con) = q($q);

  $n = mysql_num_rows($result);
  if ($n == 1) {
    $row = mysql_fetch_array($result);
    $id = $row['id'];
    $realpass = $row['password'];
    $admin = $row['admin'];
    $playername = $row['playername'];
    if (checkPassword($password, $realpass)) {
      $val = "OK";
      initSession($id, $playername, $admin);
    }
  }

  if (!$con) {
    mysql_close($con);
  }

  return $val;
}

/*
 * initSession: initializes a users' session
 */
function initSession($id, $username, $admin) {
  $_SESSION['id'] = $id;
  $_SESSION['username'] = $username;
  $_SESSION['admin'] = $admin;
  $_SESSION['xsrf_token'] = substr(md5(rand()), 0, 32);
  refreshxAuthSession($id);
}

/*
 * isLoggedIn: returns wether a user is logged in or not, optionally as an admin
 */
function isLoggedIn($admin = false) {
  $val = false;

  if (!$admin) {
    if (isset($_SESSION['username'])) {
      $val = true;
    }
  } else {
    if (isset($_SESSION['username']) && isset($_SESSION['admin']) && $_SESSION['admin'] == 1) {
      $val = true;
    }
  }
  return $val;
}

/*
 * validateSession: validates a users' session, optionally as an admin. redirects to login if invalid
 */
function validateSession($admin = false) {
    if (!isLoggedIn($admin)) {
      header('Location: /login');
      exit();
    }
}

/*
 * validateXSRFToken: validates a user's XSRF token
 */
function validateXSRFToken($token) {
  return getXSRFToken() == $token;
}

/*
 * getXSRFToken: wraps the sessions' XRSF token
 */
function getXSRFToken() {
  return isset($_SESSION['xsrf_token']) ? $_SESSION['xsrf_token'] : NULL;
}

?>