<?

namespace models\account;

use lib\xauth\xAuth;
use minecraftia\db\Bitch;
use helpers\mail\MailHelper;
use helpers\notice\NoticeHelper;

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
        "asc_desc" => "desc"
    ];

    public static function count($args = []) {
        $args = array_merge(AccountModel::$args, $args);

        $q = "SELECT count(1) AS total
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
        AND ((:register_date_end IS NULL) OR (:register_date_end >= date(registerdate)));";
        
        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = [], $inquisitor_full = false) {
        $args = array_merge(AccountModel::$args, $args);
        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        if ($inquisitor_full) {
            $inquisitor_fields = "name, world, lastUpdate, lastJoin, mapped, totalItemsPickedUp, totalDistanceTraveled, lastKick,
                lavaBucketsEmptied, totalMobsKilled, lastKickMessage, portalsCrossed, sessionTime, level,
                mooshroomsMilked, potionEffects, deaths, foodLevel, lastMobKill, groups, chatMessages, joins,
                waterBucketsEmptied, totalBlocksPlaced, lastDeathMessage, lastQuit, firstJoin, health,
                totalPlayersKilled, lastDeath, mooshroomsSheared, timesSlept, arrowsShot, exp, itemsEnchanted,
                lifetimeExperience, totalTime, sheepDyed, totalExperience, remainingAir, exhaustion, armor,
                sheepSheared, online, money, lavaBucketsFilled, totalItemsCrafted, itemEnchantmentLevels, bedServer,
                bedCoords, quits, firesStarted, totalBlocksBroken, fishCaught, heldItemSlot, lastPlayerKilled,
                fireTicks, lastPlayerKill, totalItemsDropped, gameMode, cowsMilked, coords, lastMobKilled, address,
                saturation, inventory, waterBucketsFilled, server, displayName, bedWorld";
        } else {
            $inquisitor_fields = "name, world, online, totalTime, sessionTime";
        }

        $q = "SELECT * FROM (
            SELECT id, playername, password, pwtype, email,
            active, resetpw, premium, admin, operator, donor, contributor,
            ircnickname, ircpassword, ircauto,
            DATE_FORMAT(registerdate, '%b %d %H:%i %Y') AS registerdate, registerip,
            DATE_FORMAT(lastlogindate, '%b %d %H:%i %Y') AS lastlogindate, lastloginip,
            registerdate as registerdate_df, lastlogindate AS lastlogindate_df,
                o.*
            FROM accounts a LEFT JOIN (
                SELECT $inquisitor_fields
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

    public static function first($args = [], $inquisitor_full = false) {
        $result = AccountModel::get($args, $inquisitor_full);

        if (!is_array($result)) {
            return null;
        } else if (count($result) == 0) {
            return null;
        } else {
            return $result[0];
        }
    }

    public static function delete($args = []) {

        if (is_array($args) && count($args) > 0) {
            $sql_in = implode(",", array_fill(0, count($args), "?"));
        } else if (is_scalar($args)) {
            $sql_in = "?";
        } else {
            return false;
        }

        $q = "DELETE FROM accounts
        WHERE id IN ($sql_in);";

        $result = Bitch::source('default')->query($q, $args);
        
        return $result;
    }


    /* Set/Unset Admin Account Privilege */
    public static function privilege($args = []) {

        if (count($args) == 0) {
            return false;
        }

        foreach ($args as $id => $val) {
            
            $q = "UPDATE accounts
            SET admin = :val
            WHERE id = :id";
            
            $result = Bitch::source('default')->query($q, compact('val', 'id'));
            
            if (!$result) {
                return false;
            }
        }

        return true;

    }


    /* Set/Unset Admin Account Privilege */
    public static function active($args = []) {

        if (count($args) == 0) {
            return false;
        }

        foreach ($args as $id => $val) {
            
            $q = "UPDATE accounts
            SET active = :val
            WHERE id = :id";
            
            $result = Bitch::source('default')->query($q, compact('val', 'id'));
            
            if (!$result) {
                return false;
            }
        }

        return true;

    }

    public static function ip_addresses() {

        $q = "SELECT COUNT(x.lastip) total, x.lastip, GROUP_CONCAT(x.playername) playernames
        FROM (
          SELECT ifnull(lastloginip,registerip) lastip, playername
          FROM accounts
        ) x 
        GROUP BY x.lastip 
        HAVING total > 1
        ORDER BY total DESC";

        $result = Bitch::source('default')->all($q);

        $result = $result != null ? $result : [];

        return $result;
    }

    public static function badges($id) {

        // premium, admin, donor
        $q = "SELECT playername, active, premium, donor, contributor, admin, operator FROM accounts WHERE id = :id;";
        $result = Bitch::source('default')->first($q, compact('id'));

        $badges = [
            'premium' => $result['premium'],
            'admin' => $result['admin'],
            'donor' => $result['donor'],
            'contributor' => $result['contributor'],
            'operator' => $result['operator'],
            'active' => $result['active']
        ];

        $q = "SELECT online, totalTime FROM players WHERE name = :playername";
        $playername = $result['playername'];
        $result = Bitch::source('inquisitor')->first($q, compact('playername'));

        $totalTime = intval($result['totalTime']);
        $badges["member"] = $totalTime > 3600 * 10 ? 1 : 0;
        $badges["online"] = $result["online"] ? 1 : 0;

        return $badges;

    }


    /* Registers a user */
    public static function register($username, $email, $email_ip = false) {

        // check for dupe email
        $q = "SELECT count(*) AS total
            FROM accounts
            WHERE email = :email";
        $result = Bitch::source('default')->first($q, compact('email'))['total']; // /!\ array index applied to function call

        if ($result != "0") {
            NoticeHelper::set('error', 'Email já foi tomado.');
            return false;
        }

        // check for dupe username
        $q = "SELECT count(*) AS total
            FROM accounts
            WHERE playername = :username;";
        $result = Bitch::source('default')->first($q, compact('username'))['total']; // /!\ array index applied to function call

        if ($result != "0") {
            NoticeHelper::set('error', 'Username já foi tomado.');
            return false;
        }

        // check for valid email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            NoticeHelper::set('error', 'Email inválido.');
            return false;
        }

        // check for valid username
        if (!eregi("^([a-zA-Z0-9_]){4,26}$", $username)) {
            NoticeHelper::set('error', 'Username inválido.');
            return false;
        }

        // check for registration spam
        $ip = $_SERVER['REMOTE_ADDR'];
        $q = "SELECT count(*) AS n
            FROM accounts
            WHERE registerip = :ip
            AND now()-registerdate < 500";
        $result = Bitch::source('default')->first($q, compact('ip'));

        if ($result['n'] > 0) {
            NoticeHelper::set('error', '1 registo por IP a cada 5m');
            return false;
        }

        $password = substr(md5(rand()), 0, 7);
        $plain_password = $password;
        $password = xAuth::encryptPassword($password);
        $q = "INSERT INTO accounts(playername, password, pwtype, email, registerdate, registerip, active)
            VALUES(:username, :password, '0', :email, sysdate(), :ip, 1)";
        $result = Bitch::source('default')->query($q, compact('username', 'password', 'email', 'ip'));

        if (!$result) {
            die('Invalid query');
        }

        MailHelper::welcome($username, $plain_password, $email, $email_ip);
        NoticeHelper::set('success', 'Verifica o teu Email');

        return true;
    }

    public static function configure($id, $admin, $operator, $active, $donor, $contributor, $delete) {

        $admin = ($admin == '1' ? 1 : 0);
        $operator = ($operator == '1' ? 1 : 0);
        $active = ($active == '1' ? 1 : 0);
        $donor = ($donor == '1' ? 1 : 0);
        $contributor = ($contributor == '1' ? 1 : 0);
        $delete = ($delete == '1' ? 1 : 0);

        if ($delete == 1) {
            // Delete Accounts
            $q = "DELETE FROM accounts
                WHERE id=:id;";

            $result = Bitch::source('default')->query($q, compact('id'));
            if (!$result) { die('Invalid query'); }

            NoticeHelper::set('success', 'Utilizador apagado.');
            return 2;
        }


        $q = "UPDATE accounts
        SET admin=:admin,
            operator=:operator,
            active=:active,
            donor=:donor,
            contributor=:contributor
        WHERE id = :id";

        $result = Bitch::source('default')->query($q, compact('admin','operator', 'active', 'donor', 'contributor', 'id'));
        if (!$result) { die('Invalid query'); }

        NoticeHelper::set('success', 'Utilizador alterado.');
        return 1;
    }

    public static function changePassword($id, $password, $new_password, $confirm_password) {

        $q = "SELECT id, playername, password, admin FROM accounts WHERE id = :id AND active = 1;";

        if (!($result = Bitch::source('default')->first($q, compact('id')))
            or  (!xAuth::checkPassword($password, $result['password']))) {
            NoticeHelper::set('error', 'a password original que escreveste está errada');
            return false;
        }

        if ($new_password == $confirm_password) {

            if (strlen($new_password) < 6) {
                NoticeHelper::set('error', 'a nova password deve ter pelo menos 6 caracteres');
                return false;
            }

            $password = xAuth::encryptPassword($new_password);
            $q = "UPDATE accounts
                SET password = :password
                WHERE id = :id";
            $result = Bitch::source('default')->query($q, compact('password', 'id'));
            if (!$result) { die('Invalid query'); }


            NoticeHelper::set('success', 'a password foi alterada com sucesso');
            return true;

        } else {

            NoticeHelper::set('error', 'a nova password é diferente da sua confirmação');
            return false;
        }

    }

    public static function changeIRC($id, $ircnickname, $ircpassword, $ircauto) {

        $q = "UPDATE accounts
        SET ircnickname = :ircnickname,
            ircpassword = :ircpassword,
            ircauto = :ircauto
        WHERE id = :id";
        $result = Bitch::source('default')->query($q, compact('ircnickname', 'ircpassword', 'ircauto', 'id'));
        if (!$result) { die('Invalid query'); }

        NoticeHelper::set('success', 'alterações efectuadas');
        return true;
    }

    public static function resetPassword($id) {

        $player = AccountModel::first(['id' => $id]);
        $username = $player['playername'];
        $email = $player['email'];
        $password = substr(md5(rand()), 0, 7);
        $plain_password = $password;
        $password = xAuth::encryptPassword($password);

        $q = "UPDATE accounts
            SET password = :password
            WHERE id = :id";
        $result = Bitch::source('default')->query($q, compact('password', 'id'));

        if (!$result) {
            die('Invalid query');
        }

        MailHelper::welcome($username, $plain_password, $email);

        return true;
    }

}

?>
