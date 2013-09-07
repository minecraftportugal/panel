<?php

namespace minecraftia\test;

require 'DBNice.php';

use minecraftia\db\DBNice;

$test = new DBNice();

var_dump('is connected?', $test->isConnected());

// var_dump($test->query('SELECT * FROM accounts'));

var_dump($test->query('SELECT * FROM accounts WHERE name = ?', array('wikipeixoto')));

$test->close();

var_dump('is open?', !$test->isConnected());

?>