<?

namespace helpers\minotar;


class MinotarHelper {

    public static function head($username, $size, $margin = "0px") {
        $intsize = intval($size);
        return "<img style=\"width: $size; height: $size; margin: $margin;\" src=\"" . MINOTAR_SERVER . "/avatar/$username/$intsize\">"; // /!\
    }

    public static function skin($username) {
        return "<img src=\"" . MINOTAR_SERVER ."/skin/$username\">"; //!\\
    }

    public static function url($username, $size) {
        return MINOTAR_SERVER . "/avatar/$username/$size";
    }

    public static function skin_url($username) {
        return MINOTAR_SERVER . "/skin/$username";
    }

}

?>