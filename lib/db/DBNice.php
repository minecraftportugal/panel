<?php

namespace minecraftia\db;

use PDO;
use PDOStatment;
use PDOException;

class DBNice {

  public $connection = null;

  private $_config = [];

  private $_connected = false;

  private $_statement = null;

  private $_result = null;


  /**
   * Did anyone called for a constructor?
   * @param array $config configs to override the defaults
   */
  public function __construct(array $config = []) {
    $defaults = [
      'prefix' => 'mysql',
      'host' => 'localhost',
      'port' => 3306,
      'database' => 'minecraft_auth',
      'user' => 'minecraft',
      'password' => 'minecr4ft',
      'encoding' => 'utf8',
      'dsn' => null,
      'persistent' => true,
      'options' => []
    ];
    $config += $defaults;
    $this->_config = $config + $defaults;

    $this->connect();
  }

  public function __destruct() {
    $this->close();
  }

  public function connect(array $options = []) {
    if ($this->_connected) {
      return true;
    }

    $this->_config += $options;

    $dsn = "mysql:host=%s;port=%s;dbname=%s";
    $this->_config['dsn'] = sprintf(
      $dsn,
      $this->_config['host'],
      $this->_config['port'],
      $this->_config['database']
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

    if ($this->_config['encoding']) {
      $this->encoding($this->_config['encoding']);
    }

    $this->_connected = true;
  }

  /**
   * Clear objects to ensure memory gets wiped off and the connection is closed
   * @return void
   */
  public function close() {
    unset($this->_result);
    $this->_result = null;
    unset($this->_statement);
    $this->_statement = null;
    unset($this->connection);
    $this->connection = null;
    return $this->_conected = false;
  }

  public function encoding($encoding = null) {
    $default = 'utf8';

    if (!$encoding) {
      return $this->_config['encoding'];
    }

    try {
      $encoding = $this->_config['encoding'] ? $this->_config['encoding'] : $default;
      $this->connection->exec("SET NAMES '{$encoding}'");
      return true;
    } catch (PDOException $e) {
      die("Error trying to set the encoding to `{$encoding}`: " . $e->getMessage());
      /**
       * When die statements will be removed once the error handler is finished
       * because of it, the next statement doesn't happen, never.
       */
      return false;
    }
  }


  /**
   * Helper to check how the connection is doing.
   * @return boolean haz connection?
   */
  public function isConnected() {
    return $this->_connected;
  }


  private function _execute($sql, $conditions = [], array $options = []) {
    if (!$this->isConnected()) {
      return false;
    }

    try {
      $this->_statement = $this->connection->prepare($sql);
    } catch (PDOException $e) {
      die('Invalid SQL statement: ' . $e->getMessage());
    }

    if (!empty($conditions)) {
      $this->_buildStatement($conditions);
    }

    try {
      $result = $this->_statement->execute();
    } catch (PDOException $e) {
      die('Error executing: ' . $e->getMessage());
    }

    return $result;
  }

  /**
   * Helper for the DBNice::query to clean up the code.
   * @param  array  $conditions Array of conditions to connect to the query.
   * @return void
   */
  protected function _buildStatement(array $conditions = []) {
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
        $x = ":{$key}";
      }

      $this->_statement->bindValue($x, $value, $pdoconst);
    }
  }

  /**
   * Queries the db for inserts, updates and shit like that.
   * @param  string $sql        A query
   * @param  array  $conditions The query conditions
   * @param  array  $options    Misc options (important for fetching stuff)
   * @return mixed
   */
  public function query($sql, $conditions = [], array $options = []) {
    return $this->_execute($sql, $conditions, $options);
  }

  /**
   * Fetches shit, a select query i'd say.
   * @param  string $sql        The query
   * @param  array $conditions  The conditions to the query
   * @param  array $options     Misc options
   * @return mixed              Array with the expected results or boolean
   */
  public function fetch($sql, $conditions = [], array $options = []) {
    if (!$this->_execute($sql, $conditions, $options)) {
      return false;
    }
    return $this->_getResults($options);
  }


  protected function _getResults(array $options = []) {
    $defaults = [
      'type' => PDO::FETCH_ASSOC,
      'clear' => true
    ];
    $options += $defaults;

    $this->_result = $this->_statement->fetchAll($options['type']);

    if (!is_array($this->_result)) {
      return false;
    }

    return empty($this->_result) ? null : $this->_result;
  }
}

?>