<?php

namespace minecraftia\db;

use PDO;
use PDOException;

class DBNice {

  public $connection = null;

  private $_config = [];

  private $_connected = false;

  private $_result = null;

  public function __construct(array $config = []) {
    $defaults = [
      'prefix' => 'mysql',
      'host' => 'localhost',
      'port' => 3306,
      'dbname' => 'minecraft_auth',
      'user' => 'minecraft',
      'password' => 'minecr4ft',
      'dsn' => null,
      'persistent' => true,
      'options' => []
    ];
    $config += $defaults;
    $this->_config = $config + $defaults;

    $dsn = "mysql:host=%s;port=%s;dbname=%s";
    $this->_config['dsn'] = sprintf(
      $dsn,
      $this->_config['host'],
      $this->_config['port'],
      $this->_config['dbname']
    );

    $this->_config['options'] = [
      PDO::ATTR_PERSISTENT => $this->_config['persistent'],
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];

    try {
      $this->connection = new PDO(
        $this->_config['dsn'],
        $this->_config['user'],
        $this->_config['password'],
        $this->_config['options']
      );
    } catch (PDOException $e) {
      die('Error ' . $e->getMessage());
    }

    $this->_connected = true;
  }

  public function close() {
    unset($this->connection);
    $this->connection = null;
    return $this->_conected = false;
  }


  public function isConnected() {
    return $this->_connected;
  }


  public function query($sql, $conditions = array(), array $options = array()) {
    if (!$this->isConnected()) {
      return false;
    }

    try {
      $stmt = $this->connection->prepare($sql);
    } catch (PDOException $e) {
      die('Invalid SQL statement.');
    }

    if (!empty($conditions)) {
      $this->_buildStatement($stmt, $conditions);
    }

    try {
      $this->_result = $stmt->execute();
    } catch (PDOException $e) {
      die('Error executing query ' . $sql);
    }

    /**
     * needs to build the results now
     *
     * var_dump($stmt->fetchAll(PDO::FETCH_ASSOC)); die;
     */
  }


  protected function _buildStatement(&$stmt, array $conditions = array()) {
    foreach ($conditions as $key => $value) {
      switch ($value) {
        case is_bool($value):
          $pdoconst = PDO::PARAM_BOOL;
          break;
        case is_numeric($value):
          $pdoconst = PDO::PARAM_INT;
          break;
        case is_null($value):
          $pdoconst = PDO::PARAM_NULL;
          break;
        default:
          $pdoconst = PDO::PARAM_STR;
          break;
      }

      if (is_numeric($key)) {
        $x = $key + 1;
      } else {
        $x = ':' . $key;
      }

      $stmt->bindValue($x, $value, $pdoconst);
    }
  }


  protected function getResults() {}
}

?>