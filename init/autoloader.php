<?

function autoloader($name) {

    $blacklist = [
        'Translation_Entry', 'Translations', 'NOOP_Translations', 'POMO_Reader', 'POMO_FileReader', 'POMO_StringReader',
        'POMO_CachedFileReader', 'POMO_CachedIntFileReader', 'MO', 'All_in_One_SEO_Pack', 'All_in_One_SEO_Pack_Module',
        'Plugin_Register', 'ExToC', 'Responsive_Addons', 'WC_Dependencies', 'WooCommerce', 'WC_Install', 'WC_Query',
        'wp_atom_server', 'Featured_Content', 'WC_Order_Factory', 'WCPGSK_Main', 'WCPGSK_About',
        'All_in_One_SEO_Pack_Module_Manager', 'All_in_One_SEO_Pack_Feature_Manager', 'WC_Widget_Cart',
        'WC_Widget_Products', 'WC_Widget_Layered_Nav', 'WC_Widget_Layered_Nav_Filters', 'WC_Widget_Price_Filter',
        'WC_Widget_Product_Categories', 'WC_Widget_Product_Search', 'WC_Widget_Product_Tag_Cloud',
        'WC_Widget_Recent_Reviews', 'WC_Widget_Recently_Viewed', 'WC_Widget_Top_Rated_Products'
    ];

    $parts = explode('\\', $name);

    $error = false;

    if (count($parts) == 3) {

        if (in_array($parts[0], ['helpers', 'models', 'lib'])) {

            $require_str = $parts[0] . '/' . $parts[1] . '.php';

            require_once($require_str);

        } else {

            $error = true;

        }

    } else if (count($parts) == 1) {



        switch ($parts[0]) {

            case 'PHPMailer':
                require_once('vendors/PHPMailer/class.phpmailer.php');
                break;

            default:
                $error = true;
                break;
        }

    } else {

        $error = true;

    }

    if ($error and (!in_array($name, $blacklist))) {
        error_log("Autoloader couldn't handle '$name'");
        return;
    }


}

$result = spl_autoload_register('autoloader', true, true);

?>