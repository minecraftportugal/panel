<?

function setFlash($type, $message) {
  if (!isset($_SESSION["flash"])) {
  	$_SESSION["flash"] = [];
  }

  $_SESSION["flash"][$type] = $message;
}

function getFlash($type) {
  if (isset($_SESSION["flash"][$type])) {
  	$flash = $_SESSION["flash"][$type];
  	unset($_SESSION["flash"][$type]);
  	return $flash;
  }  else {
  	return false;
  }
}

?>