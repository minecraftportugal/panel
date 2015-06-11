<?

namespace helpers\arguments;

class ArgumentsHelper {

    /*
     * ArgumentsHelper::process($request, $args)
     *
     * Mixes $request into $args, returning a new object
     */
    public static function process($request, $args) {
        $array = [];


        foreach ($args as $k => $v) {

            if (isset($request[$k]) and $request[$k] != '') {
                if (is_numeric($request[$k])) {
                    $array[$k] = (float)$request[$k];
                } else {
                    $array[$k] = $request[$k];
                }
            } else {
                $array[$k] = $v;
            }

        }

        return $array;
    }

    public static function serialize($args, $separator = false) {
        $str = '';

        $first = true && $separator;

        foreach ($args as $k => $v) {

            /* skip 'page' and 'per_page' args */
            if (!in_array($k, ['page', 'per_page'])) {
                $str .= $first ? "?" : "&";

                if (!is_array($v)) {
                    $str .= "$k=$v";
                }

                $first = false;
            }

        }

        return $str;
    }

}

?>