<?

namespace models\session;

use minecraftia\db\Bitch;

class SessionModel {

    private static $args = [
        "page" => 1,
        "per_page" => 20,
        "length" => 3600,
        "playername" => null,
        "ipaddress" => null,
        "date_begin" => null,
        "date_end" => null,
        "valid" => 0,
        "invalid" => 0,
        "online" => 0,
        "websession" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public function __construct() {

    }

    public static function count($args = []) {
        $args = array_merge(SessionModel::$args, $args);

        $q = "SELECT count(1) AS total
        FROM accounts a
        LEFT JOIN sessions_history sh on a.id = sh.accountid
        LEFT JOIN (
            SELECT 1 as online, name
            FROM inquisitor.players
            WHERE online = 1
        ) o ON (o.name = a.playername)
        WHERE a.playername = IFNULL(:playername, playername)
        AND (sh.ipaddress = IFNULL(:ipaddress, sh.ipaddress))
        AND ((:date_begin IS NULL) OR (:date_begin <= date(sh.logintime)))
        AND ((:date_end IS NULL) OR (:date_end >= date(sh.logintime)))
        AND ((:valid = 0) OR ((:valid = 1) AND (DATE_ADD(sh.logintime, INTERVAL :length SECOND) > NOW())))
        AND ((:invalid = 0) OR ((:invalid = 1) AND (DATE_ADD(sh.logintime, INTERVAL :length SECOND) <= NOW())))
        AND ((:online = 0) OR (:online = 1 AND o.online = 1))
        AND ((:websession = 0) OR (:websession = 1 AND sh.websession = 1));";
        // ORDER BY id DESC;";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {
        $args = array_merge(SessionModel::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $q = "SELECT * FROM (
            SELECT a.id, a.playername,
                sh.ipaddress AS ipaddress,
                a.lastlogindate AS lastlogindate_df,
                sh.logintime AS logintime_df,
                sh.websession AS websession,
                DATE_FORMAT(sh.logintime, '%b %d %H:%i:%s %Y') AS logintime,
                DATE_FORMAT(a.lastlogindate, '%b %d %H:%i:%s %Y') AS lastlogindate,
                IF(DATE_ADD(sh.logintime, INTERVAL :length SECOND) > NOW(), 1, 0) as valid
            FROM accounts a
            LEFT JOIN sessions_history sh on a.id = sh.accountid
                LEFT JOIN (
                SELECT 1 as online, name
                FROM inquisitor.players
                WHERE online = 1
            ) o ON (o.name = a.playername)
            WHERE a.playername = IFNULL(:playername, playername)
            AND (sh.ipaddress = IFNULL(:ipaddress, sh.ipaddress))
            AND ((:date_begin IS NULL) OR (:date_begin <= date(sh.logintime)))
            AND ((:date_end IS NULL) OR (:date_end >= date(sh.logintime)))
            AND ((:valid = 0) OR ((:valid = 1) AND (DATE_ADD(sh.logintime, INTERVAL :length SECOND) > NOW())))
            AND ((:invalid = 0) OR ((:invalid = 1) AND (DATE_ADD(sh.logintime, INTERVAL :length SECOND) <= NOW())))
            AND ((:online = 0) OR (:online = 1 AND o.online = 1))
            AND ((:websession = 0) OR (:websession = 1 AND sh.websession = 1))
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

    public static function delete($args = []) {

        if (is_array($args)) {
            $sql_in = implode(",", array_fill(0, count($args), "?"));
        } else {
            $sql_in = "?";
        }

        $q = "DELETE FROM sessions
        WHERE accountid IN ($sql_in);";

        $result = Bitch::source('default')->query($q, $args);
        
        return $result;
    }

}

?>