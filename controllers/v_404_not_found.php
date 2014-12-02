<?

function v_404_not_found() {
  http_response_code("404");
  require('helpers/selfurl.php');
  require('templates/v_404_not_found.php');
}

?>