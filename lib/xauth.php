<?php

require("config.php");

/*
 * refreshxAuthSession: refreshes the user's minecraft session
 */
function refreshxAuthSession($accountid) {

  $ip = $_SERVER['REMOTE_ADDR'];

  // Insert into sessions table
  $q = "
  INSERT INTO sessions(accountid, ipaddress, logintime) VALUES($accountid, '$ip', sysdate())
  ON DUPLICATE KEY UPDATE ipaddress = '$ip', logintime = sysdate()";
  list($result, $con) = q($q);

  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  mysql_close($con);

  $q = "
  UPDATE accounts
  SET lastlogindate = sysdate(), lastloginip = '$ip'
  WHERE id = $accountid";
  list($result, $con) = q($q);

  $result = mysql_query($q);
  if (!$result) {
    die('Invalid query: ' . mysql_error());
  }
  mysql_close($con);

}

/*
 * terminatexAuthSession: terminates the user's minecraft session
 */
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

/*
 * encryptPassword: encripts a password the same way xauth does it
 */ 
function encryptPassword($password) {
  $salt = substr(hash('whirlpool', uniqid(rand(), true)), 0, 12);
  $hash = hash('whirlpool', $salt . $password);
  $saltPos = (strlen($password) >= strlen($hash) ? strlen($hash) : strlen($password));
  return substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
}

/*
 * checkPassword: checks a password the same way xauth does it
 */
function checkPassword($checkPass, $realPass) {
  $saltPos = (strlen($checkPass) >= strlen($realPass) ? strlen($realPass) : strlen($checkPass));
  $salt = substr($realPass, $saltPos, 12);
  $hash = hash('whirlpool', $salt . $checkPass);
  return $realPass == substr($hash, 0, $saltPos) . $salt . substr($hash, $saltPos);
}

?>