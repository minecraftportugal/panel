<?

namespace models\bans;

use minecraftia\db\Bitch;

class Bans {

    private static $args = [
        "page" => 1,
        "per_page" => 20,
        "subject" => null,
        "banner" => null,
        "bantype" => null,
        "created_date_begin" => null,
        "created_date_end" => null,
        "expires_date_begin" => null,
        "expires_date_end" => null,
        "permanent" => 0,
        "temporary" => 0,
        "expired" => 0,
        "effective" => 0
    ];

    public static function count($args = []) {
        $args = array_merge(Bans::$args, $args);

        $args = array_intersect_key($args, array_flip([
            "subject", "banner", "bantype", "created_date_begin",
            "created_date_end", "expires_date_begin", "expires_date_end",
            "permanent", "expired", "temporary", "effective"
        ]));

        $q = "SELECT SUM(x.total) AS total FROM (
                  SELECT COUNT(1) AS total
                  FROM minecraft_maxbans.ipbans bip
                  WHERE 1 = 1
                  AND ((:subject IS NULL) OR (bip.ip = :subject))
                  AND ((:banner IS NULL) OR (bip.banner = :banner))
                  AND ((:bantype IS NULL) OR ('IP' = :bantype))
                  AND ((:created_date_begin IS NULL) OR (:created_date_begin <= date(bip.time)))
                  AND ((:created_date_end IS NULL) OR (:created_date_end >= date(bip.time)))
                  AND ((:expires_date_begin IS NULL) OR (:expires_date_begin <= date(bip.expires)))
                  AND ((:expires_date_end IS NULL) OR (:expires_date_end >= date(bip.expires)))
                  AND ((:permanent = 0) OR (:permanent = 1 AND bip.expires = 0))
                  AND ((:temporary = 0) OR (:temporary = 1 AND bip.expires > 0))
                  AND ((:expired = 0) OR (:expired = 1 AND (bip.expires / 1000) < UNIX_TIMESTAMP() AND bip.expires > 0))
                  AND ((:effective = 0) OR (:effective = 1 AND (bip.expires / 1000) > UNIX_TIMESTAMP() OR bip.expires = 0))
                  UNION
                  SELECT COUNT(1) AS total
                  FROM minecraft_maxbans.bans ban
                  WHERE 1 = 1
                  AND ((:subject IS NULL) OR (ban.name = :subject))
                  AND ((:banner IS NULL) OR (ban.banner = :banner))
                  AND ((:bantype IS NULL) OR ('NAME' = :bantype))
                  AND ((:created_date_begin IS NULL) OR (:created_date_begin <= date(ban.time)))
                  AND ((:created_date_end IS NULL) OR (:created_date_end >= date(ban.time)))
                  AND ((:expires_date_begin IS NULL) OR (:expires_date_begin <= date(ban.expires)))
                  AND ((:expires_date_end IS NULL) OR (:expires_date_end >= date(ban.expires)))
                  AND ((:permanent = 0) OR (:permanent = 1 AND ban.expires = 0))
                  AND ((:temporary = 0) OR (:temporary = 1 AND ban.expires > 0))
                  AND ((:expired = 0) OR (:expired = 1 AND (ban.expires / 1000) < UNIX_TIMESTAMP() AND ban.expires > 0))
                  AND ((:effective = 0) OR (:effective = 1 AND NOT (ban.expires / 1000) > UNIX_TIMESTAMP() OR ban.expires = 0))
                  UNION
                  SELECT COUNT(1) AS total
                  FROM minecraft_maxbans.mutes bmu
                  WHERE 1 = 1
                  AND ((:subject IS NULL) OR (bmu.name = :subject))
                  AND ((:banner IS NULL) OR (bmu.muter = :banner))
                  AND ((:bantype IS NULL) OR ('MUTE' = :bantype))
                  AND ((:created_date_begin IS NULL) OR (:created_date_begin <= date(bmu.time)))
                  AND ((:created_date_end IS NULL) OR (:created_date_end >= date(bmu.time)))
                  AND ((:expires_date_begin IS NULL) OR (:expires_date_begin <= date(bmu.expires)))
                  AND ((:expires_date_end IS NULL) OR (:expires_date_end >= date(bmu.expires)))
                  AND ((:permanent = 0) OR (:permanent = 1 AND bmu.expires = 0))
                  AND ((:temporary = 0) OR (:temporary = 1 AND bmu.expires > 0))
                  AND ((:expired = 0) OR (:expired = 1 AND (bmu.expires / 1000) < UNIX_TIMESTAMP() AND bmu.expires > 0))
                  AND ((:effective = 0) OR (:effective = 1 AND NOT (bmu.expires / 1000) > UNIX_TIMESTAMP() OR bmu.expires = 0))
              ) x;";

