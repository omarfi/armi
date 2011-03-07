<?php

include 'mysql_support.php';

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

	  $connection = connectToDatabase();
	  
	  $query = "INSERT INTO rooms 
                      VALUES ($id, $this->rfid, $name, $description, 0)";

	  mysql_query($query);

	  disconnectFromDatabase($connection);

	}

	public function getRooms() {

	  $connection = connectToDatabase();

	  $query = "SELECT * FROM rooms WHERE owner_rfid=$this->rfid";

	  $rooms = mysql_query($query);

	  while ($row = mysql_fetch_array($rooms)) {

	    // create instances of rooms

	  }

	  disconnectFromDatabase($connection);
	  
	  return $rooms;

	}

	public function addPreferenceSet() {

	  $connection = connectToDatabase();

	  $query = "INSERT INTO set_pref
                      VALUES (1, $this->rfid";

	  mysql_query($query);

	  disconnectFromDatabase($connection);


	}
	
	public function getPreferenceSet() {

	  $connection = connectToDatabase();

	  $query = "SELECT * FROM set_pref WHERE owner_id=$this->rfid";

	  $preferences = mysql_query($query);

	  while ($row = mysql_fetch_array($preferences)) {

	    // create preference set objects

	  }

	  disconnectFromDatabase($connection);

	  return $preferences;

	}

	public function __toString() {

	  return " $firstName, $lastName, $password, $email, $rfid ";

	}

}
?>
