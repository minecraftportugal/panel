<?

namespace models\session;

use minecraftia\db\Bitch;

class WordpressModel {

    private static $args = [
        "id" => null
    ];

    public static function init() {
        $wp->init();
        $wp->query_posts();
        $wp->parse_request();
        $wp->register_globals();
        $wp->send_headers();
    }

    public static function count($args = []) {


    }

    public static function get($args = []) {

    }

    public static function first($args = []) {

    }

}