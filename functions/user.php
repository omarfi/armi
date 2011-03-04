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

	  // refactor to create instance of Room
      
	  $connection = connectToDatabase();
	  // room_id owner_rfid room_name room_description room_set

	  // add a room with the given properties. 0 for room_set states
	  // that the room is given a dummy preference set, which the user
	  // can then modify
	  mysql_query("INSERT INTO rooms 
                      VALUES ($id, $this->rfid, $name, $description, 0)");

	  disconnectFromDatabase(connection);

	}

	public function getRooms() {

	  $connection = connectToDatabase();

	  $rooms = mysql_query(
			       // might need ' ' around $this->rfid
		    "SELECT * FROM rooms WHERE owner_rfid=$this->rfid");

	  disconnectFromDatabase(connection);
	  
	  return rooms;

	}

	public function addPreferenceSet() {

	   $connection = connectToDatabase();

	  mysql_query("INSERT INTO set_pref
                      VALUES (1, $this->rfid");

	  disconnectFromDatabase(connection);


	}
	
	// previously called getPreferenceSet()
	public function getPreferenceSet() {

	  $connection = connectToDatabase();

	  $preferences = mysql_query(
			  "SELECT * FROM set_pref WHERE owner_id=$this->rfid");
		
	  disconnectFromDatabase(connection);

	  return preferences;

	}

}
?>
