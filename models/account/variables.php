<?

namespace models\account\variables;

use minecraftia\db\Bitch;
use helpers\notice\NoticeHelper;

class AccountVariables {

    private static $args = [
        "accountid" => null,
        "key" => null,
        "page" => 1,
        "per_page" => 20,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {

        $args = array_merge(Accounts::$args, $args);

        $q = "SELECT count(1) AS total
            FROM accounts_variables a
            WHERE a.accountid = ifnull(:accountid, a.accountid)
            AND a.key = ifnull(:key, a.key)";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {

        $args = array_merge(Accounts::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $q = "SELECT count(1) AS total
            FROM accounts_variables a
            WHERE a.accountid = ifnull(:accountid, a.accountid)
            AND a.key = ifnull(:key, a.key)
        ORDER BY $order_by $asc_desc
        LIMIT :index, :per_page";

        $args["index"] = ($args["page"] - 1) * $args["per_page"];

        $result = Bitch::source('default')->all($q, $args);

        if (!is_array($result)) {
            return [];
        } else {
            return $result;
        }
    }

    public static function first($args = [], $inquisitor_full = false) {
        $result = Accounts::get($args, $inquisitor_full);

        if (!is_array($result)) {
            return null;
        } else if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public static function getValue($accountid, $key) {

        $result = AccountVariables::first(compact('accountid', 'key'));
        return $result;

    }

    public static function setValue($accountid, $key, $value) {

        $q = "INSERT INTO account_variables(accountid, key, value),
        VALUES(:accountid, :key, :value)
        ON DUPLICATE KEY UPDATE key = :key, value = :value";

        $result = Bitch::source('default')->query($q, compact('accountid', 'key', 'value'));

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }

}

?>
