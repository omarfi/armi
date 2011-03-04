<?php
class room {

	private $id;
	private $owner_rfid;
	private $name;
	private $description;
	private $set;

	public function __construct($id, $owner_rfid, $name, $description,
				    $preference_set = null) {
		
		$this->id = $id;
		$this->owner_rfid = $owner_rfid;
		$this->name = $name;
		$this->description = $description;
		$this->preference_set = $preference_set;
		// create dummy set for room in modified_pref
	}

	public function addDefaultPreference($preference) {

	  

	}

	public function removeDefaultPreference($pref_id) {

	  

	}

	public function modifyBasePreference($pref_id, $value) {

		

	}

	public function getPreferences() {

		

	}

	public function getPreferenceSets() {

  	  $connection = connectToDatabase();

	  $preferences = mysql_query(
			  "SELECT * FROM set_pref WHERE owner_id=$this->id");
		
	  disconnectFromDatabase(connection);

	  return preferences;

	}

}
?>
