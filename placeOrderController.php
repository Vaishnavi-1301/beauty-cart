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
	.section {
		  width: 45%;
		  display: inline-block;
		  /*border: 1px solid black;  */
		  padding: 15px;
		  margin: 15px;
		}

table 
			{
 				border-collapse: collapse;
  				width: 70%;
  				text-align: center;
			}

			tr:nth-child(even) 
			{
				background-color: #f2f2f2;
			}

.card {
  box-shadow: 0 4px 4px 0 rgba(0,0,0,0.2);
  transition: 0.3s;
 	width: 40%;
  border-radius: 5px; border-radius: 25px;
  padding: 25px;
  border: none;
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
			  <td><a class='active' href='#''>Home</a></td>
			  <td><input type='seacrh' id='search' name='search' ></td>
			  <td><a href='profile.php'>".$_SESSION['firstName']."</a></td>
			  <td><a href='#' class='currentPage' onclick=goToCart()>Cart <span id='cart'></span></a></td>
			  <td><a href='orders.php' >Orders </span></a></td>
				<td><a href='logout.php' >Sign out</a></td>
			</tr>
		 </table>
	</div>

	

";

	$productListString = $_POST['productList'];
	$paymentMethod = $_POST['paymentMethod'];

	//echo "<br>".$productListString;

	//echo "<br>".$paymentMethod;
	$productListArray = json_decode($productListString, false);

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

$user_id = $_SESSION['id'];
$sql = "INSERT INTO orders(user_id, payment_method) values($user_id, '$paymentMethod')";
//echo "<br>".$sql;

$conn->query($sql);
$orderId = $conn->insert_id;


$sql = "INSERT INTO purchased_products(order_id, product_id, quantity, price) values";

for($i=0; $i<count($productListArray); $i++)
{
	//$sql .= $productListArray[$i]->id.",";
	$sql .= "(";
	$sql .= $orderId.",";
	$sql .= $productListArray[$i]->id.",";
	$sql .= $productListArray[$i]->quantity.",";
	$sql .= $productListArray[$i]->price."";
	$sql .= "),";
}
$sql = rtrim($sql,",");

//echo "<br>".$sql;

if($conn->query($sql) === TRUE) 
{
	$sql = "select purchased_products.quantity, purchased_products.price, products.product_name, products.image_path from purchased_products INNER JOIN products ON purchased_products.product_id = products.id where purchased_products.order_id = ".$orderId;

	$result = $conn->query($sql);
  
  echo "
  		<div>
  		<br><br><h3 style='color:green';>Order Placed successfully</h3><h4>Order Id: ".$orderId."</h4>";
  echo "
  	<div class='container'>
  	<div class='card'>

	  	
					<b>".$_SESSION['firstName']." ".$_SESSION['lastName']."</b><br><br>
					<b>Delivery Address: </b>". $_SESSION['address']."<br><br>
					<b>Email: </b>".$_SESSION['email']."<br><br>
					<b>Phone: </b>".$_SESSION['contact']."<br><br>
					<b>Payment Type: </b>".$paymentMethod."<br><br>
			

		</div>
		</div>

		<br>
		<hr>
		<br>
		
		<table cellspacing=10 cellpadding=10>
			<th></th>
			<th>product Name</th>
			<th>Price</th>
			<th>Quantity</th>
			<th>Total</th>
			
		";
		if ($result->num_rows > 0) 
		{
			$total = 0;
			 while($row = $result->fetch_assoc()) 
	  		{
	  			echo "
	  			<tr>
					<td><img src=".$row['image_path']." width=100 height=100></td>
					<td>".$row['product_name']."</td>
					<td>".$row['price']."</td>
					<td>".$row['quantity']."</td>
					<td>".($row['price'] * $row['quantity'])."</td>
				</tr>
	  			";
	  			$total += $row['price'] * $row['quantity'];
			}
			echo "<tr> 
					<td></td>
					<td></td>
					<td></td>
					<td><b>Total</b></td>
					<td><b>".$total."</b></td>
				  </tr>";
		}	

		echo "			
		</table>

		";


}
else 
{
  echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();

echo "
	</div>
	</body>
	</html>
";
?>

