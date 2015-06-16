<?

namespace helpers\json;

class JSONHelper {

    public static function respond($response) {

        if (is_string($response)) {
            header('Content-Type: application/json');
            echo $response;
        } else if (is_object($response) or is_array($response)) {
            header('Content-Type: application/json');
            echo json_encode($response);
        }

    }


}

?>