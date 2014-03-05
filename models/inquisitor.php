<?

namespace inquisitor:

require_once("config.php");

use minecraftia\db\Bitch;

class Inquisitor {

	var $name;
	var $_row;

	function __construct($name) {
		$this->name = $name;
		$this->load();
	}

	function load() {
		$q = "SELECT * FROM players WHERE name = :name;";
		$this->_row = Bitch::source('inquisitor')->first($q, compact($this->name));

		if ($this->row == null) {
			throw new Exception("$name not found");
		}
	}
}

?>