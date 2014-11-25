<?

use models\account\Account;

function test_index() {

  $account = new Account();

  echo"<pre>";
  var_dump($account->get([], "id desc"));
  echo "</pre>";

  require('templates/test/index.php');
}

?>
