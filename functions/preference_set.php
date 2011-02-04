<?php
public class preference_set {

	private $is_user;
	private $rfid;
	private $room_id;
	private $set_id;

	public function __construct($rfid = null, $room_id = null, $is_user) {

		// a bit of a hack
		$this->is_user = $is_user;
		$id = $is_user ? $rfid : $room_id;
		$this->rfid = $id;
		$this->room_id = $id;

	}

	public preferences[] getPreferenceSet() {

		// return preferences mapped to set_id

	}	

	public addPreference($preference) {

		// add given preference to this.set_id.

	}

	

}
?>
