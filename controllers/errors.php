<?

function notfound() {
  http_response_code("404");
  require('templates/404.php');
}

function forbidden() {
  http_response_code("500");
  require('templates/500.php');
}

?>