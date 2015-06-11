<?

namespace models\account\tickets;

use minecraftia\db\Bitch;
use helpers\notice\NoticeHelper;

class AccountTickets {

    private static $args = [
        "id" => null,
        "owner" => null,
        "admin" => null,
        "ticket_date_begin" => null,
        "ticket_date_end" => null,
        "expiration_date_begin" => null,
        "expiration_date_end" => null,
        "description" => null,
        "adminreply" => null,
        "userreply" => null,
        "status" => null,
        "page" => 1,
        "per_page" => 20,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {

        $args = array_merge(AccountTickets::$args, $args);

        $q = "SELECT COUNT(1) AS total
            FROM minecraft_tickets.SHT_Tickets t
            WHERE ((:id is NULL) OR (t.id = :id))
            AND t.owner = IFNULL(:owner, t.owner)
            AND t.admin = IFNULL(:admin, t.admin)
            AND ((:ticket_date_begin IS NULL) OR (:ticket_date_begin <= DATE(t.date)))
            AND ((:ticket_date_end IS NULL) OR (:ticket_date_end >= DATE(t.date)))
            AND ((:expiration_date_begin IS NULL) OR (:expiration_date_begin <= DATE(t.expiration)))
            AND ((:expiration_date_end IS NULL) OR (:expiration_date_end >= DATE(t.expiration)))
            AND ((:description IS NULL) OR (LOWER(t.description) LIKE LOWER(:description)))
            AND ((:adminreply IS NULL) OR (LOWER(t.adminreply) LIKE LOWER(:adminreply)))
            AND ((:userreply IS NULL) OR (LOWER(t.userreply) LIKE LOWER(:userreply)))
            AND ((:status IS NULL) OR (t.status = :status))";


        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {

        $args = array_merge(AccountTickets::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $q = "SELECT * FROM (
                SELECT t.*, a_owner.id AS ownerid, a_admin.id AS adminid
                FROM minecraft_tickets.SHT_Tickets t
                  LEFT JOIN minecraft_auth.accounts a_owner ON t.owner = a_owner.playername
                  LEFT JOIN minecraft_auth.accounts a_admin ON t.admin = a_admin.playername
                WHERE ((:id is NULL) OR (t.id = :id))
                AND ((t.owner = IFNULL(:owner, t.owner)) OR (t.owner IS NULL and :owner IS NULL))
                AND ((t.admin = IFNULL(:admin, t.admin)) OR (t.admin IS NULL and :admin IS NULL))
                AND ((:ticket_date_begin IS NULL) OR (:ticket_date_begin <= DATE(t.date)))
                AND ((:ticket_date_end IS NULL) OR (:ticket_date_end >= DATE(t.date)))
                AND ((:expiration_date_begin IS NULL) OR (:expiration_date_begin <= DATE(t.expiration)))
                AND ((:expiration_date_end IS NULL) OR (:expiration_date_end >= DATE(t.expiration)))
                AND ((:description IS NULL) OR (LOWER(t.description) LIKE LOWER(:description)))
                AND ((:adminreply IS NULL) OR (LOWER(t.adminreply) LIKE LOWER(:adminreply)))
                AND ((:userreply IS NULL) OR (LOWER(t.userreply) LIKE LOWER(:userreply)))
                AND ((:status IS NULL) OR (t.status = :status))
        ) pages
        ORDER BY $order_by $asc_desc
        LIMIT :index, :per_page";

        $args["index"] = ($args["page"] - 1) * $args["per_page"];

        unset($args["page"]);
        unset($args["order_by"]);
        unset($args["asc_desc"]);

        $result = Bitch::source('default')->all($q, $args);

        if (!is_array($result)) {
            return [];
        } else {
            return $result;
        }
    }

    public static function first($args = []) {
        $result = AccountTickets::get($args);

        if (!is_array($result)) {
            return null;
        } else if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public static function toggle($parameters) {
        $q = "UPDATE minecraft_tickets.SHT_Tickets t
        SET t.status = IF(t.status = 'OPEN', 'CLOSED', 'OPEN')
        WHERE t.id = :id
        ";

        if (array_key_exists('owner', $parameters)) {
            $q .= "AND t.owner = :owner";
        }

        $result = Bitch::source('default')->query($q, $parameters);

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }

    public static function assign($parameters) {
        $q = "UPDATE minecraft_tickets.SHT_Tickets t
        SET t.admin = :admin
        WHERE t.id = :id";

        $result = Bitch::source('default')->query($q, $parameters);

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }

    public static function admin_reply($parameters) {
        $q = "UPDATE minecraft_tickets.SHT_Tickets t
        SET t.admin = :admin,
          t.adminreply = CONCAT(:admin, ': ', :reply)
        WHERE t.id = :id";

        $result = Bitch::source('default')->query($q, $parameters);

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }

    public static function user_reply($parameters) {
        $q = "UPDATE minecraft_tickets.SHT_Tickets t
        SET t.userreply = :reply
        WHERE t.id = :id AND t.owner = :owner";

        $result = Bitch::source('default')->query($q, $parameters);

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }
}

?>
