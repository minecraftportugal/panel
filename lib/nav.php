<?

  function navigation($page, $total, $per_page, $page_margin = 4) {
    $total_pages = ceil($total/$per_page);
    $html = "<ul class=\"navigation\">";
    $html .= "<li><a href=\"?page=1\">&lt;&lt;</a></li>";
    
    $ellipsis_l = false;
    $ellipsis_r = false;

    if ($page > 1) {
      $html .= "<li><a href=\"?page=".($page-1)."\">&lt;</a></li>";
    } else {
      //$html .= "<li>&lt;</li>";
    }
    for ($i=1; $i <= $total_pages; $i++) {
      if (($i >= $page-$page_margin) && ($i <= $page+$page_margin)) {
        if ($page == $i) {
          $html .=  "<li class=\"current\">$i</li>";
        } else {
          $html .=  "<li><a href=\"?page=$i\">$i</a></li>";
        }
      } else {
        if ($i < $page && !$ellipsis_l) {
          $html .=  "<li><a href=\"?page=$i\">&hellip;</a></li>";
          $ellipsis_l = true;
        }
        else if ($i > $page && !$ellipsis_r) {
          $html .=  "<li><a href=\"?page=$i\">&hellip;</a></li>";
          $ellipsis_r = true;
        }
      }
    }
    if ($page < $total_pages) {
      $html .= "<li class=\"lishort\"><a href=\"?page=".($page+1)."\">&gt;</a></li>";
    } else {
      //$html .= "<li>&gt;</li>";
    }
    $html .= "<li><a href=\"?page=$total_pages\">&gt;&gt;</a></li>";
    $html .= "</ul>";

    return $html;
  }

?>