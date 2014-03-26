<?

namespace helpers\pagination;

class PaginationHelper {

    function make_link($args, $suffix = '') {
        $str = '';

        foreach ($args as $k => $v) {
            if (!in_array($k, ['page', 'per_page'])) {
                $str .= "&$k=$v";
            }
        }

        return $str . $suffix;
    }

    function pagination(
        $page,                      // current page
        $total,                     // total_pages
        $per_page,                  // how many items per page
        $link_before = null,        // append to link before pagination parameters
        $link_after = null,         // append to link after pagination parameters
        $page_links = 4,            // show this many page links left and right
        $expand = 0,                // increment per_page by these pages
        $page_var = 'page',         // page variable
        $per_page_var = 'per_page'  // per page variable
    ) {

        if (($total == 0) || (false)) {
            return "";
        }

        $total_pages = ceil($total/$per_page);
        $html = "<ul class=\"pagination\">";
        $html .= "<li><a href=\"$link_before?$page_var=1$link_after\">&lt;&lt;</a></li>";

        $ellipsis_l = false;
        $ellipsis_r = false;

        if ($page > 1) {
            $html .= "<li><a href=\"$link_before?$page_var=".($page-1)."$link_after\">&lt;</a></li>";
        } else {
            //$html .= "<li>&lt;</li>";
        }
        for ($i=1; $i <= $total_pages; $i++) {
            if (($i >= $page-$page_links) && ($i <= $page+$page_links)) {
                if ($page == $i) {
                    $html .= "<li class=\"current\">$i</li>";
                } else {
                    $html .= "<li><a href=\"$link_before?$page_var=$i$link_after\">$i</a></li>";
                }
                } else {
                if ($i < $page && !$ellipsis_l) {
                    $html .= "<li><a href=\"$link_before?$page_var=$i$link_after\">&hellip;</a></li>";
                    $ellipsis_l = true;
                }
                else if ($i > $page && !$ellipsis_r) {
                    $html .=    "<li><a href=\"$link_before?$page_var=$i$link_after\">&hellip;</a></li>";
                    $ellipsis_r = true;
                }
            }
        }
        if ($page < $total_pages) {
            $html .= "<li class=\"lishort\"><a href=\"$link_before?$page_var=".($page+1)."$link_after\">&gt;</a></li>";
        } else {
            //$html .= "<li>&gt;</li>";
        }
        $html .= "<li><a href=\"$link_before?$page_var=$total_pages$link_after\">&gt;&gt;</a></li>";

        if ($expand > 0) {
            $per_page_expand = $per_page + $expand;
            $html .= "<li><a href=\"$link_before?$page_var=$page&$per_page_var=$per_page_expand$link_after\">&gt;&gt;&gt;</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }

}

?>
