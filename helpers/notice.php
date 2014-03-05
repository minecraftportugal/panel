<?

namespace helpers\notice;

class NoticeHelper {

  function setFlash($type, $message) {
    if (!isset($_SESSION["notice"])) {
       $_SESSION["notice"] = [];
    }

    $_SESSION["notice"][$type] = $message;
  }

  function get($type = null) {

    if ($type = null) {

      if (!isset($_SESSION["notice"])) {
         $_SESSION["notice"] = [];
      }

      $notice = $_SESSION["notice"];
      unset($_SESSION["notice"]):
      return $notice;

    } else {

      if (isset($_SESSION["notice"][$type])) {
        $flash = $_SESSION["notice"][$type];
        unset($_SESSION["notice"][$type]);
        return $flash;
      }  else {
        return false;
      }
    }
    
  }

}

?>