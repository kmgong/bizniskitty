<?php

//connect to database
//$mysql_hostname = "localhost:3306";
$mysql_hostname = "localhost:8888";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "myapp";

$connect = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
or die("Couldn't connect");

mysql_select_db($mysql_database, $connect) or die("Uh oooooh, couldn't find the database");
//Sets session variables
session_start();
$sessionemail=$_SESSION["sessionemail"];

//Skill variables
$skill = $_POST['formskills'];

//Fit variables
$meyersbriggs = $_POST['meyers-briggs'];

/* Ranger sliders for v2.0
$introvertvsextravert = $_POST['IntrovertvsExtravert'];
$rationalvsempathetic = $_POST['RationalvsEmpathetic'];
$theoreticalvsfactual = $_POST['TheoreticalvsFactual'];
*/

//Industry variables
$industry = $_POST['industry'];

$time=time();
/* Checkboxes for v2.0
if (isset($_POST['industry'])) 
{
    print_r($_POST['industry']); 
}
*/

$sql = "UPDATE Users 
SET skill='$skill', meyersbriggs='$meyersbriggs', industry='$industry', time='$time' 
WHERE email='$sessionemail'";

$confirm = mysql_query($sql);

/*
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
---------------------------------------------------The following code recommends a match and creates a profile.html file-----------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------
*/

$result = mysql_query("SELECT * FROM Users");
$num_rows = mysql_num_rows($result)-1;

$bestmatch = 0;
$matchscore = 0;

for ($i=0; $i < $num_rows; $i++) { 
	
	$currmatch = mysql_fetch_array(mysql_query("SELECT * FROM Users ORDER BY time LIMIT " .mysql_real_escape_string($i). ",1"));

	$matchskill = $currmatch['4'];
	$matchmeyersbriggs = $currmatch['5'];
	$matchindustry = $currmatch['6'];

	$matchscore = mysql_fetch_array(mysql_query("SELECT 'INFP' FROM meyersbriggs WHERE Type = 'INFJ'"
		/*"SELECT ".mysql_real_escape_string($meyersbriggs)." FROM meyersbriggs WHERE type=".mysql_real_escape_string($matchmeyersbriggs).*/));
	echo $matchscore;
	echo "<br>";

	if ($matchskill != $skill) {
		
		if ($matchindustry == $industry) {
			
			//$matchscore = mysql_query("SELECT INFJ FROM meyersbriggs WHERE type =INFJ"/*"SELECT ".mysql_real_escape_string($meyersbriggs)." FROM meyersbriggs WHERE type=".mysql_real_escape_string($matchmeyersbriggs).*/);



		}
	}

}















$mysql_close($connect);

?>