<?php

error_reporting (E_ALL);

require("vendors/PHPMailer/class.phpmailer.php");
require("config.php");

function s($string) {
  return mysql_real_escape_string($string);
}

function q($sql, $db = null) {
  global $cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass, $cfg_mysql_db;

  if ($db == null) {
    $db = $cfg_mysql_db;
  }

  $con = mysql_connect($cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass) or die(mysql_error());
  mysql_select_db($db) or die(mysql_error());
  mysql_query("SET NAMES 'utf8'");


  $result = mysql_query($sql);
  return array($result, $con);
}

function getInquisitor($playername) {
  $q = "SELECT * FROM players WHERE name = '$playername';";
  list($result, $con) = q($q, "inquisitor");
  $data = mysql_fetch_array($result);
  mysql_close($con);
  return $data;
}

/* /!\ */
function updateConfigFiles() {
  $b = system("/home/minecraft/minecraft/update-white-list.sh");
  $a = system("/home/minecraft/minecraft/update-ops-list.sh");
  var_dump($a);
  var_dump($b);
}

function validateSession($admin = false) {
    if (!isLoggedIn($admin)) {
      header('Location: /login');
      exit();
    }
}

function encryptPassword($password) {
  $salt = substr(hash('whirlpool', uniqid(rand(), true)), 0, 12);
  $hash = hash('whirlpool', $salt . $password);
  $saltPos = (strlen($password) >= strlen($hash) ? strlen($hash) : strlen($password));
  return substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
}

function checkPassword($checkPass, $realPass) {
  $saltPos = (strlen($checkPass) >= strlen($realPass) ? strlen($realPass) : strlen($checkPass));
  $salt = substr($realPass, $saltPos, 12);
  $hash = hash('whirlpool', $salt . $checkPass);
  return $realPass == substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
}

function getRecent($exclude) {

  $q = "
  SELECT id, playername, DATE_FORMAT(logintime, '%b %d %H:%i %Y') sessiondate
  FROM accounts INNER JOIN sessions ON accounts.id = sessions.accountid
  WHERE accounts.id != $exclude
  ORDER BY logintime desc LIMIT 10;";
  list($result, $con) = q($q);
  
  $a = array();
  while($row = mysql_fetch_array($result))
  {
    array_push($a, $row);
  }
  mysql_close($con);

  return $a;
}

