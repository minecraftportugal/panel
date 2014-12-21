<?

namespace helpers\pagination;

use helpers\arguments\ArgumentsHelper;

class PaginationHelper {

    private $defaults = [
        "page" => null,
        "total" => null,
        "per_page" => null,
        "link_before" => null,
        "link_after" => null,
        "page_links" => 4,
        "expand" => 0,
        "page_var" => "page",
        "per_page_var" => "per_page",
        "page_guide" => true,
        "order_by" => "id asc"
    ];

    function __construct($params) {
      $p = ArgumentsHelper::process($params, $this->defaults);

      $this->page = $p["page"];
      $this->total = $p["total"];
      $this->per_page = $p["per_page"];
      $this->link_before = $p["link_before"];
      $this->link_after = $p["link_after"];
      $this->page_links = $p["page_links"];
      $this->expand = $p["expand"];
      $this->page_var = $p["page_var"];
      $this->per_page_var = $p["per_page_var"];
      $this->page_guide = $p["page_guide"];
    }

    function render() {

        if (($this->total == 0)) {
            return "";
        }

        $total_pages = ceil($this->total/$this->per_page);
        $html = "<ul class=\"pagination\">";
        $html .= "<li><a href=\"$this->link_before?$this->page_var=1$this->link_after\"><i class=\"fa fa-angle-double-left\"></i></a></li>";

        $ellipsis_l = true; //false;
        $ellipsis_r = true; //  false;

        if ($this->page > 1) {
            $html .= "<li><a href=\"$this->link_before?$this->page_var=".($this->page-1)."$this->link_after\"><i class=\"fa fa-angle-left\"></i></a></li>";
        } else {
            $html .= "<li class=\"inactive\"><i class=\"fa fa-angle-left\"></i></li>";
        }
        for ($i=1; $i <= $total_pages; $i++) {

            $delta_left = $total_pages - $this->page <= $this->page_links ? ($this->page_links - ($total_pages - $this->page)) * (-1) : 0;
            $delta_right = $this->page <= $this->page_links ? $this->page_links - ($this->page-1) : 0;

            if (($i >= $this->page - $this->page_links + $delta_left) && ($i <= $this->page + $this->page_links + $delta_right)) {
                if ($this->page == $i) {
                    $html .= "<li class=\"current inactive\">$i/$total_pages</li>";
                } else {
                    $html .= "<li><a href=\"$this->link_before?$this->page_var=$i$this->link_after\">$i</a></li>";
                }
            } else { 
                if ($i < $this->page && !$ellipsis_l) {
                    $html .= "<li><a href=\"$this->link_before?$this->page_var=$i$this->link_after\">&hellip;</a></li>";
                    $ellipsis_l = true;
                }
                else if ($i > $this->page && !$ellipsis_r) {
                    $html .=    "<li><a href=\"$this->link_before?$this->page_var=$i$this->link_after\">&hellip;</a></li>";
                    $ellipsis_r = true;
                }
            }
        }
        if ($this->page < $total_pages) {
            $html .= "<li class=\"lishort\"><a href=\"$this->link_before?$this->page_var=".($this->page+1)."$this->link_after\"><i class=\"fa fa-angle-right\"></i></a></li>";
        } else {
            $html .= "<li class=\"inactive\"><i class=\"fa fa-angle-right\"></i></li>";
        }
        $html .= "<li><a href=\"$this->link_before?$this->page_var=$total_pages$this->link_after\"><i class=\"fa fa-angle-double-right\"></i></a></li>";

        if ($this->expand > 0) {
            $per_page_expand = $this->per_page + $this->expand;
            $html .= "<li><a href=\"$this->link_before?$this->page_var=$this->page&$this->per_page_var=$per_page_expand&$this->link_after\"><i class=\"fa fa-angle-double-right\"></i><i class=\"fa fa-angle-right\"></i></a></li>";
        }

        $html .= "</ul>";

        return $html;
    }

}

?>