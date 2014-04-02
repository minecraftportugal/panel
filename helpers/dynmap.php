<?

namespace helpers\dynmap;

class DynmapHelper {

    function map($playername = null, $block = true) {
        global $cfg_dynmap_url;

        $url = "$cfg_dynmap_url";

        if (!is_null($playername)) {
            $url = "$cfg_dynmap_url/?playername=$playername";
        }

        if ($block) {
            $html = "<iframe src=\"$url\"></iframe><div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\"></iframe>";
        }

        return $html;
    }

}

?>
