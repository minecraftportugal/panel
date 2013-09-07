<?php

namespace minecraftia\test;

require 'DBNice.php';

use minecraftia\db\DBNice;

$test = new DBNice();

var_dump('is connected?', $test->isConnected());

var_dump($test->fetch('SELECT * FROM accounts'));

var_dump($test->fetch('SELECT * FROM accounts WHERE playername = ?', ['wikipeixoto']));

var_dump($test->query(
  "UPDATE accounts SET active = 0 WHERE id = :id AND active = 1",
  ['id' => 351]
));

$test->close();

var_dump('is open?', !$test->isConnected());

?>