<?php
class user {

	private $firstName;
	private $lastName;
	private $password;
	private $email;
	private $rfid;

	public function __construct($firstName, $lastName, $password, 
				    $email, $rfid) {
		$this->firstName = firstName;
		$this->lastName = lastName;
		$this->password = password;
		$this->email = email;
		$this->rfid = rfid;
	}

	public function addRoom($id, $name, $description) {

		// create a new room with given parameters

	}

	public rooms[] function getRooms() {

		// return rooms which owner set to this.rfid

	}

	public preferences[] function getPreferenceSet() {

		// get preferences (is_user) associated with his RFID. 

	}
}
?>
