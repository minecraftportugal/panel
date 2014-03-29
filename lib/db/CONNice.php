<?php

namespace minecraftia\db;

use minecraftia\db\DBNice;
use PDOException;


class CONNice {

  protected static $_instances = [];

  protected static $_configs = [];

  protected static $_status = [];

  public function __construct() {}
  public function __clone() {}

  public static function add($name, array $config = []) {
    $defaults = [
      'prefix' => 'mysql',
      'database' => null,
      'host' => null,
      'port' => null,
      'user' => null,
      'password' => null,
      'encoding' => 'utf8',
      'persistent' => null
    ];

    if (is_array($name)) {
      $name = 'default';
    }

    static::$_configs[$name] = $config + $defaults;
  }

  public static function get($name = null, array $options = []) {
    $defaults = [
      'config' => false
    ];
    $options += $defaults;

    if ($name === null) {
      return static::$_configs;
    }

    if (isset(static::$_configs[$name]) && $options['config']) {
      return static::$_configs[$name];
    }

    if (!isset(static::$_instances[$name])) {
      static::$_instances[$name] = new DBNice(static::$_configs[$name]);
    }

    if (!static::$_instances[$name]->isConnected()) {
      static::$_instances[$name]->connect();
    }

    return static::$_instances[$name];
  }

  public static function close($name = null) {
    if (!$name) {
      foreach (static::$_instances as $name => $conn) {
        try {
          $conn->close();
        } catch (PDOException $e) {
          die("Error closing connection `{$name}`: " . $e->getMessage());
        }
      }
      return true;
    }

    if (!isset(static::$_configs[$name])) {
      return false;
    }

    try {
      static::$_instances[$name]->close();
    } catch (PDOException $e) {
      die("Error closing connection `{$name}`: " . $e->getMessage());
    }

    return true;
  }
}