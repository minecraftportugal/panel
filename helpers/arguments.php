<?

namespace helpers\arguments;

class ArgumentsHelper {

    public function process($request, $args) {
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

    function serialize($args, $separator = true) {
        $str = '';

        $first = true && $separator;
        foreach ($args as $k => $v) {
            if (!in_array($k, ['page', 'per_page'])) {
                if ($first) {
                  $str .= "?$k=$v";
                } else {
                  $str .= "&$k=$v";
                }
                $first = false;
            }
        }

        return $str;
    }

}

?>