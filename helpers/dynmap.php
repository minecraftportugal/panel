<?

namespace helpers\dynmap;

class DynmapHelper {

    static function url($playername = null) {
        $url = DYNMAP_URL;

        if (!is_null($playername)) {
            $url = DYNMAP_URL . "?playername=$playername";
        }

        return $url;

    }

    static function map($playername = null, $block = true) {

        $url = DynmapHelper::url($playername);

        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe> <div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe>";
        }

        return $html;
    }

    static function url_position($position, $world) {
        $x = round($position[0]);
        $y = round($position[1]);
        $z = round($position[2]);

        return DYNMAP_URL . "?zoom=6&worldname=$world&x=$x&y=$y&z=$z";
    }

    static function map_position($position, $world, $block = true) {


        $url = DynmapHelper::url_position($position, $world);


        if ($block) {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe><div class=\"iframe-block\"></div>";
        } else {
            $html = "<iframe src=\"$url\" onload=\"App.Iframe.loadCSS(this, 'dynmap/clean');\"></iframe>";
        }

        return $html;
    }

    static function url_offline() {
        return "/testpattern";
    }

    function map_offline() {
        $url = DynmapHelper::url_offline();

        $html = "<iframe src=\"$url\"></iframe><div class=\"iframe-block\"></div>";

        return $html;
    }

}

?>
