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

.centerMsg {
    position: absolute;
    top: 50%;
    left: 50%;
    margin-left: -10%; /* margin is -0.5 * dimension */
    margin-top: -25px; 
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
<form id='submitCart' action="cart.php", method="POST">
	<input type="hidden" name="productList" id="productList">
</form>

<?php
	session_start();

	echo "
		<div class='topnav'>
		<table>
		  <tr> 
			  <td><a class='active' href='home.php'>Home</a></td>
			  <td><form method='get' action='search.php'><input type='seacrh' id='search' name='searchKey' ></form></td>
			  <td><a href='profile.php'>".$_SESSION['firstName']."</a></td>
			  <td><a href='#' onclick=goToCart()>Cart <span id='cart'></span></a></td>
			  <td><a href='orders.php'>Orders </span></a></td>
			  <td><a href='logout.php'>Sign out </span></a></td>
			</tr>
		 </table>
	</div>

	";

echo "<br>";
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

$searchKey = $_GET['searchKey'];
$sql = "SELECT * FROM `products` WHERE brand_name LIKE '%".$searchKey."%' or product_name LIKE '%".$searchKey."%' or product_type LIKE '%".$searchKey."%'";

$result = $conn->query($sql);

$count = 1;

	if ($result->num_rows > 0) 
	{
			echo "<table style='border-spacing: 20px;'>";
		  while($row = $result->fetch_assoc()) 
		  {
		  		if($count == 1)
		  		{
		  			echo "<tr>";
		  		}
		  	
		  		echo "
		  				<td width='25%'>
		  				<div>
				  				<img src=".$row['image_path']." width=200 height=200><br><br>
				  				<b>".$row['product_name']."</b><br><br>
				  				".$row['description']."<br>
				  				<b>Rs. ".$row['price_per_unit']."</b><br>
				  				Quantity <input class=qty type='number' value=1 name=qty id=qty".$row['id']."><br>
				  				Available Quantity ".$row['quantity']."<br><br>
				  				<button class='addToCart' type='submit' 
				  				onclick=addProduct(".$row['id'].",document.getElementById('qty".$row['id']."').value,".$row['price_per_unit'].")>
				  					Add to Cart
				  				</button>
		  				</div>
		  				<br><br><br>
		  				</td>
		  				";

		  				$count = $count +1;

		  		if($count == 5)
		  		{
		  			echo "</tr>";
		  			$count = 1;
		  		}
		  }

		echo "</table>";
	}
	else 
	{
	  echo "<br><br><br><br><span class='centerMsg'>No products with name <b>".$searchKey."</b> available right now !</span>";
	}

$conn->close();

?>

</body>

</html>