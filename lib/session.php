<?

namespace lib\session;

use lib\template\Template;
use lib\environment\Environment;
use lib\xauth\xAuth;
use models\logs\Logs;
use minecraftia\db\Bitch;

class Session {


    /*
     * validateLogin: validates user logins
     */
    public static function validateLogin($username, $password) {
        $q = "SELECT id, playername AS username, password, admin, donor, contributor
          FROM accounts
          WHERE playername = :username
          AND active=1
        ";

        if ($result = Bitch::source('default')->first($q, compact('username'))) {
            if (xAuth::checkPassword($password, $result['password'])) {
                Session::initSession($result);
                return true;
            }
        }

        return false;
    }

    /*
     * initSession: initializes a users' session
     */
    private static function initSession($user) {
        Session::set('id', $user['id']);
        Session::set('username', $user['username']);
        Session::set('admin', $user['admin']);
        Session::set('donor', $user['donor']);
        Session::set('contributor', $user['contributor']);
        Session::set('xsrf_token', substr(md5(rand()), 0, 32));
        
        xAuth::refreshxAuthSession($user['id']);
    }

    /*
     * isLoggedIn: returns wether a user is logged in or not, optionally as an admin
     */
    public static function isLoggedIn($admin = false) {
        $val = false;

        if (!$admin) {
            if (!is_null(Session::get('username'))) {
                $val = true;
            }
        } else {
            if (!is_null(Session::get('username')) && !is_null(Session::get('admin')) && Session::get('admin') == 1) {
                $val = true;
            }
        }
        return $val;
    }

    /*
     * isAdmin: returns wether a user is an admin or not
     */
    public static function isAdmin() {

        return Session::get('admin') == 1;

    }

    public static function get($variable) {

        return array_key_exists($variable, $_SESSION) ? $_SESSION[$variable] : null;

    }

    public static function set($variable, $value) {

        $_SESSION[$variable] = $value;

    }

    /*
     * getXSRFToken: wraps the sessions' XRSF token
     */
    public static function getXSRFToken() {
        return !is_null(Session::get('xsrf_token')) ? Session::get('xsrf_token') : NULL;
    }

    /*
     * getSubmittedXSRFToken: wraps the POST requests' XRSF token
     */
    public static function getSubmittedXSRFToken() {
        return isset($_POST['xsrf_token']) ? $_POST['xsrf_token'] : NULL;
    }

    /*
     * isValidXSRFToken: validates a user's XSRF token
     */
    public static function isValidXSRFToken($token) {
        return Session::getXSRFToken() == $token;
    }

    /*
     * validateSession: validates a users' session, optionally as an admin. redirects to login if invalid
     */
    public static function validateSession($admin = false) {

            if (!Session::isLoggedIn($admin)) {

                    if ($admin) {
                            Logs::create('failed_admin_action', Session::get('id'), Environment::get('REMOTE_ADDR'), 'Logged at ' . Environment::get('REQUEST_URI'));
                    } else {
                            Logs::create('failed_session_validation', Session::get('id'), Environment::get('REMOTE_ADDR'), 'Logged at ' . Environment::get('REQUEST_URI'));
                    }

                    if (!is_null(Environment::get('HTTP_X_REQUESTED_WITH')) && !strcasecmp(Environment::get('HTTP_X_REQUESTED_WITH'), 'XMLHttpRequest')) {
                            http_response_code(401);
                    } else {
                            header('Location: /login');
                    }

                    exit();

            }
    }

    /*
     * validateXSRFToken: validates a user's XSRF token
     */
    public static function validateXSRFToken() {
        $token = Session::getSubmittedXSRFToken();

        if (!Session::isValidXSRFToken($token)) {
            Logs::create('failed_xsrf_validation', Session::get('id'), Environment::get('REMOTE_ADDR'), 'Logged at ' . Environment::get('REQUEST_URI') . ' with xsrf token ' . $token);

            $template = Template::init('v_403_forbidden');
            $template->render(403);

            exit();
        }
    }

    /*
     * refererProtect: protects a user's click by forbidding invalid HTTP referers
     */
    public static function refererProtect() {

        $referer = Environment::get("HTTP_REFERER");

        $match = preg_match(VALID_REFERER, $referer);

        if ($match === 1) {
            return true;
        } else {

            $template = Template::init('v_403_forbidden');
            $template->render(403);

            exit();
        }

    }

}

?>