<?
  function selfURL() { 
      function strleft($s1, $s2) { return substr($s1, 0, strpos($s1, $s2)); }

      $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : ""; 
      $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s; 
      $port = (($_SERVER["SERVER_PORT"] == "80") || ($_SERVER["SERVER_PORT"] == "443")) ? "" : (":".$_SERVER["SERVER_PORT"]); 
      return $protocol."://".$_SERVER['SERVER_NAME'].$port.$_SERVER['REQUEST_URI']; 
  }

  function navigation($page, $total, $per_page, $link_extra = null, $page_margin = 4) {

    if ($total == 0)
      return "";

    $total_pages = ceil($total/$per_page);
    $html = "<ul class=\"navigation\">";
    $html .= "<li><a href=\"?page=1$link_extra\">&lt;&lt;</a></li>";
    
    $ellipsis_l = false;
    $ellipsis_r = false;

    if ($page > 1) {
      $html .= "<li><a href=\"?page=".($page-1)."$link_extra\">&lt;</a></li>";
    } else {
      //$html .= "<li>&lt;</li>";
    }
    for ($i=1; $i <= $total_pages; $i++) {
      if (($i >= $page-$page_margin) && ($i <= $page+$page_margin)) {
        if ($page == $i) {
          $html .=  "<li class=\"current\">$i</li>";
        } else {
          $html .=  "<li><a href=\"?page=$i$link_extra\">$i</a></li>";
        }
      } else {
        if ($i < $page && !$ellipsis_l) {
          $html .=  "<li><a href=\"?page=$i$link_extra\">&hellip;</a></li>";
          $ellipsis_l = true;
        }
        else if ($i > $page && !$ellipsis_r) {
          $html .=  "<li><a href=\"?page=$i$link_extra\">&hellip;</a></li>";
          $ellipsis_r = true;
        }
      }
    }
    if ($page < $total_pages) {
      $html .= "<li class=\"lishort\"><a href=\"?page=".($page+1)."$link_extra\">&gt;</a></li>";
    } else {
      //$html .= "<li>&gt;</li>";
    }
    $html .= "<li><a href=\"?page=$total_pages$link_extra\">&gt;&gt;</a></li>";
    $html .= "</ul>";

    return $html;
  }

?>