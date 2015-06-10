<?

namespace helpers\form;

use helpers\arguments\ArgumentsHelper;

class FormHelper {

    static function select($name, $data, $default = false, $classes = '') {

        $string = '<select name="'.$name.'" class="'.$classes.'">';
        foreach ($data as $option) {
            $selected = (!!$default && $option['value'] == $default) ? 'selected' : '';
            $string .= '<option '.$selected.' value="'.$option['value'].'">'.$option['label'].'</option>';
        }
        $string .= '</select>';

        return $string;
    }

}

?>