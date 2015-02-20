<?php

//connect to database
//$mysql_hostname = "localhost:3306";
$mysql_hostname = "localhost";
$mysql_user = "root";
$mysql_password = "root";
$mysql_database = "myapp";

$connect = mysql_connect($mysql_hostname, $mysql_user, $mysql_password)
or die("Couldn't connect");

mysql_select_db($mysql_database, $connect) or die("Uh oooooh, couldn't find the database");

//Gets variables from user
$email = $_POST['email'];
$password = $_POST['password'];

//Create Query to get password from DB users for a given email
$sql = 'SELECT password FROM users WHERE email="'.mysql_real_escape_string($email).'"';

//Query DB
$result = mysql_query($sql);

//Create array from user row in DB
$user = mysql_fetch_assoc($result);

//Checks whether email has been used before
$check     = mysql_query("SELECT email FROM users WHERE email = '$email'")  
or die(mysql_error()); 
$check2    = mysql_num_rows($check); 

//  if the email exists it gives an error, otherwise the user's info is entered into the database
if ($check2 == 0) { 
	die('Sorry, the email is not registered'); 
}
	else {
		//Check user's password against password entered and if admin display users
		if ($email == "admin@admin.com" && $password == "12345") {
			$sql_column = 'SELECT * FROM users';
			$resource = mysql_query($sql_column);
			while ($row = mysql_fetch_assoc($resource)) {
				echo $row['email'];
				echo " ";
				echo $row['firstname'];
				echo " ";
				echo $row['lastname'];
				echo '<br/>';
			}

		} elseif ($user['password'] == $password) {
			$sql = "SELECT * FROM users WHERE email = '" . mysql_real_escape_string($email) . "'";
			$result = mysql_query($sql);
			$row = mysql_fetch_assoc($result); 
		    echo "Welcome back ";

		    $industry = $row['industry'];


		    if ($industry == 'public') {
	
				$matchdata= mysql_fetch_array(mysql_query("SELECT * FROM Users ORDER BY time LIMIT 0,1"));

			}elseif ($industry == 'notforprofit') {

					$matchdata= mysql_fetch_array(mysql_query("SELECT * FROM Users ORDER BY time LIMIT 1,1"));

			}elseif($industry == 'private') {

					$matchdata= mysql_fetch_array(mysql_query("SELECT * FROM Users ORDER BY time LIMIT 2,1"));
			}

				echo 

				"
				<html>
					Meet your puuuuurfect cofounder:
					<br>

					<table>
						<td>
							<tr>
								Name: ";
								echo $matchdata['2'];
								echo $matchdata['3'];
							echo "
							</tr>
						</td>
						<td>
							<tr>
								Email: ";
								echo $matchdata['0'];
							echo "
							</tr>
						</td>
						<td>
						
							<tr>
								Skill: ";
								echo $matchdata['4'];
							echo "
							</tr>

						</td>
						<td>

							<tr>
								Personality: ";
								echo $matchdata['5'];
							echo "
							</tr>

						</td>
						<td>

							<tr>
								Industry: ";
								echo $matchdata['6'];
							echo "
							</tr>

						</td>";

							
				echo " </table> </html>";


		} else {
		    echo "fail";
		}
	}

$mysql_close($connect);

?>