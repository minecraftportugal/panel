<?

namespace models\session;

require_once("config.php");

use minecraftia\db\Bitch;

class SessionModel {

    private static $args = [
      $page => 1,
      $per_page => 20,
      $playername => null,
      $ipaddress => null,
      $session_date_begin => null,
      $session_date_end => null,
      $session_valid => 0,
      $session_invalid => 0,
      $online => 0,
      $websession => 0
    ];

    public function __construct() {

    }

    public static function count($args = []) {
      $args = array_merge(SessionModel::$args, $args);

      $q = "SELECT count(1) AS total
      FROM accounts a INNER JOIN sessions s on a.id = s.accountid LEFT JOIN (
        SELECT 1 as online, name FROM inquisitor.players
        WHERE online = 1
      ) online_players ON (online_players.name = a.playername)
      WHERE playername = ifnull(:playername, playername)
      AND (ipaddress = ifnull(:ipaddress, ipaddress))
      AND ((:session_date_begin IS NULL) OR (:session_date_begin <= date(logintime)))
      AND ((:session_date_end IS NULL) OR (:session_date_end >= date(logintime)))
      AND ((:session_valid = 0) OR ((:session_valid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW())))
      AND ((:session_invalid = 0) OR ((:session_invalid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) <=  NOW())))
      AND ((:online = 0) OR (:online = 1 AND online = 1))
      AND ((:websession = 0) OR (:websession = 1 AND websession = 1))
      ORDER BY id DESC;";
      
      return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = [], $order = "id ASC") {
        $args = array_merge(SessionModel::$args, $args);

        $q = "SELECT * FROM (
          SELECT id, playername, lastloginip, lastlogindate, logintime, websession,
            DATE_FORMAT(logintime, '%b %d %H:%i:%s %Y') AS logintimef,
            DATE_FORMAT(lastlogindate, '%b %d %H:%i:%s %Y') AS lastlogindatef,
            IF(DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW(), 1, 0) as valid
          FROM accounts a INNER JOIN sessions s on a.id = s.accountid LEFT JOIN (
          SELECT 1 as online, name FROM inquisitor.players
          WHERE online = 1
        ) o ON (o.name = a.playername)
          WHERE playername = ifnull(:playername, playername)
          AND (ipaddress = ifnull(:ipaddress, ipaddress))
          AND ((:session_date_begin IS NULL) OR (:session_date_begin <= date(logintime)))
          AND ((:session_date_end IS NULL) OR (:session_date_end >= date(logintime)))
          AND ((:session_valid = 0) OR ((:session_valid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) > NOW())))
          AND ((:session_invalid = 0) OR ((:session_invalid = 1) AND (DATE_ADD(logintime, INTERVAL :session_length SECOND) <= NOW())))
          AND ((:online = 0) OR (:online = 1 AND online = 1))
          AND ((:websession = 0) OR (:websession = 1 AND websession = 1))
          ORDER BY logintime DESC
        ) pages LIMIT :index, :per_page";

        $args["index"] = ($args["page"] - 1) * $args["per_page"];

        $result = Bitch::source('default')->all($q, $args);

        if (!is_array($result)) {
            return [];
        } else {
            return $result;
        }
    }

}

?>
