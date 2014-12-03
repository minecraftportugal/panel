<?

namespace lib\render;

use lib\xauth\xAuth;
use models\log\LogModel;
use minecraftia\db\Bitch;

class Render {


    public static function template($name) {

        require_once("templates/$name.php");

    }

}