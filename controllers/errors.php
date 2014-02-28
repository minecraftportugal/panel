<?

function notfound() {
  http_response_code("404");
  require('helpers/selfurl.php');
  require('templates/404.php');
}

function forbidden() {
  http_response_code("403");
  require('templates/403.php');
}

function testpattern() {
  require('templates/testpattern.html');
}

?>