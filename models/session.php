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
        "login" => 0,
        "logout" => 0,
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
        FROM sessions_history sh
        LEFT JOIN accounts a on a.id = sh.accountid
        LEFT JOIN inquisitor.players i ON i.name = a.playername
        WHERE a.playername = IFNULL(:playername, a.playername)
        AND sh.ipaddress = IFNULL(:ipaddress, sh.ipaddress)
        AND ((:date_begin IS NULL) OR (:date_begin <= date(sh.logintime)))
        AND ((:date_end IS NULL) OR (:date_end >= date(sh.logintime)))
        AND ((:login = 0) OR ((:login = 1) AND (sh.event IN (0, 1))))
        AND ((:logout = 0) OR ((:logout = 1) AND (sh.event = 2)))
        AND ((:online = 0) OR (:online = 1 AND i.online = 1))
        AND ((:websession = 0) OR (:websession = 1 AND sh.websession = 1))";
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
                DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate,
                sh.logintime AS logintime_df,
                sh.websession AS websession,
                sh.event AS event,
                DATE_FORMAT(sh.logintime, '%b %d %H:%i:%s %Y') AS logintime,
                DATE_FORMAT(sh.time, '%b %d %H:%i:%s %Y') AS time_df,
                DATE_FORMAT(a.lastlogindate, '%b %d %H:%i:%s %Y') AS lastlogindate,
                IF(DATE_ADD(sh.logintime, INTERVAL :length SECOND) > NOW(), 1, 0) as valid
            FROM sessions_history sh
            LEFT JOIN accounts a on a.id = sh.accountid
            LEFT JOIN inquisitor.players i ON i.name = a.playername
            WHERE a.playername = IFNULL(:playername, a.playername)
            AND sh.ipaddress = IFNULL(:ipaddress, sh.ipaddress)
            AND ((:date_begin IS NULL) OR (:date_begin <= date(sh.logintime)))
            AND ((:date_end IS NULL) OR (:date_end >= date(sh.logintime)))
            AND ((:login = 0) OR ((:login = 1) AND (sh.event IN (0, 1))))
            AND ((:logout = 0) OR ((:logout = 1) AND (sh.event = 2)))
            AND ((:online = 0) OR (:online = 1 AND i.online = 1))
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