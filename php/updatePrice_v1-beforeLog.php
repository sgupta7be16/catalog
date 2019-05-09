
<?php
	define('HOST','localhost');
	define('USERNAME', 'root');
	define('PASSWORD','$1stylD0d');
	define('DB','catalog');

	$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
	
	//---------------- Input variables (start) --------------------//
	
	$productId =  $_POST['productId'];
	$category =  $_POST['category'];
	$subCategory =  $_POST['subCategory'];
	$productName =  $_POST['productName'];
	$price =  $_POST['price'];
	$vendorCode =  $_POST['vendorCode'];

	//---------------- Input variables (end) --------------------//	
	
	$stmt = $con->prepare("CREATE TABLE IF NOT EXISTS {$vendorCode} 
							( 
								`id` INT NOT NULL AUTO_INCREMENT,
								`productId` TEXT NOT NULL,
								`category` TEXT NOT NULL,
								`subCategory` TEXT NOT NULL,
								`productName` TEXT NOT NULL,
								`price` TEXT NOT NULL,
								PRIMARY KEY (`id`)
							)");

	$stmt->execute();
		
	
	$stmt2 = $con->prepare("SELECT * FROM {$vendorCode} WHERE productName = '{$productName}'");
	$stmt2->execute();
	$result2 = $stmt2->get_result();
	
	$successful = "";
	
	if($result2->num_rows > 0)
	{
		$stmt3 = $con->prepare("UPDATE {$vendorCode} SET price = '{$price}' WHERE productName = '{$productName}'");
		
		$successful = $stmt3->execute();
	}
	else
	{
		$stmt1 = $con->prepare("INSERT INTO {$vendorCode} (productId,category,subCategory,productName,price) VALUES (?,?,?,?,?)");

		mysqli_stmt_bind_param($stmt1 , "sssss", $productId, $category, $subCategory, $productName, $price);

		$successful = $stmt1->execute();
	}
	
	echo $successful;
	mysqli_close($con);
?>




