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



			</style>

			<script>
							
							var productList = [];
					
							function addProduct(id, quntity, price, name)
							{
									productList.push({'id':id, 'quantity':quntity, 'price':price, 'name':name});
									document.getElementById('cart').innerHTML = productList.length;

							}

							function goToCart()
							{
									if(productList.length < 1)
									{
											alert('Cart is empty!');
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
			<div class='topnav'>
				<table>
				  	<tr> 
					  <td><a class='active' href='home.php'>Home</a></td>
					  <td><input type='seacrh' id='search' name='search' ></td>
					  <td><a href='profile.php'>".$_SESSION['firstName']."</a></td>
					  <td><a href='#' onclick=goToCart()>Cart <span id='cart'></span></a></td>
					  <td><a href='orders.php' class='currentPage'>Orders </span></a></td>
					  <td><a href='logout.php' >Sign out</a></td>
					</tr>
				</table>
			</div>

	";

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
	
	$sql = "SELECT orders.id as order_id, products.image_path, products.product_name, purchased_products.quantity, purchased_products.price,orders.payment_method, orders.timestamp from orders INNER JOIN purchased_products on orders.id = purchased_products.order_id INNER JOIN products on purchased_products.product_id = products.id where orders.user_id = $user_id ORDER BY orders.timestamp DESC;";

	$result = $conn->query($sql);

	echo "
			<div>
			<table align=center cellspacing=10 cellpadding=10>
				<tr>
					<th>Order Id</th>
					<th></th>
					<th>Item</th>
					<th>Quantity</th>
					<th>Price</th>
					<th>Total</th>
					<th>Payment Type</th>
					<th>Order Date</th>
				</tr>
		";

	if ($result->num_rows > 0) 
	{
		while($row = $result->fetch_assoc())
		{
			echo "
			
					<tr>
						<td>O-00".$row['order_id']."</td>
						<td><img src=".$row['image_path']." width=100 height=100></td>
						<td>".$row['product_name']."</td>
						<td>".$row['quantity']."</td>
						<td>".$row['price']."</td>
						<td>Total Rs. ".$row['price'] * $row['quantity']."</td>
						<td>".$row['payment_method']."</td>
						<td>".$row['timestamp']."</td>
					</tr>";
		}	
	}
	else 
	{
  		echo "Error: " . $sql . "<br>" . $conn->error;
	}

	echo "	
			</table>
			</div>
			</body>
			</html>
	";
	

?>
