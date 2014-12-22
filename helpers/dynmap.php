<?

namespace helpers\dynmap;

class DynmapHelper {

    function map($playername = null, $block = true) {

        $url = DYNMAP_URL;

        if (!is_null($playername)) {
            $url = DYNMAP_URL . "?playername=$playername";
        }

        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe> <div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe>";
        }

        return $html;
    }

    function map_position($position, $world, $block = true) {

        $x = round($position[0]);
        $y = round($position[1]);
        $z = round($position[2]);

        $url = DYNMAP_URL . "?zoom=6&worldname=$world&x=$x&y=$y&z=$z";


        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe><div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe>";
        }

        return $html;
    }

    function map_offline() {
        $url = "/testpattern";

        $html = "<iframe src=\"$url\"></iframe><div class=\"iframe-block\"></div>";

        return $html;
    }

}

?>
