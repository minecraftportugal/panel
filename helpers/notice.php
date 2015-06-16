<?

namespace helpers\notice;

class NoticeHelper {

    public static function set($type, $message) {
        if (!isset($_SESSION["notice"])) {
             $_SESSION["notice"] = [];
        }

        $_SESSION["notice"][$type] = $message;
    }

    public static function get($type = null) {

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

    public static function render($args = []) {

        $defaults = [
            "classes" => ""
        ];

        $args = array_merge($defaults, $args);
        
        $error = NoticeHelper::get('error');
        if ($error != false) {
            return '<script type="text/javascript">
                App.Toaster.fadeIn({
                    "title" : "<i class=\"fa fa-exclamation-triangle\"></i> Erro!",
                    "message" : "' . $error . '",
                    "classes" : "error",
                    "duration": 3000,
                    "sound" : "break"
                });
            </script>';
        }
    
        $success = NoticeHelper::get('success');
        if ($success != false) {
            return '<script type="text/javascript">
                App.Toaster.fadeIn({
                    "title" : "<i class=\"fa fa-check-circle\"></i> Sucesso!",
                    "message" : "' . $success . '",
                    "classes" : "success",
                    "duration" : 3000
                });
            </script>';
        }

    }

    public static function renderObject($args = []) {

        $defaults = [
            "classes" => ""
        ];

        $args = array_merge($defaults, $args);

        $object = [];

        $error = NoticeHelper::get('error');
        if ($error != false) {
            $object["error"] = [
                "title" => "<i class=\"fa fa-exclamation-triangle\"></i> Erro!",
                "message" => $error,
                "classes" => "error",
                "duration" => 3000,
                "sound" => "break"
            ];
        }

        $success = NoticeHelper::get('success');
        if ($success != false) {
            $object["success"] = [
                "title" => "<i class=\"fa fa-check-circle\"></i> Sucesso!",
                "message" => $success,
                "classes" => "error",
                "duration" => 3000,
                "sound" => "break"
            ];
        }

        return $object;

    }

}

?>
