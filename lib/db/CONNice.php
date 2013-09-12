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

    return isset(static::$_instances[$name]) ? static::$_instances[$name]->close() : false;
  }


  /**
   * Querying methods
   * This stuff should be in another layer or even using the returning instances but what the heck..
   *
   * public static function find($sql, array $params, array $options = []) {}
   * public static function query($sql, array $params, array $options = []) {}
  */

  public static function __callStatic($method, $params) {
    $defaults = [
      'source' => 'default'
    ];
    $methods = ['first', 'all', 'query'];

    if (!(count($params) >= 1 && count($params) <= 3)) {
      /**
       * should throw exception
       */
      return false;
    }

    $query = $params[0];
    $conditions = isset($params[1]) ? $params[1] : [];
    $options = isset($params[2]) ? $params[2] + $defaults : $defaults;
    $source = $options['source'];

    if (!in_array($method, $methods)) {
      return false;
    }

    if (!isset(static::$_configs[$source])) {
      return false;
    }

    $conn = static::get($source);

    switch ($method) {
      case 'first':
        $result = $conn->fetch($query, $conditions, $options);
        $result = is_array($result) && count($result) === 1 ? reset($result) : false;
        break;

      case 'all':
        $result = $conn->fetch($query, $conditions, $options);
        $result = is_array($result) && !empty($result) ? $result : false;
        break;

      case 'query':
        $result = $conn->query($query, $conditions, $options);
        break;
    }

    $conn->close();

    return $result;
  }
}