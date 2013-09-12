<?php

define('MINECRAFTIA_PATH', __DIR__);
define('MINECRAFTIA_NICE_PATH', MINECRAFTIA_PATH . '/lib');


require MINECRAFTIA_NICE_PATH . '/db/CONNice.php';
require MINECRAFTIA_NICE_PATH . '/db/DBNice.php';

use minecraftia\db\CONNice;

CONNice::add('default', [
  'prefix' => 'mysql',
  'host' => 'localhost',
  'port' => 3306,
  'database' => 'minecraft_auth',
  'user' => 'minecraft',
  'password' => 'minecr4ft'
]);

?>