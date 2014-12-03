<?

namespace helpers\inventory;


class InventoryHelper {

    function inventory($data) {
        $string = '';

        $playerinv = array();

        foreach($data as $slot) {

            if ($slot) {

                $itemdata = "".$slot->type;
                $itemdata .= " ".$slot->data;
                $itemdata .= " ".$slot->amount;
                $itemdata .= " ".$slot->durability;

                $enchantments = array();

                foreach($slot->enchantments as $name => $level) {
                    array_push($enchantments, "$name".":".$level);
                }

                $enchantments = implode(" ", $enchantments);
                array_push($playerinv, array(
                    "itemdata" => $itemdata,
                    "enchantments" => $enchantments
                ));

            } else {

                array_push($playerinv, array(
                    "itemdata" => "",
                    "enchantments" => ""
                ));

            }

        }

        $a = array_slice($playerinv, 0, 9);
        $b = array_slice($playerinv, 9);
        $playerinv = array_merge($b, $a);


        ob_start();

        echo '<table class="inventory">';
        echo '  <tbody>';

        for ($j = 0; $j < 4; $j++) {
            echo '<tr class="line<?= $j ?>">';
            for ($i = 0; $i < 9; $i++) {
                echo '<td>';
                $pi = $playerinv[$i + 9 * $j];
                echo '<span class="item" data-item="' . $pi['itemdata'] . '" data-enchantments="' . $pi['enchantments'] . '"></span>';
                echo '</td>';
            }
            echo '</tr>';
        }

        echo '</tbody>';
        echo '</table>';

        $result = ob_get_contents();

        ob_end_clean();

        return $result;

    }

}

?>