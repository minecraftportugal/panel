<?

namespace models\account\variables;

use minecraftia\db\Bitch;
use helpers\notice\NoticeHelper;

class AccountVariables {

    private static $args = [
        "accountid" => null,
        "variable" => null,
        "page" => 1,
        "per_page" => 20,
        "order_by" => "1",
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {

        $args = array_merge(AccountVariables::$args, $args);

        $q = "SELECT count(1) AS total
            FROM accounts_variables a
            WHERE a.accountid = ifnull(:accountid, a.accountid)
            AND a.variable = ifnull(:variable, a.variable)";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {

        $args = array_merge(AccountVariables::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $q = "SELECT a.*, a.variable, a.variable_value
            FROM account_variables a
            WHERE a.accountid = ifnull(:accountid, a.accountid)
            AND a.variable = ifnull(:variable, a.variable)
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
        $result = AccountVariables::get($args);

        if (!is_array($result)) {
            return null;
        } else if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public static function getValue($accountid, $variable) {

        $result = AccountVariables::first(compact('accountid', 'variable'));
        return $result;

    }

    public static function setValue($accountid, $variable, $variable_value) {

        $q = "INSERT INTO account_variables(accountid, variable, variable_value)
        VALUES(:accountid, :variable, :variable_value)
        ON DUPLICATE KEY UPDATE variable = :variable, variable_value = :variable_value";

        $result = Bitch::source('default')->query($q, compact('accountid', 'variable', 'variable_value'));

        if (!$result) {
            die('Invalid query');
        }

        return true;

    }

}

?>
