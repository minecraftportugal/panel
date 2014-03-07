<?

namespace models\drop;

use minecraftia\db\Bitch;

class DropModel {

  private static $args = [
           "page" => 1,
       "per_page" => 20,
      "accountid" => null,
      "delivered" => 0,
    "undelivered" => 0
  ];

  public function __construct() {

  }

  public static function count($args = []) {
    $args = array_merge(DropModel::$args, $args);

    $q = "SELECT COUNT(1) AS total
    FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
    WHERE ((:accountid IS NULL) OR (accountid = :accountid))
    AND ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
    AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))";

    return Bitch::source('default')->first($q, $args)["total"];
  }

  public static function get($args = [], $order = "id DESC") {
    $args = array_merge(DropModel::$args, $args);

    $q = "SELECT * FROM (
      SELECT i.id, i.itemdrop, i.itemnumber, i.itemaux,
        DATE_FORMAT(i.dropdate, '%b %d %H:%i %Y') as dropdate,
        DATE_FORMAT(i.takendate, '%b %d %H:%i %Y') as takendate,
        IFNULL(timediff(takendate, dropdate), 'Não Entregue') AS idledroptime,
        a.playername, a.id as accountid
        FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
        WHERE ((:accountid IS NULL) OR (accountid = :accountid))
        AND ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
        AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))
      ORDER BY $order
    ) x LIMIT :index, :per_page;";

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
