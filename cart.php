<?php
	session_start();

echo "

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
  padding: 15px;
  border: none;margin: auto;
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



	<script>
			function showCart()
			{
				alert(".$_POST['productList'].");
			}

			function checkout()
			{
				 var x = document.getElementById('checkout');
				  if (x.style.display === 'none') 
				  {
				    x.style.display = 'inline-block';
				    x.style.width = '45%';
				   /* x.style.border = '1px solid black';*/
				    x.style.padding = '15px';
				    x.style.margin  = '15px';
				  } 
				  else 
				  {
				    x.style.display = 'none';
				  }
			}

			function showPaymentOption()
			{
				  var x = document.getElementById('paymentOptions');
				  if (x.style.display === 'none') 
				  {
				    x.style.display = 'block';
				  
				  } 
				  else 
				  {
				    x.style.display = 'none';
				  }	
			}

			function placeOrder(productListString)
			{
				var modes = document.getElementsByName('paymentMode');
				var mode;
				for(var i = 0; i < modes.length; i++)
				{
    				if(modes[i].checked)
    				{
        				mode = modes[i].value;
    				}
				}

				document.getElementById('productList').value = JSON.stringify(productListString);
				document.getElementById('paymentMethod').value = mode;
				document.getElementById('placeOrderForm').submit();
			}
	</script>
</head>

<body>


		<div class='topnav'>
		<table>
		  <tr> 
			  <td><a class='active' href='home.php'>Home</a></td>
			  <td><input type='seacrh' id='search' name='search' ></td>
			  <td><a href='profile.php'>".$_SESSION['firstName']."</a></td>
			  <td><a href='#' onclick=goToCart() class='currentPage'>Cart <span id='cart'></span></a></td>
			  <td><a href='orders.php'>Orders </span></a></td>
				<td><a href='logout.php' >Sign out</a></td>
			</tr>
		 </table>
	</div>

	

";



$productListString = $_POST['productList'];


$productListArray = json_decode($productListString, false);



$sql = "SELECT product_name, image_path from products where id in (";

for($i=0; $i<count($productListArray); $i++)
{
	$sql .= $productListArray[$i]->id.",";
}
$sql = rtrim($sql,",");
$sql .= ")";

//echo "<br><br><br>".$sql;

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


$result = $conn->query($sql);

$count=0;
$total=0;
if ($result->num_rows > 0) 
{
		
	  while($row = $result->fetch_assoc()) 
	  {
	  		echo " <div class='container'>
		  						<div class='card'><br><br>";
		  		
		  				echo $row['product_name']."<br>";
		  				echo "Quantity ".$productListArray[$count]->quantity." X Price".$productListArray[$count]->price." = Rs. ";
		  				echo ($productListArray[$count]->quantity*$productListArray[$count]->price);
		  				$total += ($productListArray[$count]->quantity*$productListArray[$count]->price);
				echo "";
				echo "";
						echo "<img src=".$row['image_path']." width=150 height=150>";
	  		echo "</div></div><br>";

	  		$count +=1; 
	  }

	  echo "
	  				<div class='container'>
		  			<div class='card'>";

	  echo "Grand Total : Rs. ".$total;
	  echo "<br><br><br><input type=button onclick=checkout() value='Checkout' class='btn'><br>";



}

echo "<div id=checkout style='display: none;'>";
echo "<table cellspacing=10>
	

		<tr>	<td><b>".$_SESSION['firstName']." ".$_SESSION['lastName']."</b></td></tr>
		<tr>	<td><b>Deliver To: </b>". $_SESSION['address']."</td></tr>
		<tr>	<td><b>Email: </b>".$_SESSION['email']."</td></tr>
		<tr>	<td><b>Phone: </b>".$_SESSION['contact']."</td></tr>
		<tr>	<td><input type=button value='Pay Rs. ".$total."'' onclick=showPaymentOption() class='btn'></td> </tr>

		</table>
		
		<div id=paymentOptions style='display: none;'>
			<table>
				<tr>
					<td><input type=radio name=paymentMode value=card></td>
					<td>Credit/Debit Card </td>
				</tr>
				<tr>
					<td><input type=radio name=paymentMode value=upi></td>
					<td>UPI </td>
					</tr>

				<tr>
					<td><input type=radio name=paymentMode value=cod></td>
					<td>Pay on Delivery</td>
				</tr>
				<tr>
					<td><input type=radio name=paymentMode value=emi></td>
					<td>EMI </td>
				</tr>
				<tr>
					<td></td>
					<td><br><input type=submit value='Place Order' class='btn' onclick=placeOrder(".$productListString.")></td></tr>
			</table
		</div>
		<form id='placeOrderForm' method='POST' action='placeOrderController.php'>
			<input type='hidden' name='productList' id='productList'>
			<input type='hidden' name='paymentMethod' id='paymentMethod'>
		</form>

";
echo "</div>";
echo "</div></div>";







echo "
</body>
</html>


";

?>