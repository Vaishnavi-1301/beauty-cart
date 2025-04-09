<?php

$email = $_POST["email"];
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


$sql = "SELECT * FROM user where email='$email' and password='$password'";

$result = $conn->query($sql);

if ($result->num_rows > 0) 
{
  $row = $result->fetch_assoc();
  //echo "<br><br><br><br><br>Welcome, ".$row["first_name"]." ".$row["last_name"];

  session_start();

  $_SESSION['id'] = $row["id"];
  $_SESSION['firstName'] = $row["first_name"];
  $_SESSION['lastName'] = $row["last_name"];
  $_SESSION['email'] = $row["email"];
  $_SESSION['contact'] = $row["contact"] ;
  $_SESSION['gender'] = $row["gender"];
  $_SESSION['dob'] = $row["dob"];
  $_SESSION['address'] = $row["address"];
  
    header('Location: home.php');
    die();

}
else
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
    .section {
      width: 45%;
      display: inline-block;
      
      padding: 15px;
      margin: 15px;
    }

    #admin {
        position: absolute;
        top: 0px;
        right: 0px;
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

.btn
{
  background-color: #DB7093;
  border-radius: 10px;
  border-color: white;
  width: 90px;
  height: 35px;
  color: white;
}



</style>

</head>

<body style='background-color: #FFC0CB;'>
  <br><br>
<h1 align=center style='color:white;'> Welcome to Beautycart </h1>
<br><br>
<div class='section'>
  <div class='card'>
    <div class='container'>
  <h3 align='center' style='color:#DB7093;'>Register Here</h3>
  
  <form method='post' action='registrationController.php'>
  <table align='center' cellspacing='10px'>

    <tr>
      <td style='color:#DB7093;'>
        First Name
      </td>
      <td>
        <input type='text' name='firstName' required>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Last Name
      </td>
      <td>
        <input type='text' name='lastName' required>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Email
      </td>

      <td>
        <input type='text' name='email'>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Password
      </td>
      <td>
        <input type='password' name='password'>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Contact No.
      </td>
      <td>
        <input type='number' name='contact'>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Gender
      </td>
      <td>
        <input type='radio' name='gender' value='Male'><span style='color:#DB7093;'>Male</span>
        <input type='radio' name='gender' value='Female'><span style='color:#DB7093;'>Female</span>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Date of Birth
      </td>
      <td>
        <input type='date' name='dob'>
      </td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>
        Address
      </td>
      <td>
        <textarea rows='3' cols='20' name='address'></textarea>
      </td>
    </tr>
    <tr>
      <td>
        &nbsp;
      </td>
      <td>
        <input type='submit' value='Sign up' class='btn'>
      </td>
    </tr>

  </table>
  </form>
</div>
</div>
</div>

<div class='section'>
  <div class='card'>
    <div class='container'>
  <h3 align='center' style='color:#DB7093;'>Already have an account ?</h3>
    <form method='post' action='loginController.php'>
  <table align='center' cellspacing='10px'>
    <tr>
      <td style='color:#DB7093;'>E-mail</td>
      <td><input type='text' name='email' required></td>
    </tr>
    <tr>
      <td style='color:#DB7093;'>Password</td>
      <td><input type='password' name='password' required></td>
    </tr>
    <tr>
      <td></td>
      <td><input type='submit' value='Sign In' class='btn'></td>
    </tr>
    <tr>
      <td colspan='2'>
          <br><span style='color: red;'>Invalid username or password !</span>
      </td>
    </tr>
  </table>
  </form>
</div>
</div>
</div>


<a href='adminLogin.php' id='admin'>admin login</a>
</body>
</html>
";

}
?>



