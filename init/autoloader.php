<?

function autoloader($name) {

    $errorWhitelist = [
        'Translation_Entry', 'Translations', 'NOOP_Translations', 'POMO_Reader', 'POMO_FileReader', 'POMO_StringReader',
        'POMO_CachedFileReader', 'POMO_CachedIntFileReader', 'MO', 'All_in_One_SEO_Pack', 'All_in_One_SEO_Pack_Module',
        'Plugin_Register', 'ExToC', 'Responsive_Addons', 'WC_Dependencies', 'WooCommerce', 'WC_Install', 'WC_Query',
        'wp_atom_server', 'Featured_Content', 'WC_Order_Factory', 'WCPGSK_Main', 'WCPGSK_About',
        'All_in_One_SEO_Pack_Module_Manager', 'All_in_One_SEO_Pack_Feature_Manager', 'WC_Widget_Cart',
        'WC_Widget_Products', 'WC_Widget_Layered_Nav', 'WC_Widget_Layered_Nav_Filters', 'WC_Widget_Price_Filter',
        'WC_Widget_Product_Categories', 'WC_Widget_Product_Search', 'WC_Widget_Product_Tag_Cloud',
        'WC_Widget_Recent_Reviews', 'WC_Widget_Recently_Viewed', 'WC_Widget_Top_Rated_Products', 'GADASH_Config',
        'GADASH_Tools', 'Sunrise4', 'Sunrise4_Views', 'GADASH_Tracking', 'GADASH_Frontend_Ajax', 'GADASH_Backend_Ajax',
        'BWS_add_admin_tooltip', 'GADWP_Manager', 'GADWP_Tools', 'GADWP_Config', 'GADWP_GAPI_Controller', 'toc',
        'toc_widget', 'Wpacc', 'BWS_admin_tooltip', 'GADWP_Tracking', 'GADWP_Manager', 'GADWP_Tools', 'GADWP_Config',
        'GADWP_GAPI_Controller', 'toc', 'toc_widget', 'Wpacc', 'BWS_admin_tooltip', 'GADWP_Tracking'
    ];

    $parts = explode('\\', $name);

    $error = false;

    $parts_n = count($parts);

    if ($parts_n >= 3) {

        $require_str = '';
        for ($i = 0; $i < $parts_n - 1; $i++) {
            $require_str .= $parts[$i];
            if ($i <  $parts_n - 2) {
                $require_str .= '/';
            }
        }
        $require_str .= '.php';
        require_once($require_str);

    } else if ($parts_n == 1) {



        switch ($parts[0]) {

            case 'PHPMailer':
                require_once('vendors/PHPMailer/class.smtp.php');
                require_once('vendors/PHPMailer/class.phpmailer.php');
                break;

            default:
                $error = true;
                break;
        }

    } else {

        $error = true;

    }

    if ($error and (!in_array($name, $errorWhitelist))) {
        error_log("Autoloader couldn't handle '$name'");
        return;
    }


}

$result = spl_autoload_register('autoloader', true, true);

?>
