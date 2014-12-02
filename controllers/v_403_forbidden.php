<?

function v_403_forbidden() {

  http_response_code("403");

  require('templates/v_403_forbidden.php');
}

?>