<?

require('config.php');
require('lib/xauth.php');

use minecraftia\db\Bitch;

/*
 * validateLogin: validates user logins
 */
function validateLogin($username, $password) {
  $q = "SELECT id, playername, password, admin FROM accounts WHERE playername=:username AND active=1;";

  if ($result = Bitch::source('default')->first($q, compact('username'))) {
    if (checkPassword($password, $result['password'])) {
      initSession($result['id'], $result['playername'], $result['admin']);
      return true;
    }
  }

  return false;
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
 * getXSRFToken: wraps the sessions' XRSF token
 */
function getXSRFToken() {
  return isset($_SESSION['xsrf_token']) ? $_SESSION['xsrf_token'] : NULL;
}

/*
 * getSubmittedXSRFToken: wraps the POST requests' XRSF token
 */
function getSubmittedXSRFToken() {
  return isset($_POST['xsrf_token']) ? $_POST['xsrf_token'] : NULL;
}

/*
 * isValidXSRFToken: validates a user's XSRF token
 */
function isValidXSRFToken($token) {
  return getXSRFToken() == $token;
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
function validateXSRFToken() {
    $token = getSubmittedXSRFToken();

    if (!isValidXSRFToken($token)) {
      header('Location: /forbidden');
      exit();
    }
}

?>