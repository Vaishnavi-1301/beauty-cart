<?php

session_start();

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$contact = $_POST["contact"]; 
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$address = $_POST["address"];

$db_servername = "localhost";
$db_username = "root";
$db_password = "root";
$db_name = "beauty_cart";

// Create connection
$conn = new mysqli($db_servername, $db_username, $db_password, $db_name, 3305);

// Check connection
if ($conn->connect_error) 
{
  die("Connection failed: " . $conn->connect_error);
}


$userId = $_SESSION['id'];

$sql = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', email = '$email', contact = '$contact', gender = '$gender', 
		dob = '$dob', address = '$address' where id=".$userId ;

if ($conn->query($sql) === TRUE) 
{

	  $_SESSION['firstName'] = $firstName;
	  $_SESSION['lastName'] = $lastName;
	  $_SESSION['email'] = $email;
	  $_SESSION['contact'] = $contact ;
	  $_SESSION['gender'] = $gender;
	  $_SESSION['dob'] = $dob;
	  $_SESSION['address'] = $address ;

	header("location: profile.php");
	exit();
}
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>