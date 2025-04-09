<?php
	

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$email = $_POST["email"];
$contact = $_POST["contact"]; 
$gender = $_POST["gender"];
$dob = $_POST["dob"];
$address = $_POST["address"];
$password = $_POST["password"];

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


$sql = "INSERT INTO user (first_name, last_name, email, contact, gender, dob, address, password) 
		VALUES ('$firstName','$lastName','$email','$contact','$gender','$dob','$address','$password')";

if ($conn->query($sql) === TRUE) 
{
  echo "

    <!DOCTYPE html>
<html>
<head>
    <title>BeautyCart</title>
<style>

  *
  {
    font-family: Helvetica;
  }
    

.card {
  box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  border-radius: 5px; border-radius: 25px;
}

.card:hover {
  box-shadow: 0 8px 36px 0 rgba(0,0,0,0.2);
}


.container {
  padding: 2px 16px;
  background-color: white;
  border-radius: 15px;
  
}




</style>

</head>

<body style='background-color: #FFC0CB;'>
  <br><br>
<h1 align='center' style='color:white;'> Welcome to Beautycart </h1>
<br><br>
<div>
  <div class='card'>
    <div class='container'>
      <br><br>
      <p align='center' style='color:green;'>You have successfully registered on BeautyCart !! <br><br>
      <a href='/beautyCart/index.html'>Click here to login</a></p><br><br>
    </div>
  </div>
</div>
</body>
</html>

  ";
}
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();


?>