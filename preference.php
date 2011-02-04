<?php
class preference {

	private $name;
	private $id;
	private $min_value;
	private $max_value;
	private $current_value;
	private $rfid;
	private $set_id;

	public function __construct($name, $min_value, $max_value, $rfid) {

		$this->name = $name;
		$this->rfid = $rfid;
		$this->min_value = $min_value;
		$this->max_value = $max_value;

		// sql code

	}

	public function addToSet($set_id) {

		$this->set_id = $set_id;

		// sql code here

	}	

	public function removeFromSet() {

		// sql code here
		$set_id = null;

	}

	public function modifyCurrentValue($value) {

		$this->current_value = $value;

	}

}
?>
