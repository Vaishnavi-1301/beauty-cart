<?php

$username = $_POST["username"];
$password = $_POST["password"];

	if($username === "admin" && $password === "admin123")
	{
		echo " <br><br><br><br><br>
					<div align='center'>
	
					<h3 align='center'>Add Products</h3>
					
					<form method='post' action='productUploadController.php' enctype='multipart/form-data'>
					<table align='center' cellspacing='10px'>

						<tr>
							<td>
								Category
							</td>
							<td>
								<select name='category'>
									<option>Makeup</option>
									<option>Skin</option>
									<option>Hair</option>
									<option>Bath & Body</option>
									<option>Jwellery</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Brand Name
							</td>
							<td>
								<select name='brands'>
									<option>LAKME</option>
									<option>LOREAL</option>
									<option>GARNIER</option>
									<option>NIVIA</option>
									<option>OLAY</option>
									<option>BIOTIQUE</option>
									<option>LOTUS</option>
								</select>
							</td>
						</tr>
						<tr>
							<td>
								Product Type
							</td>

							<td>
								<input type='text' name='productType'>
							</td>
						</tr>
						<tr>
							<td>
								Product Name
							</td>
							<td>
								<input type='text' name='productName'>
							</td>
						</tr>
						<tr>
							<td>
								Mfg Date
							</td>
							<td>
								<input type='date' name='mfgDate'>
							</td>
						</tr>
						<tr>
							<td>
								Price Per Unit
							</td>
							<td>
								<input type='number' name='pricePerUnit'>
							</td>
						</tr>
						<tr>
							<td>
								Quantity
							</td>
							<td>
								<input type='number' name='quntity'>
							</td>
						</tr>
						<tr>
							<td>
								Product Description
							</td>
							<td>
								<textarea rows='3' cols='20' name='productDescription'></textarea>
							</td>
						</tr>
						<tr>
							<td>
								Product Image
							</td>
							<td>
								<input type='file' name='imageToUpload'>
							</td>
						</tr>
						<tr>
							<td>
								&nbsp;
							</td>
							<td>
								<input type='submit' value='Save'>
							</td>
						</tr>

					</table>
					</form>
				</div>";

	}  
	else
	{
		echo "login Failed :(";
	}
?>

