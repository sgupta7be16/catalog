
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
	
	
	//------------------ Functions (start) ------------------//
	
	function writeToLogFile($fileName, $logData)
	{
		$fileBasePath = "D:/Program/xampp/htdocs/secure/ROOT/catalog/logs/";		
		$filePath = $fileBasePath . $fileName;
		
		$fileObj = fopen($filePath, "a");
		fwrite($fileObj, $logData);
		fclose($fileObj);
	}
	
	//------------------ Functions (end) ------------------//
	
	
	
	
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
	$oldData = $result2->fetch_assoc();
	
	$successful = "";
	
	if($result2->num_rows > 0)
	{
		$stmt3 = $con->prepare("UPDATE {$vendorCode} SET price = '{$price}' WHERE productName = '{$productName}'");
		
		$successful = $stmt3->execute();
		
		// ----- Prepare log data ----- //
		
		$logFileData = date('Y-m-d H:i:s') . " -> Price updated for";
		$logFileData .= "\n - Product Name : '" . $productName;
		$logFileData .= "\n - Product Id : '" . $productId;
		$logFileData .= "\n - Category : " . $category;
		$logFileData .= "\n - SubCategory : " . $subCategory;
		$logFileData .= "\n - Old Price : " . $oldData["price"];
		$logFileData .= "\n - NEW Price : " . $price;
		$logFileData .= "\n#####\n\n";
		
		$logFileName = $vendorCode . ".txt";
		writeToLogFile($logFileName, $logFileData);
		
		echo $logFileData . " -> " . $logFileName;
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




