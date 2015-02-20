<?php

//connect to database
//$mysql_hostname = "localhost:3306";
$mysql_hostname = "localhost:8889";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "myapp";

$connect = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
or die("Couldn't connect");

mysql_select_db($mysql_database, $connect) or die("Uh oooooh, couldn't find the database");

//Gets variables from user
$firstname = $_POST['first-name'];
$lastname = $_POST['last-name'];
$email = $_POST['email'];
$password = $_POST['password'];
$password2 = $_POST['password-match'];

//start session and create session variable for email
session_start();
$_SESSION["sessionemail"] = $email;


//Checks whether passwords match
if ($password == $password2) {

	//Checks whether email has been used before
	$sql = "SELECT COUNT(*) num FROM users WHERE email = '" . mysql_real_escape_string($email) . "'";
	$result = mysql_query($sql) or die('error');
	$row = mysql_fetch_assoc($result);
	if($row['num']) {
	  	echo "Email is already taken.";
	}
	else {

		// Writes to DB
		$sql = "INSERT INTO users (email, password, firstname, lastname) VALUES ('$email', '$password', '$firstname', '$lastname')";
		$confirm = mysql_query($sql);

		header('Location: survey.html');


	}
}
else{
	echo "Passwords do not match. Please retry.";
}

$mysql_close($connect);

?>