function getNewest() {

  $q = "
  SELECT id, playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') registerdate
  FROM accounts INNER JOIN sessions ON accounts.id = sessions.accountid
  ORDER BY accounts.registerdate desc LIMIT 10;";
  list($result, $con) = q($q);
  
  $a = array();
  while($row = mysql_fetch_array($result))
  {
    array_push($a, $row);
  }
  mysql_close($con);

  return $a;
}
function validateLogin($username, $password) {

  $val = NULL;
  $username = mysql_real_escape_string($username);
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

function getXSRFToken() {
  return isset($_SESSION['xsrf_token']) ? $_SESSION['xsrf_token'] : NULL;
}

function validateXSRFToken($token) {
  return getXSRFToken() == $token;
}

function initSession($id, $username, $admin) {
  $_SESSION['id'] = $id;
  $_SESSION['username'] = $username;
  $_SESSION['admin'] = $admin;
  $_SESSION['xsrf_token'] = substr(md5(rand()), 0, 32);
  newxAuthSession($id);
}

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


/* register
   0: OK
   1: Duped Email
   2: Duped Username
   3: Invalid Email
   4: Invlaid Username
 */
function register($username, $email, $email_ip = false) {

  // check for dupe email
  $q = "SELECT count(*) FROM accounts WHERE email = '$email';";
  list($result, $con) = q($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $result = mysql_result($result, 0);
  if ($result != "0") {
    return 1;
  }

  // check for dupe username
  $q = "SELECT count(*) FROM accounts WHERE playername = '$username';";
  list($result, $con) = q($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $result = mysql_result($result, 0);
  if ($result != "0") {
    return 2;
  }

  // check for valid email
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    return 3;
  }

  // check for valid username
  if (!eregi("^([a-zA-Z0-9_]){4,26}$", $username)) {
   return 4;
  }

  // create new account
  $password = substr(md5(rand()), 0, 7);
  $ip = $_SERVER['REMOTE_ADDR'];
  $q = "INSERT INTO accounts(playername, password, pwtype, email, registerdate, registerip, active) ";
  $q .= "VALUES('$username', '".encryptPassword($password)."', '0', '$email', sysdate(), '$ip', '1')";

  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  emailConfirmation($username, $password, $email, $email_ip);

  return 0;
}


//
// Refreshes xAuth session if the established session doesn't exist
// or is old.
//
function refreshxAuthSession($id) {
  newxAuthSession($id);
}

function getUserList() {

  $q = "
  SELECT playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip, email, admin, active, id, DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip
  FROM accounts 
  ORDER BY id desc;";
  list($result, $con) = q($q);

  $a = array();
  while($row = mysql_fetch_array($result))
  {
    array_push($a, $row);
  }
  mysql_close($con);

  return $a;
}

function getNews() {

  $q = "
  SELECT title, body, date_format(date_created, '%W, %d %b %Y') date_created
  FROM news
  ORDER BY id desc;";
  list($result, $con) = q($q);

  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $a = array();
  while($row = mysql_fetch_array($result))
  {
    array_push($a, $row);
  }
  mysql_close($con);

  return $a;
}


function getUser($username) {

  $q = "
  SELECT playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, email, admin, active, id
  FROM accounts
  WHERE playername = '$username'";
  list($result, $con) = q($q);

  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  $row = mysql_fetch_array($result);

  mysql_close($con);

  return $row;
}

function getUserById($id) {

  $q = "
  SELECT playername, DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate,
         email, admin, active, id, ircnickname, ircpassword, ircauto,
         DATE_FORMAT(sessions.logintime, '%b %d %H:%i %Y') as logintime
  FROM accounts LEFT JOIN sessions ON accounts.id = sessions.accountid
  WHERE id = '$id'";

  list($result, $con) = q($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  $row = mysql_fetch_array($result);

  mysql_close($con);

  return $row;
}

function getLastSession($id) {

  $q = "
  SELECT accountid, ipaddress, logintime as logintime
  FROM sessions
  WHERE accountid = $id 
  ORDER BY logintime DESC LIMIT 1";
  list($result, $con) = q($q);

  $row = mysql_fetch_array($result);
  mysql_close($con);
  return $row;
}

function newxAuthSession($accountid) {

  $ip = $_SERVER['REMOTE_ADDR'];
  $q = "
  INSERT INTO sessions(accountid, ipaddress, logintime) VALUES($accountid, '$ip', sysdate())
  ON DUPLICATE KEY UPDATE ipaddress = '$ip', logintime = sysdate()";
  list($result, $con) = q($q);

  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  mysql_close($con);

}

function terminatexAuthSession($accountid) {

  //database connection

  $ip = $_SERVER['REMOTE_ADDR'];
  $q = "
  UPDATE sessions
  SET ipaddress = ''
  WHERE accountid = $accountid";
  list($result, $con) = q($q);

  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  mysql_close($con);

}

function usersConfigure($admin, $active, $delete, $playername, $email, &$message) {

  $message = NULL;

  //database connection
  $con = mysql_connect("localhost:3306","minecraft","minecr4ft") or die(mysql_error());
  mysql_select_db("minecraft_auth") or die(mysql_error());
  mysql_query("SET NAMES 'utf8'");

  //admin privileges
  $str = "-1";
  if (count($admin) > 0) {
    $str = implode(",", $admin);
  }

  $q = "UPDATE accounts SET admin = 0 WHERE id not in ($str) AND admin = 1";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $q = "UPDATE accounts SET admin = 1 WHERE id in ($str) AND admin = 0";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  //deactivate accounts
  $str = "-1";
  if (count($active) > 0) {
    $str = implode(",", $active);
  }

  $q = "UPDATE accounts SET active = 0 WHERE id not in ($str) AND active = 1";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  //remove sessions for deactivated accounts
  $q = "UPDATE sessions SET ipaddress = '' WHERE accountid not in ($str)";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $q = "UPDATE accounts SET active = 1 WHERE id in ($str) AND active = 0";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  //create new account
  if ($playername != "") {
    $result = register($playername, $email);
    if ($result == 1) {
      $message = "Email address already taken";
      return false;
    } else if ($result == 2) {
      $message = "Username already taken";
      return false;
    } else if ($result == 3) {
      $message = "Invalid email address";
      return false;
    } else if ($result == 4) {
      $message = "Invalid username";
      return false;
    } 
  }

  //delete users
  $str = "-1";
  if (count($delete) > 0) {
    $str = implode(",", $delete);
  }

  $q = "DELETE FROM accounts WHERE id IN ($str)";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  $q = "DELETE FROM sessions WHERE accountid IN ($str)";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }


  mysql_close($con);

  updateConfigFiles();

  $message = "Settings saved.";
  return true;
}

function changePassword($username, $password, $new_password, $confirm_password, $ircnickname, $ircpassword, $ircauto, &$message) {

  //validate login
  //if it doesn't, try to change nickserv data
  $session = validateLogin($username, $password);
  if ($session == NULL) {
    $message = NULL;
    $val = changeIRC($username, $ircnickname, $ircpassword, $ircauto, $message);
    return val;
  }

  if ($new_password == $confirm_password) {
    if (strlen($new_password) < 6) {
      $message = "Passwords must be at least 6 characters long!";
      return false;
    }

    //database connection
    $con = mysql_connect("localhost:3306","minecraft","minecr4ft") or die(mysql_error());
    mysql_select_db("minecraft_auth") or die(mysql_error());
    mysql_query("SET NAMES 'utf8'");

    $q = "UPDATE accounts SET password = '".encryptPassword($new_password)."' WHERE playername = '$username'";
    $result = mysql_query($q);
    if (!$result) {
      die('Invalid query: ' . mysql_error());
    }

    mysql_close($con);

    $message = "Password changed successfully!";
    return true;

  } else {

    $message = "Passwords do not match";
    return false;
  }

}

function changeIRC($username, $ircnickname, $ircpassword, $ircauto, &$message) {

  //database connection
  $con = mysql_connect("localhost:3306","minecraft","minecr4ft") or die(mysql_error());
  mysql_select_db("minecraft_auth") or die(mysql_error());
  mysql_query("SET NAMES 'utf8'");


  $q = "UPDATE accounts 
        SET ircnickname = '$ircnickname', ircpassword = '$ircpassword', ircauto = '$ircauto'
        WHERE playername = '$username'";
  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }

  mysql_close($con);

  $message = "IRC settings saved!";
  return true;

}

function resetPassword($id, &$message) {

  $u = getUserById($id);
  $v_username = $u['playername'];
  $v_email = $u['email'];
  $v_password = substr(md5(rand()), 0, 7);
  $q = "UPDATE accounts SET password = '".encryptPassword($v_password)."' WHERE id = $id";
  list($result, $con) = q($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  mysql_close($con);
  emailConfirmation($v_username, $v_password, $v_email);

  $message = "Password reset successful! Email sent.";
  return true;
}

function emailConfirmation($playername, $password, $email, $email_ip = false) {
  global $cfg_phpmailer_username, $cfg_phpmailer_password, $cfg_phpmailer_email, $cfg_web_root;

  $mail = new PHPMailer(); 

  $mail->IsSMTP(true); // send via SMTP

  $mail->SMTPAuth = true; // turn on SMTP authentication
  $mail->SMTPDebug = 0;  // debugging: 1 = errors and messages, 2 = messages only
  $mail->SMTPAuth = true;  // authentication enabled
  $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for GMail
  $mail->Host = 'smtp.gmail.com';
  $mail->Port = 465;
  $mail->Username = $cfg_phpmailer_username; // SMTP username
  $mail->Password = $cfg_phpmailer_password; // SMTP password
  $webmaster_email = $cfg_phpmailer_email; //Reply to this email ID
  
  $name = $playername; // Recipient's name
  $mail->From = $webmaster_email;
  $mail->FromName = "Minecraftia!";
  $mail->AddAddress($email,$name);
  $mail->WordWrap = 50; // set word wrap
  $mail->IsHTML(true); // send as HTML
  
  $mail->Subject = "Welcome to Minecraftia!";
  $body = file_get_contents("$cfg_web_root/templates/email.html");
  $body = str_replace('$playername', $playername, $body);
  $body = str_replace('$password', $password, $body);

  if ($email_ip) {
    $body = str_replace('$ip', $_SERVER['REMOTE_ADDR'], $body);
  } else {
    $body = str_replace('$ip', "Server Administrator", $body);
  }
  $mail->Body = $body;
  $mail->AltBody = strip_tags($body); //Text Body
  
  if(!$mail->Send())
  {
      die("Mailer Error: " . $mail->ErrorInfo);
  }
}

?>