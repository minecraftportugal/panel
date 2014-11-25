<?

namespace helpers\minotar;


class MinotarHelper {
    function head($username, $size, $margin = 0) {
        return "<img style=\"width: $size"."px; height: $size"."px; margin: $margin"."px;\" src=\"" . MINOTAR_SERVER . "/avatar/$username/$size\">"; // /!\
    }

    function skin($username) {
        return "<img src=\"" . MINOTAR_SERVER ."/skin/$username\">"; //!\\
    }

    function url($username, $size) {
        return MINOTAR_SERVER . "/avatar/$username/$size";
    }

    function skin_url($username) {
        return MINOTAR_SERVER . "/skin/$username";
    }

}

?>