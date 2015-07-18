<?

#
# Minecraftia! Premium User Checker
# Substituir a funcionalidade desactivada no xAuth (evitar performance hog)
# v1.0
#

define('SAVEFILE', dirname(__FILE__) . '/.minecraftPremiumCheckLastId');

require 'init/bootstrap.php';

use minecraftia\db\Bitch;

function getUsers($limit) {
    if (!is_null($limit)) {
        $sql = "SELECT * FROM accounts a WHERE id >= :limit";
        $users = Bitch::source('default')->all($sql, compact('limit')); 
    } else {
        $sql = "SELECT * FROM accounts a";
        $users = Bitch::source('default')->all($sql); 
    }

    if (!is_null($users)) {
        return $users;
    } else {
        return [];
    }
}

function setPremium($id, $result) {
    $value = null;

    if ($result == 'true') {
        $value = 1;
    } else if($result == 'false') {
        $value = 0;
    }

    if (!is_null($value)) {
        
        $sql = "UPDATE accounts SET premium = :value WHERE id = :id";
        $result = Bitch::source('default')->query($sql, compact('value', 'id'));
        
        print "Updated.\n";
    } else{
        print "Unrecognized response.\n";
    }
}

function premiumCheck($playername) {
    $url = "https://minecraft.net/haspaid.jsp?user=$playername";
    $status = file_get_contents($url);

    return $status;
}

function saveLastId($id) {
	$result = file_put_contents(SAVEFILE, $id);
}

function readLastId() {
	$id = file_get_contents(SAVEFILE);
	return $id;
}

#
# Main
#
$lastId = null;

# Try using a lastId givin to the program as an argument.
# If no argument given, try to read it from SAVEFILE
# If no SAVEFILE found, use 1 as the default
if (isset($argv[1])) {
	$lastId = intval($argv[1]);
} else {
	$savedId = readLastId();
	if ($savedId === false) {
		$lastId = 1;
	} else {
		$lastId = intval($savedId);
	}
}

echo "Starting with ID $lastId.\n";
$users = getUsers($lastId);

foreach ($users as $user) {
    $id = $user['id'];
    $playername = $user['playername'];
    $ispremium = $user['premium'];

    $result = premiumCheck($playername);

    echo "$playername : $result ($ispremium)...\t\t";

    setPremium($id, $result);
    saveLastId($id);
}

?>
