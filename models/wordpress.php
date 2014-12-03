<?

namespace models\wordpress;
use minecraftia\db\Bitch;

class WordpressModel {

    private static $args = [
        "id" => null
    ];

    public static function init() {

        /* Wordpress */
        if (WP_ENABLED) {
            require_once(WP_LOCATION . "/wp-config.php");
        }

    }

    public static function count($args = []) {


    }

    public static function get($args = []) {

    }

    public static function first($args = []) {

    }

}