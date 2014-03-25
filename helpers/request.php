<?

namespace helpers\request;

class RequestHelper {

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

}

?>