< ? php include 'preference_set.php';
class room {

	private $id;
	private $owner_rfid;
	private $name;
	private $description;
	private $set;

	public function __construct($id, $owner_rfid, $name, $description,
				    $set = null) {

		$this->id = $id;
		$this->owner_rfid = $owner_rfid;
		$this->name = $name;
		$this->description = $description;
		$this->set = $set;

	}
	public function addDefaultPreference($preference) {

		$preference->addToDatabase(0);

	}

	// had pref_id before
	public function removeDefaultPreference($preference) {

		$preference->removeFromSet();

	}

	public function modifyBasePreference($preference, $value) {

		$preference->modifyCurrentValue($value);

	}

	public function getPreferences() {

		$connection = connectToDatabase();

		$preferences = preference_set::getPreferenceSet2($this->set);

		return $preferences;

	}

	// not yet functional
	public function getPreferenceSets() {

		$connection = connectToDatabase();

		$query = "SELECT * FROM set_pref WHERE owner_id=$this->id";

		$preferences = mysql_query($query);

		disconnectFromDatabase($connection);

		return $preferences;

	}

	public function __toString() {

		return " $id, $owner_id, $name, $description, $set ";

	}

}

? >
