<?php

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


    $category = $_POST["category"];
    $brandName = $_POST["brands"];
    $productType = $_POST["productType"];
    $productName = $_POST["productName"];
    $mfgDate =$_POST["mfgDate"];
    $pricePerUnit = $_POST["pricePerUnit"];
    $quantity = $_POST["quntity"];
    $description =$_POST["productDescription"];

    $target_dir = "images/";
    $absolute_file_path = "images/". basename($_FILES["imageToUpload"]["name"]);
    $target_file = $target_dir . basename($_FILES["imageToUpload"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

    // Check if image file is a actual image or fake image
    if(isset($_POST["submit"])) 
    {
      $check = getimagesize($_FILES["imageToUpload"]["tmp_name"]);
      if($check !== false) 
      {
        echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
      } 
      else 
      {
        echo "File is not an image.";
        $uploadOk = 0;
      }
    }

    // Check if file already exists
    if (file_exists($target_file)) 
    {
      echo "Sorry, file already exists.";
      $uploadOk = 0;
    }

    // Check file size
    if ($_FILES["imageToUpload"]["size"] > 500000) 
    {
      echo "Sorry, your file is too large.";
      $uploadOk = 0;
    }

    // Allow certain file formats
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) 
    {
      echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
      $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) 
    {
      echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    }
     else 
     {
      if (move_uploaded_file($_FILES["imageToUpload"]["tmp_name"], $target_file)) 
      {
        $sql = "INSERT INTO products (category, brand_name, product_type, product_name, mfg_date, price_per_unit, quantity, description, image_path)
        values('$category','$brandName','$productType','$productName','$mfgDate','$pricePerUnit','$quantity','$description','$absolute_file_path')";

          if ($conn->query($sql) === TRUE) 
          {
        
            echo "<br><br><br><br><br><br><p align='center'>Product successfully saved ! <br><br>";
            echo "The file ". htmlspecialchars( basename( $_FILES["imageToUpload"]["name"])). " has been uploaded.";
            //echo "<a href='/beautyCart/index.html'>Add more products</a></p>";
          }
          else 
          {
            echo "Error: " . $sql . "<br>" . $conn->error;
          }

          $conn->close();


        
        //echo "<img src='$target_file'/>";
      }
      else 
      {
        echo "Sorry, there was an error uploading your file.";
      }
    }

?>