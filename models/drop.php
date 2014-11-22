<?

namespace models\drop;

use minecraftia\db\Bitch;

class DropModel {

    private static $args = [
        "page" => 1,
        "per_page" => 20,
        "accountid" => null,
        "drop_date_begin" => null,
        "drop_date_end" => null,
        "taken_date_begin" => null,
        "taken_date_end" => null,
        "delivered" => 0,
        "undelivered" => 0,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {
        $args = array_merge(DropModel::$args, $args);

        /* Other models don't need this. Why? /!\ */
        $args = array_intersect_key($args, array_flip(["accountid", "drop_date_begin", "drop_date_end", "taken_date_begin", "taken_date_end", "undelivered", "delivered"]));

        $q = "SELECT COUNT(1) AS total
        FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
        WHERE ((:accountid IS NULL) OR (accountid = :accountid))
        AND ((:drop_date_begin IS NULL) OR (:drop_date_begin <= date(dropdate)))
        AND ((:drop_date_end IS NULL) OR (:drop_date_end >= date(dropdate)))
        AND ((:taken_date_begin IS NULL) OR (:taken_date_begin <= date(takendate)))
        AND ((:taken_date_end IS NULL) OR (:taken_date_end >= date(takendate)))
        AND ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
        AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {
        $args = array_merge(DropModel::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $q = "SELECT * FROM (
            SELECT i.id, i.itemdrop, i.itemnumber, i.itemaux,
                DATE_FORMAT(i.dropdate, '%b %d %H:%i:%s %Y') as dropdate,
                DATE_FORMAT(i.takendate, '%b %d %H:%i:%s %Y') as takendate,
                i.dropdate as dropdate_df,
                i.takendate as takendate_df,
                IFNULL(timediff(takendate, dropdate), 'Não Entregue') AS idledroptime,
                a.playername, a.id as accountid
                FROM itemdrops i INNER JOIN accounts a ON i.accountid = a.id
                WHERE ((:accountid IS NULL) OR (accountid = :accountid))
                AND ((:drop_date_begin IS NULL) OR (:drop_date_begin <= date(dropdate)))
                AND ((:drop_date_end IS NULL) OR (:drop_date_end >= date(dropdate)))
                AND ((:taken_date_begin IS NULL) OR (:taken_date_begin <= date(takendate)))
                AND ((:taken_date_end IS NULL) OR (:taken_date_end >= date(takendate)))
                AND ((:undelivered = 0) OR (:undelivered = 1 AND takendate IS NULL))
                AND ((:delivered = 0) OR (:delivered = 1 AND takendate IS NOT NULL))
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

    public static function create($accountid, $itemdrop, $itemnumber, $itemaux) {

        $q = "INSERT INTO itemdrops(accountid,itemdrop, itemaux, itemnumber, dropdate)
        VALUES(:accountid, :itemdrop, :itemaux, :itemnumber, NOW())";

        $result = Bitch::source('default')->query($q, 
            compact('accountid', 'itemdrop', 'itemaux', 'itemnumber'));


        if (!$result) {
            die('Invalid query');
        }

        return true;
    }

    public static function delete($delete) {
        if (count($delete) > 0) {
            $sql_in = implode(',', array_fill(0, count($delete), '?'));

            $q = "DELETE FROM itemdrops
            WHERE id IN ($sql_in);";
            $result = Bitch::source('default')->query($q, $delete);
            if (!$result) { die('Invalid query'); }
        }

        return true;
    }


}

?>
