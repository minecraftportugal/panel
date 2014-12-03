<?

function autoloader($name) {

    $parts = explode('\\', $name);

    if (count($parts) == 3) {

        if (in_array($parts[0], ['helpers', 'models', 'lib'])) {

            $require_str = $parts[0] . '/' . $parts[1] . '.php';

            require_once($require_str);

        } else {

            error_log("Autoloader couldn't handle '$name'");

        }

    } else if (count($parts) == 1) {

        switch ($parts[0]) {

            case 'PHPMailer':
                require_once('vendors/PHPMailer/class.phpmailer.php');
                break;

            default:
                error_log("Autoloader couldn't handle '$name'");
                break;
        }

    } else {

        error_log("Autoloader couldn't handle '$name'");

    }


}

$result = spl_autoload_register('autoloader', true, true);

?>