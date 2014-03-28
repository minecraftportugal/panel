<?

namespace models\account;

require_once("config.php");

use minecraftia\db\Bitch;

class AccountModel {

  private static $args = [
    "id" => null,
    "page" => 1,
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
    "staff" => 0,
    "order_by" => "1",
    "asc_desc" => 'desc'
  ];

  public static function count($args = []) {
    $args = array_merge(AccountModel::$args, $args);

    $q = "SELECT count(1) AS total
      FROM accounts a LEFT JOIN (
      SELECT online, totalTime, name, world FROM inquisitor.players
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

  public static function get($args = []) {
    $args = array_merge(AccountModel::$args, $args);
    $order_by = $args["order_by"];
    $asc_desc = $args["asc_desc"];

    $q = "SELECT * FROM (
      SELECT id, playername, email, admin, operator, active,
        DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip,
        DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip,
        registerdate as registerdate_df, lastlogindate as lastlogindate_df,
        o.online, o.totalTime, o.world
      FROM accounts a LEFT JOIN (
        SELECT online, totalTime, name, world
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
      ORDER BY $order_by $asc_desc
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