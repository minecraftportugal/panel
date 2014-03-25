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

    function navigation(
        $page,
        $total,
        $per_page,
        $link_before = null,
        $link_after = null,
        $page_margin = 4,
        $show_expand = false,
        $page_var = 'page',
        $per_page_var = 'per_page'
    ) {

        if ($total == 0)
            return "";

        $total_pages = ceil($total/$per_page);
        $html = "<ul class=\"navigation\">";
        $html .= "<li><a href=\"$link_before?$page_var=1$link_after\">&lt;&lt;</a></li>";

        $ellipsis_l = false;
        $ellipsis_r = false;

        if ($page > 1) {
            $html .= "<li><a href=\"$link_before?$page_var=".($page-1)."$link_after\">&lt;</a></li>";
        } else {
            //$html .= "<li>&lt;</li>";
        }
        for ($i=1; $i <= $total_pages; $i++) {
            if (($i >= $page-$page_margin) && ($i <= $page+$page_margin)) {
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

        if ($show_expand) {
            $per_page_expand = $per_page + 100;
            $html .= "<li><a href=\"$link_before?$page_var=$page&$per_page_var=$per_page_expand$link_after\">&gt;&gt;&gt;</a></li>";
        }

        $html .= "</ul>";

        return $html;
    }

}

?>
