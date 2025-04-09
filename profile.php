<html>

<head>
	<style>

		*
		{
			font-family: Helvetica;
		}

	.card
	{
		
		  border : 1px solid black;
		  margin: 15px;
	}

	.topnav {
  overflow: hidden;
  background-color: #FFC0CB;
}

.topnav a {
  float: left;
  color: black;
  text-align: center;
  padding: 14px 16px;
  text-decoration: none;
  font-size: 17px;
}

.topnav a:hover {
  background-color: #DB7093;
  color: white;
  border-radius: 25px;
}

#search{
	width: 300px;
	border: none;
}

.qty
{
	width: 50px;
}

.addToCart
{
	 background-color: #DB7093;
   color: white;
   border: none;
   border-radius: 25px;
}

.addToCart:active
{
	 background-color: #FFC0CB;
}

.currentPage
{
			  background-color: #DB7093;
			  color: white;
			  border-radius: 25px;
}

.card {
  box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
  width: 40%;
  border-radius: 5px; border-radius: 25px; 
  border:  none;
  margin: auto;
}

.card:hover {
  box-shadow: 0 8px 36px 0 rgba(0,0,0,0.2);
}


.container {
  padding: 2px 16px;
  background-color: white;
  border-radius: 15px;
  border:  none;
   
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

<script>
				
				var productList = [];
		
				function addProduct(id, quntity, price, name)
				{
						productList.push({"id":id, "quantity":quntity, "price":price, "name":name});
						document.getElementById('cart').innerHTML = productList.length;

				}

				function goToCart()
				{
						if(productList.length < 1)
						{
								alert("Cart is empty!");
						}
						else
						{
							productList = JSON.stringify(productList);
							document.getElementById('productList').value = productList;
							document.getElementById('submitCart').submit();
						}
				}
</script>

</head>
<body>


<?php
	session_start();

	echo "
		<div class='topnav'>
		<table>
		  <tr> 
			  <td><a class='active' href='home.php'>Home</a></td>
			  <td><form method='get' action='search.php'><input type='seacrh' id='search' name='searchKey' ></form></td>
			  <td><a href='profile.php' class='currentPage'>".$_SESSION['firstName']."</a></td>
			  <td><a href='#' onclick=goToCart()>Cart <span id='cart'></span></a></td>
			  <td><a href='orders.php'>Orders </span></a></td>
			  <td><a href='logout.php'>Sign out </span></a></td>
			</tr>
		 </table>
	</div>


	<br><br><br>
<div class='container'>
<div class='card'>
	<br>
	<h3 align='center' style='color:#DB7093;'>Profile</h3>
	<br>
	<form method='post' action='updateProfile.php'>
	<table align='center' cellspacing='10px'>

		<tr>
			<td style='color:#DB7093;'>
				First Name
			</td>
			<td>
				<input type='text' name='firstName' value='".$_SESSION['firstName']."' required>
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Last Name
			</td>
			<td>
				<input type='text' name='lastName' value='".$_SESSION['lastName']."' required>
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Email
			</td>

			<td>
				<input type='text' name='email' value='".$_SESSION['email']."'>
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Contact No.
			</td>
			<td>
				<input type='number' name='contact' value='".$_SESSION['contact']."'>
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Gender
			</td>
			<td>
			";

			if($_SESSION['gender'] === "Male")
			{
				echo "<input type='radio' name='gender' value='Male' checked><span style='color:#DB7093;'>Male</span>";
				echo "<input type='radio' name='gender' value='Female'><span style='color:#DB7093;'>Female</span>";
			}
			else
			{
				echo "<input type='radio' name='gender' value='Male'><span style='color:#DB7093;'>Male</span>";
				echo "<input type='radio' name='gender' value='Female' checked><span style='color:#DB7093;'>Female</span>";
			}

			echo"	
				
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Date of Birth
			</td>
			<td>
				<input type='date' name='dob' value='".$_SESSION['dob']."'>
			</td>
		</tr>
		<tr>
			<td style='color:#DB7093;'>
				Address
			</td>
			<td>
				<textarea rows='3' cols='20' name='address' >".$_SESSION['address']."</textarea>
			</td>
		</tr>
		<tr>
			<td>
				&nbsp;
			</td>
			<td><br>
				<input type='submit' value='Update' class='btn'>
			</td>
		</tr>

	</table>
	</form>
	<br>
</div>
</div>
</body>
</html>

	";

	
?>
