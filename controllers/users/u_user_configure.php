<?

use lib\session\Session;
use models\accounts\Accounts;
use helpers\notice\NoticeHelper;

function u_user_configure() {

  //session: admin
  Session::validateSession(true);
  Session::validateXSRFToken();

  $id = $_POST['id'];

  $admin = isset($_POST['admin']) ? $_POST['admin'] : 0;
  $operator = isset($_POST['operator']) ? $_POST['operator'] : 0;
  $active = isset($_POST['active']) ? $_POST['active'] : 0;
  $donor = isset($_POST['donor']) ? $_POST['donor'] : 0;
  $contributor = isset($_POST['contributor']) ? $_POST['contributor'] : 0;
  $delete = isset($_POST['delete']) ? $_POST['delete'] : 0;
  
  $status = Accounts::configure($id, $admin, $operator, $active, $donor, $contributor, $delete);
  
  if ($status == 1) {
    header("Location: /profile?id=$id#adminactions");
  } else if ($status == 2) {
    header("Location: /admin");
  } else {
    header("Location: /profile?id=$id#adminactions");
  }
}

?>
