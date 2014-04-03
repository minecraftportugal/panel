<?

namespace models\fail;

use minecraftia\db\Bitch;

class FailModel {

    private static $args = [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "event_type" => null,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {
        $args = array_merge(FailModel::$args, $args);

        /* Other models don't need this. Why? /!\ */
        $args = array_intersect_key($args, array_flip(["accountid", "event_type"]));

        $q = "SELECT COUNT(1) AS total
        FROM fail_log fl
        WHERE ((:accountid IS NULL) OR (fl.accountid = :accountid))
        AND ((:event_type IS NULL) OR (fl.event_type = :event_type))";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {
        $args = array_merge(FailModel::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        /* Other models don't need this. Why? /!\ */
        $args = array_intersect_key($args, array_flip(["accountid", "event_type", "page", "per_page"]));

        $q = "SELECT * FROM (
            SELECT fl.time, fl.event_type, fl.accountid, fl.ipaddress, fl.comment
            FROM fail_log fl
            WHERE ((:accountid IS NULL) OR (fl.accountid = :accountid))
            AND ((:event_type IS NULL) OR (fl.event_type = :event_type))
            ORDER BY $order_by $asc_desc
        ) x LIMIT :index, :per_page;";
        
        $args["index"] = ($args["page"] - 1) * $args["per_page"];

        $result = Bitch::source('default')->all($q, $args);

        if (!is_array($result)) {
            return [];
        } else {
            return $result;
        }
    }

    public static function create($event_type, $accountid, $ipaddress, $comment) {

        $q = "INSERT INTO fail_log(time, event_type, accountid, ipaddress, comment)
        VALUES(NOW(), :event_type, :accountid, :ipaddress, :comment)";

        $result = Bitch::source('default')->query($q, 
            compact('event_type', 'accountid', 'ipaddress', 'comment'));


        if (!$result) {
            die('Invalid query');
        }

        return true;
    }

    public static function delete($delete) {
        if (count($delete) > 0) {
            $sql_in = implode(',', array_fill(0, count($delete), '?'));

            $q = "DELETE FROM fail_log
            WHERE id IN ($sql_in);";
            $result = Bitch::source('default')->query($q, $delete);
            if (!$result) { die('Invalid query'); }
        }

        return true;
    }


}

?>
