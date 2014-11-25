<?php

use minecraftia\db\Bitch;

/*
 * refreshxAuthSession: refreshes the user's minecraft session
 */
function refreshxAuthSession($accountid) {

  $ip = $_SERVER['REMOTE_ADDR'];

  // Insert into sessions table
  $q = "INSERT INTO sessions(accountid, ipaddress, logintime, websession) 
  VALUES($accountid, :ip, sysdate(), 1)
  ON DUPLICATE KEY UPDATE ipaddress = :ip, logintime = sysdate(), websession = 1";

  $result = Bitch::source('default')->query($q, compact('ip'));

  $q = "UPDATE accounts
  SET lastlogindate = sysdate(), lastloginip = :ip
  WHERE id = :accountid;";

  $result = Bitch::source('default')->query($q, compact('ip', 'accountid'));
}

/*
 * terminatexAuthSession: terminates the user's minecraft session
 */

function terminatexAuthSession($accountid) {
  //$q = "UPDATE sessions SET ipaddress='' WHERE accountid=:accountid";
  $q = "DELETE FROM sessions  WHERE accountid=:accountid";
  $result = Bitch::source('default')->query($q, compact('ip', 'accountid'));

  return $result;
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