<?php
//include ("mysql_support.php"); // hmm mysql_support.php is added from the preference.php ...
include ("preference.php");
class preference_set 
{

	private $is_user;
	private $rfid;
	private $room_id;
	private $set_id;

	public function __construct($rfid, $room_id, $is_user) 
	{

		// a bit of a hack
		$this->is_user = $is_user;
		$id = $is_user ? $rfid : $room_id;
		$this->rfid = $id;
		$this->room_id = $id;

	}

    public function addToDatabase ()
    {
      $conn = connectToDatabase ();
      
      $id = $this->is_user ? $this->rfid : $this->room_id;
      
      $query = "INSERT INTO set_pref ( is_user, owner_id ) " . 
                " VALUES ( '" . $this->is_user ."', '$id' ) ";
      
      mysql_query ($query);
      
      $set_id = mysql_insert_id($conn);
      
      diconnectFromDatabase ($conn);
      
    }
    
    
    public function getPreferenceSet ()
    {
      return $this->getPreferenceSet2 ($this->set_id);
    }
    
	public static function getPreferenceSet2($someSetID) 
	{
      
      $prefs = array ();
      
      $conn = connectToDatabase () or die ("getPreferenceSet failed!!");
      
      $query = "SELECT pref_id, set_id FROM modified_pref WHERE set_id='$someSetID'";
        
      $raw = mysql_query ($query);
      disconnectFromDatabase ($conn);
  
      while ($row = mysql_fetch_array($raw))
      {
        $temp = new Preference (-1, -1, -1, -1, $row['pref_id'], $row['set_id']);
        $prefs[] = $temp;
      }
      
      
      // return preferences mapped to set_id
      return $prefs;
		
	}	

	public function addPreference ( $preference ) 
	{
      $preference.addToSet ($this->set_id);
      // add given preference to this.set_id.

	}
	

}

// test ZONE!!! 
echo "sdasdasd\n";

$q = preference_set::getPreferenceSet2 (9);



//echo "size -> " . sizeof ($q);
//echo "\n";

foreach ($q as $pref)
{
 echo $pref . "\n";
}

?>
