<?php
class room {

	private $id;
	private $owner_rfid;
	private $name;
	private $description;
	private $preference_set;

	public function __construct($id, $owner_rfid, $name, $description,
				    $preference_set = null) {
		
		$this->id = $id;
		$this->owner_rfid = $owner_rfid;
		$this->name = $name;
		$this->description = $description;
		$this->preference_set = $preference_set;
		// create dummy set for room in modified_pref
	}

	// add preference prototype to dummy set
	public function addDefaultPreference($preference) {

	}

	public function removeDefaultPreference($pref_id) {

	}

	public function modifyBasePreference($pref_id, $value) {

		// 

	}

	public preferences[] function getPreferences() {

		// sql code to return preferences matched by preference_set

	}

	public preferences[] function getDummyPreferences()

}
?>
