<?

use models\account\Account;

function v_test() {

  $account = new Account();

  echo"<pre>";
  var_dump($account->get([], "id desc"));
  echo "</pre>";

  require('templates/test/index.php');
}

?>