        return Bitch::source('default')->first($q, $args)["total"];
    }

    public static function get($args = []) {
        $args = array_merge(Bans::$args, $args);

        $order_by = $args["order_by"];
        $asc_desc = $args["asc_desc"];

        $args["index"] = ($args["page"] - 1) * $args["per_page"];

        $args = array_intersect_key($args, array_flip([
            "subject", "banner", "bantype", "created_date_begin",
            "created_date_end", "expires_date_begin", "expires_date_end",
            "permanent", "expired", "temporary", "effective",
            "index", "per_page"
        ]));

//var_dump($args); die();
        $q = "SELECT * FROM (
              SELECT bip.ip AS subject, bip.reason, IFNULL(a2.playername, bip.banner) AS banner,
                    IF(bip.time = 0, '', FROM_UNIXTIME(bip.time / 1000)) AS time_df,
                    IF(bip.time = 0, '', FROM_UNIXTIME(bip.time / 1000, '%b %d %H:%i:%s %Y')) as time,
                    IF(bip.expires = 0, '', FROM_UNIXTIME(bip.expires / 1000)) AS expires_df,
                    IF(bip.expires = 0, '', FROM_UNIXTIME(bip.expires / 1000, '%b %d %H:%i:%s %Y')) as expires,
                    IF(bip.time = 0, '', SEC_TO_TIME(UNIX_TIMESTAMP() - (bip.time / 1000))) AS delta_past,
                    IF(bip.expires = 0, '', SEC_TO_TIME((bip.expires / 1000) - UNIX_TIMESTAMP())) AS delta_future,
                    'IP' AS bantype,
                    null AS accountid,
                    a2.id AS banneraccountid
              FROM minecraft_maxbans.ipbans bip
                LEFT JOIN minecraft_auth.accounts a2 ON bip.banner = a2.playername
              WHERE 1 = 1
              AND ((:subject IS NULL) OR (bip.ip = :subject))
              AND ((:banner IS NULL) OR (bip.banner = :banner))
              AND ((:bantype IS NULL) OR ('IP' = :bantype))
              AND ((:permanent = 0) OR (:permanent = 1 AND bip.expires = 0))
              AND ((:temporary = 0) OR (:temporary = 1 AND bip.expires > 0))
              AND ((:expired = 0) OR (:expired = 1 AND (bip.expires / 1000) < UNIX_TIMESTAMP() AND bip.expires > 0))
              AND ((:effective = 0) OR (:effective = 1 AND (bip.expires / 1000) > UNIX_TIMESTAMP() OR bip.expires = 0))
              UNION
              SELECT IFNULL(a.playername, ban.name) AS subject, ban.reason, IFNULL(a2.playername, ban.banner) AS banner,
                    IF(ban.time = 0, '', FROM_UNIXTIME(ban.time / 1000)) AS time_df,
                    IF(ban.time = 0, '', FROM_UNIXTIME(ban.time / 1000, '%b %d %H:%i:%s %Y')) as time,
                    IF(ban.expires = 0, '', FROM_UNIXTIME(ban.expires / 1000)) AS expires_df,
                    IF(ban.expires = 0, '', FROM_UNIXTIME(ban.expires / 1000, '%b %d %H:%i:%s %Y')) as expires,
                    IF(ban.time = 0, '', SEC_TO_TIME(UNIX_TIMESTAMP() - (ban.time / 1000))) AS delta_past,
                    IF(ban.expires = 0, '', SEC_TO_TIME((ban.expires / 1000) - UNIX_TIMESTAMP())) AS delta_future,
                    'NAME' AS bantype,
                    a.id AS accountid,
                    a2.id AS banneraccountid
              FROM minecraft_maxbans.bans ban
                LEFT JOIN minecraft_auth.accounts a ON ban.name = a.playername
                LEFT JOIN minecraft_auth.accounts a2 ON ban.banner = a2.playername
              WHERE 1 = 1
              AND ((:subject IS NULL) OR (ban.name = :subject))
              AND ((:banner IS NULL) OR (ban.banner = :banner))
              AND ((:bantype IS NULL) OR ('NAME' = :bantype))
              AND ((:permanent = 0) OR (:permanent = 1 AND ban.expires = 0))
              AND ((:temporary = 0) OR (:temporary = 1 AND ban.expires > 0))
              AND ((:expired = 0) OR (:expired = 1 AND (ban.expires / 1000) < UNIX_TIMESTAMP() AND ban.expires > 0))
              AND ((:effective = 0) OR (:effective = 1 AND (ban.expires / 1000) > UNIX_TIMESTAMP() OR ban.expires = 0))
              UNION
              SELECT IFNULL(a.playername, bmu.name) AS subject, bmu.reason, IFNULL(a2.playername, bmu.muter) AS banner,
                    IF(bmu.time = 0, '', FROM_UNIXTIME(bmu.time / 1000)) AS time_df,
                    IF(bmu.time = 0, '', FROM_UNIXTIME(bmu.time / 1000, '%b %d %H:%i:%s %Y')) as time,
                    IF(bmu.expires = 0, '', FROM_UNIXTIME(bmu.expires / 1000)) AS expires_df,
                    IF(bmu.expires = 0, '', FROM_UNIXTIME(bmu.expires / 1000, '%b %d %H:%i:%s %Y')) as expires,
                    IF(bmu.time = 0, '', SEC_TO_TIME(UNIX_TIMESTAMP() - (bmu.time / 1000))) AS delta_past,
                    IF(bmu.expires = 0, '', SEC_TO_TIME((bmu.expires / 1000) - UNIX_TIMESTAMP())) AS delta_future,
                    'MUTE' AS bantype,
                    a.id AS accountid,
                    a2.id AS banneraccountid
              FROM minecraft_maxbans.mutes bmu
                LEFT JOIN minecraft_auth.accounts a ON bmu.name = a.playername
                LEFT JOIN minecraft_auth.accounts a2 ON bmu.muter = a2.playername
              WHERE 1 = 1
              AND ((:subject IS NULL) OR (bmu.name = :subject))
              AND ((:banner IS NULL) OR (bmu.muter = :banner))
              AND ((:bantype IS NULL) OR ('MUTE' = :bantype))
              AND ((:permanent = 0) OR (:permanent = 1 AND bmu.expires = 0))
              AND ((:temporary = 0) OR (:temporary = 1 AND bmu.expires > 0))
              AND ((:expired = 0) OR (:expired = 1 AND (bmu.expires / 1000) < UNIX_TIMESTAMP() AND bmu.expires > 0))
              AND ((:effective = 0) OR (:effective = 1 AND (bmu.expires / 1000) > UNIX_TIMESTAMP() OR bmu.expires = 0))
        ) x
        WHERE 1 = 1
        AND ((:created_date_begin IS NULL) OR (:created_date_begin <= date(x.time_df)))
        AND ((:created_date_end IS NULL) OR (:created_date_end >= date(x.time_df)))
        AND ((:expires_date_begin IS NULL) OR (:expires_date_begin <= date(x.expires_df)))
        AND ((:expires_date_end IS NULL) OR (:expires_date_end >= date(x.expires_df)))
        ORDER BY $order_by $asc_desc
        LIMIT :index, :per_page;";

        $result = Bitch::source('default')->all($q, $args);

        if (!is_array($result)) {
            return [];
        } else {
            return $result;
        }
    }

    public static function create() {
        return true;
    }

    public static function update() {
        return true;
    }

    public static function delete($ids) {
        return true;
    }


}

?>
