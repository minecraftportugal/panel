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
      }  else {
        return false;
      }
    }

  }

  function render() {
    
    $error = NoticeHelper::get('error');
    if ($error != false) {
      return "<div class=\"section error\">$error</div>";
    }
  
    $success = NoticeHelper::get('success');
    if ($success != false) {
      return "<div class=\"section success\">$success</div>";
    }

  }

}

?>
