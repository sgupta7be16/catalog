
<?php
	
	//---------------- Input variables (start) --------------------//
	
	$vendorCode =  $_POST['vendorCode'];
	$loginStatus =  $_POST['loginStatus'];

	//---------------- Input variables (end) --------------------//	
	
	$responseData = "";
	
	if($loginStatus == "success")
	{
		$responseData = file_get_contents(__DIR__ . "/../pages/catalogTemplate.txt");
		
		$responseData = str_replace("vendorcodeVar", "'".$vendorCode."'", $responseData);
	}
	else
	{
		$responseData = file_get_contents("./index.html");
	}
	
	echo $responseData;
?>




