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
	
	//$category = $_GET['category'];
	//$subcategory = $_GET['subcategory'];
	$strHeader = "S No.,Name,Category,SubCategory,Width,Height,Depth";
	echo $strHeader."<br>";
	
	$jsonResultList = array();
//	$categoryList = ["medianew", "crockerynew","consolenew","shoenew","booknew","barnew"];
//	$subCategoryList = ["media", "crockery","console","shoe","book","bar"];

//	$categoryList = ["sofanew","sofanew","sofanew","sofanew","sofanew"];
//	$subCategoryList = ["U","L","3S","2S","S"];

//	$categoryList = ["diningtablenew"];
//	$subCategoryList = ["diningtable"];
	
//	$categoryList = ["diningchairnew"];
//	$subCategoryList = ["diningchair"];
	
//	$categoryList = ["endtable"];
//	$subCategoryList = [""];
	
//	$categoryList = ["partitionnew"];
//	$subCategoryList = ["partition"];

//	$categoryList = ["cornertable"];
//	$subCategoryList = [""];

//	$categoryList = ["midtable"];
//	$subCategoryList = [""];
	
	
	$categoryList = ["centertable"];
	$subCategoryList = [""];
	
	
	for($c = 0; $c < sizeof($categoryList); $c++)
	{
		$category = $categoryList[$c];
		$subcategory = $subCategoryList[$c];
		

		if($category == "sofanew")
		{
			$stmt = $con->prepare("SELECT * FROM {$category} WHERE data LIKE '{$subcategory}%'");
		}
		else
		{
			$stmt = $con->prepare("SELECT * FROM {$category} WHERE type='{$subcategory}'");
		}
		
		$stmt->execute();
		$result = $stmt->get_result();
		
		$rowCount = 1;
		
		while ($row = $result->fetch_assoc()) 
		{
			$name = $row["name"];
			
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
			
			$price = $row["price"];

			
			$data = [
				"name" => $name,
				"url" => $url,
				"width" => $width,
				"depth" => $depth,
				"height" => $height,
				"matinfo" => $matinfo,
				"price" => $price,
			];
			
			$strData = $rowCount.",".$name.",".$category.",".$subcategory.",".$width.",".$height.",".$depth;
			$rowCount++;
			
			echo $strData."<br>";
		}
	}
	
	//echo json_encode(array_values($jsonResultList));

	mysqli_close($con);
?>