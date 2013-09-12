<?php

/*
 * Utils Pattern is the Best Pattern ^_^ ololo
 */

/*
 * s: sanitize a database input
 */
function s($string) {
  global $cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass, $cfg_mysql_db;
  $con = mysql_connect($cfg_mysql_addr, $cfg_mysql_user, $cfg_mysql_pass) or die(mysql_error());

  return mysql_real_escape_string($string, $con);
}

/*
 * q: perform a database query
 */
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

?>