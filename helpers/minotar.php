<?

namespace helpers\minotar;

class MinotarHelper {
  function head($username, $size) {
    return "<img style=\"width: $size"."px;\" src=\"https://minotar.net/avatar/$username/$size\">";
  }
  
  function url($username, $size) {
    return "https://minotar.net/avatar/$username/$size";
  }

}

?>
