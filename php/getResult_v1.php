<?php
	define('HOST','localhost');
	define('USERNAME', 'root');
	define('PASSWORD','$1stylD0d');
	define('DB','aiui');
	
	$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
	
	// ------------------------------ Constants (start) ------------------------------ //
	
	$CONV_M_TO_IN = 100/2.54;
	$CONV_M_TO_FT = 100/(12.0*2.54);
	
	$THUMBNAIL_URL_BASE = "https://s3-us-west-2.amazonaws.com/aiuistorage";		//"https://d6lpja1yk7hmv.cloudfront.net/";
	
	// ------------------------------ Constants (end) ------------------------------ //
	
	$category = $_POST['category'];
	$subcategory = $_POST['subcategory'];
	$count = $_POST['count'];
	$vendorCode = $_POST['vendorCode'];
	
	$startCount = $_POST['startCount'];
	$endCount = $_POST['endCount'];
	
	$jsonResultList = array();
	
	$tempVar = 4 * $count;
	
	$category = explode(',', $category);
	
	for($x = 0; $x < count($category); $x++)
	{
		if($category[$x] == "sofanew")
		{
			$stmt = $con->prepare("SELECT * FROM {$category[$x]} WHERE data LIKE '{$subcategory}%' LIMIT {$startCount},{$endCount}");
		}
		else
		{
			$stmt = $con->prepare("SELECT * FROM {$category[$x]} WHERE type LIKE '{$subcategory}%' LIMIT {$startCount},{$endCount}");
		}
		
		$stmt->execute();
		$result = $stmt->get_result();
		
		while ($row = $result->fetch_assoc()) 
		{
			$name = $row["name"];
			$price = $row["price"];
			
			//--------- get price if it already has been filled in by this vendor -----------//
			
			$stmtYY = $con->prepare("CREATE TABLE IF NOT EXISTS catalog.{$vendorCode} 
							( 
								`id` INT NOT NULL AUTO_INCREMENT,
								`productId` TEXT NOT NULL,
								`category` TEXT NOT NULL,
								`subCategory` TEXT NOT NULL,
								`productName` TEXT NOT NULL,
								`price` TEXT NOT NULL,
								PRIMARY KEY (`id`)
							)");

			$stmtYY->execute();		
			
			
			$stmtXX = $con->prepare("SELECT * FROM catalog.{$vendorCode} WHERE productName = '{$name}'");
			$stmtXX->execute();
			$resultXX = $stmtXX->get_result();
			
			if($resultXX->num_rows > 0)
			{
				$rowXX = $resultXX->fetch_assoc();
				$price = $rowXX["price"];
			}
			
			$tempUrl = str_replace('models','/thumbnails',$row["model"]);
			$tempUrl = str_replace('.json','.jpg',$tempUrl);
			$url = $THUMBNAIL_URL_BASE . $tempUrl;
			
			$widthFT = floor($row["width"]*$CONV_M_TO_FT);
			$widthIN = floor($row["width"]*$CONV_M_TO_IN) - 12*$widthFT;
			
			$depthFT = floor($row["depth"]*$CONV_M_TO_FT);
			$depthIN = floor($row["depth"]*$CONV_M_TO_IN) - 12*$depthFT;
			
			$heightFT = floor($row["height"]*$CONV_M_TO_FT);
			$heightIN = floor($row["height"]*$CONV_M_TO_IN) - 12*$heightFT;
			
			$width = $widthFT . "'" . $widthIN . "\"";
			$depth = $depthFT . "'" . $depthIN . "\"";
			$height = $heightFT . "'" . $heightIN . "\"";
			
			$matinfo = "wood,metal,upholstry";
			
			
			
			$data = [
				"name" => $name,
				"url" => $url,
				"width" => $width,
				"depth" => $depth,
				"height" => $height,
				"matinfo" => $matinfo,
				"price" => $price,
			];
			
			array_push($jsonResultList, $data);
		}
	}
	
	echo json_encode(array_values($jsonResultList));

	mysqli_close($con);
?>