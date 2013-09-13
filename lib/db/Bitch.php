<?php

namespace minecraftia\db;

class Bitch {
  protected $_meta = [
    'source' => 'default'
  ];

  protected $_classes = [
    'connection' => '\minecraftia\db\CONNice'
  ];

  public function __construct($config = []) {
    $defaults = $this->_meta;
    $config += $defaults;
    $this->_meta = $config;
  }

  public static function source($source = null) {
    return new self(compact('source'));
  }

  /**
   * Querying methods
   * This stuff should be in another layer or even using the returning instances but what the heck..
   *
   * public static function find($sql, array $params, array $options = []) {}
   * public static function query($sql, array $params, array $options = []) {}
  */

  public function __call($method, $params) {
    $defaults = $this->_meta;
    $methods = ['first', 'all', 'query'];

    if (!in_array($method, $methods)) {
      return false;
    }

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

    $connice = $this->_classes['connection'];
    $conn = $connice::get($options['source']);

    if (!$conn->isConnected()) {
      return false;
    }

    switch ($method) {
      case 'first':
        $result = $conn->fetch($query, $conditions, $options);
        $result = is_array($result) && count($result) === 1 ? reset($result) : null;
        break;

      case 'all':
        $result = $conn->fetch($query, $conditions, $options);
        $result = is_array($result) && !empty($result) ? $result : null;
        break;

      case 'query':
        $result = $conn->query($query, $conditions, $options);
        break;
    }

    if (!$conn->isPersistent()) {
      $conn->close();
    }

    return $result;
  }

  public static function __callStatic($method, $params) {
    $defaults = [
      'source' => 'default'
    ];
    $methods = ['first', 'all', 'query'];

    if (!in_array($method, $methods)) {
      return false;
    }

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

    $conn = static::source($source);
    return $con->{$method}($query, $conditions, $options);
  }
}