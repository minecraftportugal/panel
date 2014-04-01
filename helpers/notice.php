<?

namespace helpers\notice;

class NoticeHelper {

    function set($type, $message) {
        if (!isset($_SESSION["notice"])) {
             $_SESSION["notice"] = [];
        }

        $_SESSION["notice"][$type] = $message;
    }

    function get($type = null) {

        if (!isset($_SESSION["notice"])) {
             $_SESSION["notice"] = [];
        }

        if ($type == null) {

            $notice = $_SESSION["notice"];
            unset($_SESSION["notice"]);
            return $notice;

        } else {

            if (isset($_SESSION["notice"][$type])) {
                $notice = $_SESSION["notice"][$type];
                unset($_SESSION["notice"][$type]);
                return $notice;
            }    else {
                return false;
            }
        }

    }

    function render($args = []) {

        $defaults = [
            "classes" => ""
        ];

        $args = array_merge($defaults, $args);
        
        $error = NoticeHelper::get('error');
        if ($error != false) {
            return "<span class=\"" . $args['classes'] . " closeable notice error\">
                      <h1>$error
                      <span class=\"close-parent\">
                        <i class=\"fa fa-times\"></i></a>
                      </span>
                      </h1>
                    </span>";
        }
    
        $success = NoticeHelper::get('success');
        if ($success != false) {
            return "<span class=\"" . $args['classes'] . " closeable notice success\">
                      <h1>$success
                      <span class=\"close-parent\">
                        <i class=\"fa fa-times\"></i>
                      </span>
                      </h1>
                    </span>";
        }

    }

}

?>
