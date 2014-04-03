<?

namespace helpers\dynmap;

class DynmapHelper {

    function map($playername = null, $block = true) {
        global $cfg_dynmap_url;

        $url = "$cfg_dynmap_url";

        if (!is_null($playername)) {
            $url = "$cfg_dynmap_url?playername=$playername";
        }

        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"apply_css(this);\"></iframe><div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"apply_css(this);\"></iframe>";
        }

        return $html;
    }

    function map_position($position, $world, $block = true) {
        global $cfg_dynmap_url;

        $url = "$cfg_dynmap_url";

        $x = round($position[0]);
        $y = round($position[1]);
        $z = round($position[2]);

        $url = "$cfg_dynmap_url?zoom=6&worldname=$world&x=$x&y=$y&z=$z";


        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"apply_css(this);\"></iframe><div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"apply_css(this);\"></iframe>";
        }

        return $html;
    }


}

?>
