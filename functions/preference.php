<?php
include ("mysql_support.php");
class preference {

	private $name;
	private $id;
	private $min_value;
	private $max_value;
	private $current_value;
	private $rfid;
	private $set_id;

    
	public function __construct($name, $min_value, $max_value, $rfid, 
	                   $set_id = -1, $pref_id = -1) {

		if ($pref_id == -1) {

			$this->name = $name;
			$this->rfid = $rfid;
			$this->min_value = $min_value;
			$this->max_value = $max_value;
            $this->set_id = $set_id;
            $this->id = -1;
            $this->set_id = $set_id;
			
		}
		else {
        // if pref_id is provoded pull information from database
        // and ignore first 4 paramethers.
        $this->pullPreference ($pref_id, "preferences");
        $this->pullPreference ($pref_id, "modified_pref", $set_id);
        
		}
	}
	/**
    *   Pull the information of a preference from the data base.
    *   @var $table_name The name of the table to get the data from. ("preferences" or "modified_pref"); 
    *   @author Mihail
    */

    public function pullPreference( $_pref_id, $table_name, $_set_id=0)
    {
      //echo $table_name. " ". $_pref_id. " \n";
      $this->id = $_pref_id;
      
      //construct the right query
      
      $table = " ". $table_name ." ";
      if ($table_name == "preferences")
        $fields = " pref_name, min_value, max_value, rfid, pref_id ";
      else
        $fields = " pref_id, owner_rfid, current_value, set_id ";
      
        $clause = " pref_id=\"$_pref_id\" ";
      
      if ($table_name != "preferences")
        $clause .= " AND set_id=\"$_set_id\" ";
      
      $query="SELECT $fields FROM $table WHERE $clause";
      
      //echo $query."\n" ;
      
      $conn = connectToDatabase();
      $answer = mysql_query ($query);
      
      $row = mysql_fetch_array($answer);
      //echo $row["pref_id"] . " " . $row["owner_rfid"]. " ". $row["set_id"];
      
      // fill the appropriate fields
      if ($table_name == "preferences")
      {
        $this->name = $row["pref_name"];
        $this->id = $row["pref_id"];
        $this->min_value=$row["min_value"];
        $this->max_value=$row["max_value"];
        $this->rfid = $row["rfid"];
        
        //echo "Name ";
        //echo $this->name;
      }
      else
      {
        $this->id = $row["pref_id"];
        $this->current_value = $row["current_value"];
        $this->rfid = $row["owner_rfid"];
        $this->set_id = $row["set_id"];

      }
      
            disconnectFromDatabase ($conn);      
      
    }
    
    /**
    * Outputs the data in the preference object to a string.
    * Canbe used without invoking it .e.g. echo OBJECT_OF_TYPE_PREFERENCE;
    * @author Mihail 
    */
    public function __toString()
    {
      return "Name: " . $this->name . "  ID: " . $this->id . " s CurrentValue: " 
       . $this->current_value . " MinValue:" . $this->min_value
       . "  MaxValue:" . $this->max_value."  RFID: " . $this->rfid . "  SetID: " . $this->set_id;
    }
    public function addToDatabase() {

		// sql code here

	}
    
    /**
    *   User frendly get that expects to have some date in beforehand.
    *      
    *
    *  @var $type - 0 - gets a general preference based on $pref_id 
    *               1 - gets a modified preference based on $pref_id and set_id
    *  @author Mihail 
    */
	public function getFromDatabase($type) {
      if ($type == 0)
        pullPreference( $this->pref_id, "preferences");
      else
        pullPreference( $this->pref_id, "modified_pref", $this->set_id);
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
        //sql code here
	}

}

  // Test ZONE!!!
  //$pref = new preference("sasda", 1, 2, 3,8, 3);
  //echo $pref . "\n";
  //
?>
