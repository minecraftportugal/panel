<?

function notfound() {
  http_response_code("404");
  require('templates/404.php');
}

function forbidden() {
  http_response_code("403");
  require('templates/403.php');
}

?>