<?php

/**
Method to connect to database and returns a reference to the connection to be
used to close the connection after use of the database! 
*/
function connectToDatabase ()
{
  $user="11_COMP10120_Y5";
  $password="lVgWsvqulkQS875r";
  $database="11_COMP10120_Y5";
  $server="ramen.cs.man.ac.uk";
  
  $conn=mysql_connect($server,$user,$password) 
                             or die("Unable to connect to database");
 
  @mysql_select_db($database) or die( "Unable to select database");
  
  return $conn;
}

/**
Simply closes the connection to the database 
@$conn - reference to the connection to be closed! 

*/
function disconnectFromDatabase ($conn)
{
  mysql_close ($conn);
}


?>

