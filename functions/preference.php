<?php
include ("mysql_support.php");
class preference {

	private $name;
	private $id;
	private $min_value;
	private $max_value;
	private $current_value;
	private $rfid;
	public  $set_id;

    
	public function __construct($name, $min_value, $max_value, $rfid, 
	                   $pref_id = -1, $set_id = -1) {
        
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
        $this->pullPreference ($pref_id, 0);
        if($set_id != -1)
        $this->pullPreference ($pref_id, 1, $set_id);
        
		}
	}
	
	// helps change all the values you like ... -1 if don't want to change
	public function fillValues ($name, $min_value, $max_value, $rfid, 
                                          $pref_id, $set_id, $current_value)
    {
      if ($name != -1) $this->name= $name;
      if ($min_value != -1) $this->min_value= $min_value;
      if ($max_value != -1) $this->max_value= $max_value;
      if ($current_value != -1) $this->current_value= $current_value;      
      if ($rfid != -1) $this->rfid= $rfid;
      if ($pref_id != -1) $this->id= $pref_id;
      if ($set_id != -1) $this->set_id= $set_id;
      
    }
	
	private function getFieldsList ($type)
	{
      // type 0 means preferences table
      // type 1 means modified_pref table_name
      
      if ($type == 0)
        return " pref_name, min_value, max_value, rfid, pref_id ";
      
      return " pref_id, owner_rfid, current_value, set_id ";
      
    }
    
    
    private function getValuesList ($type)
    {
      if ($type == 0)
        return   "\"". $this->name ."\", "
                ."\"". $this->min_value ."\", "
                ."\"". $this->max_value ."\", "
                ."\"". $this->rfid ."\", "
                ."\"". $this->id ."\" ";
     
     return      "\"". $this->id ."\", "
                ."\"". $this->rfid ."\", "
                ."\"". $this->current_value ."\", "
                ."\"". $this->set_id ."\" ";
  
    }
	
	/**
    *   Pull the information of a preference from the data base.
    *   @var $type 0 = from "preferences", 1 = "modified_pref"; 
    *   @author Mihail
    */
    public function pullPreference( $_pref_id, $type, $_set_id=0)
    {
      //echo $table_name. " ". $_pref_id. " \n";
      $this->id = $_pref_id;
      
      $table_name = $type == 0 ? "preferences":"modified_pref";
      //construct the right query
      
      $table = " ". $table_name ." ";
      
      $fields = $this->getFieldsList($type);
      
      $clause = " pref_id=\"$_pref_id\" ";
      
      if ($type == 1)
        $clause .= " AND set_id=\"$_set_id\" ";
      
      $query="SELECT $fields FROM $table WHERE $clause";
      
      //echo $query."\n" ;
      
      $conn = connectToDatabase();
      $answer = mysql_query ($query);
      
      $row = mysql_fetch_array($answer);
      //echo $row["pref_id"] . " " . $row["owner_rfid"]. " ". $row["set_id"];
      
      // fill the appropriate fields
      if ($type == 0)
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
    * Can be used without invoking it .e.g. echo OBJECT_OF_TYPE_PREFERENCE;
    * @author Mihail 
    */
    public function __toString()
    {
      return "Name: " . $this->name . "  ID: " . $this->id . " CurrentValue: " 
       . $this->current_value . " MinValue:" . $this->min_value
       . "  MaxValue:" . $this->max_value."  RFID: " . $this->rfid . "  SetID: " . $this->set_id;
    }
    
    /**
    *   Add this preference to database. Suppose there isn't one already.  
    *   
    */
    public function addToDatabase($type) 
    {
      
      $table = ($type==0 ? "preferences":"modified_pref");
      
      
      $query = "INSERT INTO $table ";
      if ($type == 0)
        $query .= "( pref_name, min_value, max_value, rfid ) ";
      else
        $query .= "(  pref_id, owner_rfid, current_value, set_id )";
      
      $conn = connectToDatabase ();
      
      if ($type == 0)
        $query .= sprintf ("VALUES ( '%s', '%s', '%s', '%s' )", 
                          mysql_real_escape_string ($this->name), 
                          $this->min_value,
                          $this->max_value,
                          $this->rfid );

      else
        $query .= sprintf ("VALUES ( '%s', '%s', '%s', '%s' )", 
                          $this->id, 
                          $this->rfid,
                          $this->current_value,
                          $this->set_id );
        
      //echo mysql_real_escape_string ($this->name);
      //echo $query;
      
      mysql_query ($query) or die("Noooo!");
      
      if ($type == 0)
        $pref_id = mysql_insert_id($conn);
      
      
      disconnectFromDatabase($conn);
	}
    
    /**
    *   User frendly get that expects to have some data in beforehand.
    *      
    *
    *  @var $type - 0 - gets a general preference based on $pref_id 
    *               1 - gets a modified preference based on $pref_id and set_id
    *  @author Mihail 
    */
	public function getFromDatabase($type) 
	{
      if ($type == 0)
        pullPreference( $this->pref_id, 0);
      else
        pullPreference( $this->pref_id, 1, $this->set_id);
	}
    
    // adds this preference to some new set
	public function addToSet($set_id) 
	{

	  $this->set_id = $set_id;
      $this->addToDatabase(1);
      
	}	
    
    // removes it from the set and from the database respectively 
	public function removeFromSet() 
	{
      // remove from database also !?!
      
      $table = " modified_pref ";
      $where = " set_id='" . $this->set_id . "' AND pref_id='" . $this->id . "' ";
      
      $conn = connectToDatabase ();
      
      $query = "DELETE FROM $table WHERE $where ";
      
     
      //echo $query . "\n";
      mysql_query ($query);
      
      disconnectFromDatabase ($conn);
	  $set_id = null;

	}
      
    // changes current value in database
	public function modifyCurrentValue($value) 
	{
      
      if ($value < $this->min_value || $value > $this->max_value)
        return 0;
      $this->current_value = $value;
      
      $where = " set_id='" . $this->set_id . "' AND pref_id='" . $this->id . "' "; 
      $query="UPDATE modified_pref SET current_value='$value' WHERE $where";
      $conn = connectToDatabase ();
      $res = mysql_query ($query) or die ("opa!");
      
      disconnectFromDatabase ($conn);
      if ($res) 
        return 1;
      else
        return 0;
        //sql code here
	}

}

  // Test ZONE!!!
  //$pref = new preference("sasda", 1, 2, 3, 3, 29);
  //echo $pref . "\n";
  //echo $pref -> modifyCurrentValue (7) . "\n";
  //$pref->removeFromSet();
  
  
  //$pref->addToSet (18);
  //echo $pref . "\n";
  
  //
  
  //$pref = new preference("Sasdaasd", 1, 2, 3);
  //$pref->addToDatabase(0);
?>
