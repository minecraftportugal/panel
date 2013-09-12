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

    $connice = $this->_classes['connection'];
    $conn = $connice::get($options['source']);
    if (!$conn) {
      return false;
    }

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

    $conn = static::source($source);
    switch ($method) {
      case 'first':
        $result = $conn->first($query, $conditions, $options);
        break;

      case 'all':
        $result = $conn->all($query, $conditions, $options);
        break;

      case 'query':
        $result = $conn->query($query, $conditions, $options);
        break;
    }

    return $result;
  }
}