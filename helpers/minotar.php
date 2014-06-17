<?

namespace helpers\minotar;

require_once("config.php");

class MinotarHelper {
    function head($username, $size, $margin = 0) {
        global $cfg_minotar_server;
        return "<img style=\"width: $size"."px; height: $size"."px; margin: $margin"."px;\" src=\"$cfg_minotar_server/avatar/$username/$size\">"; // /!\
    }

    function skin($username) {
        global $cfg_minotar_server;
        return "<img src=\"$cfg_minotar_server/skin/$username\">"; //!\\
    }

    function url($username, $size) {
        global $cfg_minotar_server;
        return "$cfg_minotar_server/avatar/$username/$size";
    }

    function skin_url($username) {
        global $cfg_minotar_server;
        return "$cfg_minotar_server/skin/$username";
    }

}

?>