< ? php
//include ("mysql_support.php"); // hmm mysql_support.php is added from the preference.php ...
include("preference.php");
class preference_set {

	private $is_user;
	private $rfid;
	private $room_id;
	private $set_id;

	public function __construct($rfid, $room_id, $is_user) {

		// a bit of a hack
		$this->is_user = $is_user;
		$id = $is_user ? $rfid : $room_id;
		$this->rfid = $id;
		$this->room_id = $id;

	} public function __toString() {
		return " isUser: ".$this->is_user." RFID: ".$this->rfid.
		    " ROOM: ".$this->room_id." SET: ".$this->set_id;
	}

	public function modifySetID($new_id) {
		$this->set_id = $new_id;
	}

	// removes the set and all preferences in it
	public function removeSet() {
		$prefs = $this->getPreferenceSet();

		foreach($prefs as & $p)
		    $p->removeFromSet();

		$conn = connectToDatabase();

		$query =
		    " DELETE FROM set_pref WHERE set_id='".$this->set_id."' ";
		mysql_query($query) or die("could not remove set!");
		disconnectFromDatabase($conn);

	}

	// gets info about the set based on set_id
	public function pullFromDatabase() {

		$query =
		    " SELECT * FROM set_pref WHERE set_id='".$this->set_id."' ";

		$conn = connectToDatabase();

		$res = mysql_query($query) or die("Pull preference set failed");

		$row = mysql_fetch_array($res);

		$this->set_id = $row['set_id'];
		$this->is_user = $row['is_user'];
		if ($this->is_user == 0)
			$this->room_id = $row['owner_id'];
		else
			$this->rfid = $row['owner_id'];

		if ($this->is_user == 0) {
			$query =
			    " SELECT * FROM rooms WHERE room_id='".$this->
			    is_user."' ";
			$row = mysql_fetch_array($res);
			$this->rfid = $row['owner_rfid'];
		}

		disconnectFromDatabase($conn);

	}

	// adds a new set and generates a set_id
	public function addToDatabase() {

		$id = $this->is_user ? $this->rfid : $this->room_id;

		$query =
		    "INSERT INTO set_pref ( is_user, owner_id ) "." VALUES ( '".
		    $this->is_user."', '$id' ) ";

		$conn = connectToDatabase();
		mysql_query($query);

		$this->set_id = mysql_insert_id($conn);

		disconnectFromDatabase($conn);
	}

	// gets an array with the modified preferences int THIS set 
	public function getPreferenceSet() {
		return $this->getPreferenceSet2($this->set_id);
	}

	// gets an array with the modified pref. from set wit id $someSetID
	public static function getPreferenceSet2($someSetID) {

		$prefs = array();

		$conn = connectToDatabase()or die("getPreferenceSet failed!!");

		$query =
		    "SELECT pref_id, set_id FROM modified_pref WHERE set_id='$someSetID'";

		$raw = mysql_query($query);
		disconnectFromDatabase($conn);

		while ($row = mysql_fetch_array($raw)) {
			$temp =
			    new Preference(-1, -1, -1, -1, $row['pref_id'],
					   $row['set_id']);
			$prefs[] = $temp;
		}

		// return preferences mapped to set_id
		return $prefs;

	}

	// adds a preference to the set
	public function addPreference($preference) {
		$preference.addToSet($this->set_id);
		// add given preference to this.set_id.

	}

}

// -------------------------------test ZONE!!! --------------------- 
//echo "sdasdasd\n";

//$q = preference_set::getPreferenceSet2 (9);

//echo "size -> " . sizeof ($q);
//echo "\n";
/*
foreach ($q as $pref)
{
 echo $pref . "\n";
}
*/

/*
$set1 = new preference_set (66, 66, 1);
echo $set1 . "\n";

$set1-> addToDatabase();
echo $set1 . "\n";
$set2 = new preference_set(-1, -1, -1);
$set2->modifySetID (9);
$set2-> pullFromDatabase ();
echo $set2 . "\n";

$q = $set2->getPreferenceSet ();
foreach ($q as $pref)
{
 echo $pref . "\n";
}
*/
/*
$set2 = new preference_set(-1, -1, -1);
$set2->modifySetID (9);
$set2-> pullFromDatabase ();
$q = $set2->getPreferenceSet ();
foreach ($q as $pref)
{
 echo $pref . "\n";
}

$set2->removeSet ();
echo "------------------After remove--------------\n";
$q = $set2->getPreferenceSet ();
foreach ($q as $pref)
{
 echo $pref . "\n";
}
*/

? >
