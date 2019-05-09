
<?php
	define('HOST','localhost');
	define('USERNAME', 'root');
	define('PASSWORD','$1stylD0d');
	define('DB','catalog');

	$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
	
	//---------------- Input variables (start) --------------------//
	
	$username =  $_POST['username'];
	$password =  $_POST['password'];

	//---------------- Input variables (end) --------------------//	
	
	$vendorTableName = "vendors";
	
	
	$stmt = $con->prepare("SELECT * FROM {$vendorTableName} WHERE username = '{$username}'");
	$stmt->execute();
	$result = $stmt->get_result();
	
	$responseData = "";
	
	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		
		if($password == $row["password"])
		{
			$responseData = "success:" . $row["vendorcode"];
		}
		else
		{
			$responseData = "failed:";
		}
	}
	else
	{
		$responseData = "nouser:";
	}
	
	echo $responseData;
	mysqli_close($con);
?>




