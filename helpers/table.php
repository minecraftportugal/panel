<?

namespace helpers\table;

use helpers\arguments\ArgumentsHelper;

class TableHelper {
  
    private $defaults = [
        "width" => null,
        "alignment" => null,
        "label" => null,
        "label_title" => null,
        "order_by" => null
    ];

    private $columns = [];

    private $order_by = null;

    private $asc_desc = null;

    function __construct($action, $params) {
        $this->action = $action;
        $this->params = $params;

        $this->order_by = $params["order_by"];
        $this->asc_desc = $params["asc_desc"];
    }

    public function add_column($params) {
        $p = ArgumentsHelper::process($params, $this->defaults);
        array_push($this->columns, $p);
    }

    public function href($order_by) {
        $params = $this->params;

        $params["order_by"] = $order_by;

        if ($this->asc_desc == "asc") {
            $params["asc_desc"] = "desc";
        } else if ($this->asc_desc == "desc") {
            $params["asc_desc"] = "asc";
        }

        return $this->action . ArgumentsHelper::serialize($params, true);
    }

    public function render_header() {

        $html = "<thead class=\"font-normal\">
          <tr>\n";

        foreach ($this->columns as $column) {

            $html .= "<td";

            $html .= " style=\"";
            
            if (!is_null($column["width"])) {
                $html .= "width: ".$column["width"].";";
            }
            
            if (!is_null($column["alignment"])) {
                $html .= "text-align: ".$column["alignment"].";";
            }
            
            $html .= "\"";

            if (!is_null($column["order_by"])) {
                $html .= " class=\"column-sortable\"";
            }

            $html .= ">";

            if (!is_null($column["label"])) {
                $html .= "<div";
                
                if (!is_null($column["label_title"])) {
                    $html .= " title=\"".$column["label_title"]."\"";
                }

                $html .= ">";
            }

            if (!is_null($column["order_by"])) {

                $html .= "<a href=\"".$this->href($column["order_by"])."\">";
            }

            if (!is_null($column["label"])) {
                if (!is_null($column["order_by"])) {
                    if ($column["order_by"] == $this->order_by) {
                        if ($this->asc_desc == "asc") {
                            $html .= "<i class=\"fa fa-long-arrow-up\"></i> ";
                        }  else if ($this->asc_desc == "desc") {
                            $html .= "<i class=\"fa fa-long-arrow-down\"></i> ";
                        }  
                    }
                }
                $html .= $column["label"];
            }

            if (!is_null($column["order_by"])) {
                $html .= "</a>";
            }

            if (!is_null($column["label"])) {
              $html .= "</div>";
            }

            $html .= "</td>\n";
        }

        $html .= "</tr>
        </thead>";

        return $html;
    }
}

?>