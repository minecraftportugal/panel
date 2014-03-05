<?

namespace models\account;

require_once("config.php");

use minecraftia\db\Bitch;

class AccountModel {

  private static $args = [
               "id"  => null,
           "page"  => 1,
         "per_page" => 20,
         "playername" => null,
        "ipaddress" => null,
         "emailaddress" => null,
       "login_date_begin" => null,
         "login_date_end" => null,
    "register_date_begin" => null,
      "register_date_end" => null,
            "nologin" => 0,
           "yeslogin" => 0,
             "nogame" => 0,
            "yesgame" => 0,
           "inactive" => 0,
            "admin" => 0,
           "operator" => 0,
          "contributor" => 0,
          "donor" => 0,
            "premium" => 0,
             "online" => 0,
            "staff" => 0
  ];

  public function __construct() {

  }

  public static function count($args = []) {
    $args = array_merge(AccountModel::$args, $args);

    $q = "SELECT count(1) AS total
      FROM accounts a LEFT JOIN (
      SELECT online, totalTime, name FROM inquisitor.players
    ) o ON (o.name = a.playername)
    WHERE playername = ifnull(:playername, playername)
    AND (id = ifnull(:id, id))
    AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
    AND email = ifnull(:emailaddress, email)
    AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate IS NULL))
    AND ((:yeslogin = 0) OR (:yeslogin = 1 AND lastlogindate IS NOT null))
    AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
    AND ((:admin = 0) OR (:admin = 1 AND admin = 1))
    AND ((:operator = 0) OR (:operator = 1 AND operator = 1))
    AND ((:staff = 0) OR (:staff = 1 AND (admin = 1 OR operator = 1)))
    AND ((:contributor = 0) OR (:contributor = 1 AND contributor = 1))
    AND ((:donor = 0) OR (:donor = 1 AND donor = 1))
    AND ((:premium = 0) OR (:premium = 1 AND premium = 1))
    AND ((:online = 0) OR (:online = 1 AND online = 1))
    AND ((:nogame = 0) OR (:nogame = 1 AND playername NOT IN (SELECT name FROM inquisitor.players)))
    AND ((:yesgame = 0) OR (:yesgame = 1 AND playername IN (SELECT name FROM inquisitor.players)))
    AND ((:login_date_begin IS NULL) OR (:login_date_begin <= date(lastlogindate)))
    AND ((:login_date_end IS NULL) OR (:login_date_end >= date(lastlogindate)))
    AND ((:register_date_begin IS NULL) OR (:register_date_begin <= date(registerdate)))
    AND ((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)));";
    
    return Bitch::source('default')->first($q, $args)["total"];
  }

  public static function get($args = [], $order = "id ASC") {
    $args = array_merge(AccountModel::$args, $args);

    $q = "SELECT * FROM (
      SELECT id, playername, email, admin, operator, active,
        DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip,
        DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip,
        IFNULL(online, 0) AS online
      FROM accounts a LEFT JOIN (
        SELECT online, totalTime, name
        FROM inquisitor.players
      ) o ON (o.name = a.playername)
      WHERE playername = ifnull(:playername, playername)
      AND (id = ifnull(:id, id))
      AND (lastloginip = ifnull(:ipaddress, lastloginip) OR registerip = ifnull(:ipaddress, registerip))
      AND email = ifnull(:emailaddress, email)
      AND ((:nologin = 0) OR (:nologin = 1 AND lastlogindate IS NULL))
      AND ((:yeslogin = 0) OR (:yeslogin = 1 AND lastlogindate IS NOT null))
      AND ((:inactive = 0) OR (:inactive = 1 AND active = 0))
      AND ((:admin = 0) OR (:admin = 1 AND admin = 1))
      AND ((:operator = 0) OR (:operator = 1 AND operator = 1))
      AND ((:staff = 0) OR (:staff = 1 AND (admin = 1 OR operator = 1)))
      AND ((:contributor = 0) OR (:contributor = 1 AND contributor = 1))
      AND ((:donor = 0) OR (:donor = 1 AND donor = 1))
      AND ((:premium = 0) OR (:premium = 1 AND premium = 1))
      AND ((:online = 0) OR (:online = 1 AND online = 1))
      AND ((:nogame = 0) OR (:nogame = 1 AND playername NOT IN (SELECT name FROM inquisitor.players)))
      AND ((:yesgame = 0) OR (:yesgame = 1 AND playername IN (SELECT name FROM inquisitor.players)))
      AND ((:login_date_begin IS NULL) OR (:login_date_begin <= date(lastlogindate)))
      AND ((:login_date_end IS NULL) OR (:login_date_end >= date(lastlogindate)))
      AND ((:register_date_begin IS NULL) OR (:register_date_begin <= date(registerdate)))
      AND ((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)))
      ORDER BY $order
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

/*



  var $_conditions = [
    "id" => "(a.id = :id)",
    "playername" => "(a.playername LIKE :playername)",
    "emailaddress" => "(a.email LIKE :emailaddress)",
    "ipaddress" => "(a.lastloginip = :ipaddress) OR a.registerip = :ipaddress)",
    "nologin"  => "((:nologin = 0) OR (:nologin = 1 AND lastlogindate IS NULL))",
    "yeslogin"  => "((:yeslogin = 0) OR (:yeslogin = 1 AND lastlogindate IS NOT null))",
    "inactive" => "((:inactive = 0) OR (:inactive = 1 AND active = 0))"
    "admin" => "((:admin = 0) OR (:admin = 1 AND admin = 1))",
    "operator" => "((:operator = 0) OR (:operator = 1 AND operator = 1))",
    "staff" => "((:staff = 0) OR (:staff = 1 AND (admin = 1 OR operator = 1)))",
    "contributor" => "((:contributor = 0) OR (:contributor = 1 AND contributor = 1))",
    "donor" => "((:donor = 0) OR (:donor = 1 AND donor = 1))",
    "premium" => "((:premium = 0) OR (:premium = 1 AND premium = 1))",
    "online" => "((:online = 0) OR (:online = 1 AND online = 1))",
    "nogame" => "((:nogame = 0) OR (:nogame = 1 AND i.playername IS NULL))",
    "yesgame" => "((:yesgame = 0) OR (:yesgame = 1 AND i.playername IS NOT NULL))",
    "login_date_begin" => "((:login_date_begin IS NULL) OR (:login_date_begin <= date(lastlogindate)))",
    "login_date_end" => "((:login_date_end IS NULL) OR (:login_date_end >= date(lastlogindate)))"
    "register_date_begin" => "((:register_date_begin IS NULL) OR (:register_date_begin <= date(registerdate)))"
    "register_date_end" => "((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)))"
  ]

  var $_fields = [
    "id",
    "playername",
    "email",
    "admin",
    "operator",
    "active",
    "registerdate" => "DATE_FORMAT(registerdate, '%b %d %H:%i %Y')",
    "registerip",
    "lastlogindate" => "DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y')",
    "lastloginip"
  ];

*/
?>
