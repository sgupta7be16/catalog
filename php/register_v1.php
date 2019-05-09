
<?php
	define('HOST','localhost');
	define('USERNAME', 'root');
	define('PASSWORD','$1stylD0d');
	define('DB','catalog');

	$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
	
	//---------------- Input variables (start) --------------------//
	
	$username =  $_POST['username'];
	$password =  $_POST['password'];
	$name =  $_POST['name'];
	$contactno =  $_POST['contactno'];
	$city =  $_POST['city'];

	//---------------- Input variables (end) --------------------//	
	
	$vendorTableName = "vendors";
	
	
	$stmt = $con->prepare("SELECT * FROM {$vendorTableName} WHERE username = '{$username}' OR name = '{$name}' OR contactno = '{$contactno}'");
	
	$stmt->execute();
	$result = $stmt->get_result();
	
	$responseData = "";
	
	if($result->num_rows > 0)
	{
		$row = $result->fetch_assoc();
		
		if(strtolower($username) == strtolower($row["username"]))
		{
			$responseData = "failed:Username '" . $username . "' already exists for \n - Name = '" . $row["name"] . "'\n - Contact No. = '" . $row["contactno"] . "'\n - City = '" . $row["city"] . "'.\n\nPlease register with different username";
		}
		else if(strtolower($name) == strtolower($row["name"]) && $contactno == $row["contactno"])
		{
			$responseData = "failed:Name '" . $name . "' already exists for \n - Username = '" . $row["username"] . "'\n - Contact No. = '" . $row["contactno"] . "'\n - City = '" . $row["city"] . "'";
		}
		else
		{
			$responseData = "failed:Contact No. '" . $contactno . "' already exists for \n - Username = '" . $row["username"] . "'\n - Name = '" . $row["name"] . "'\n - City = '" . $row["city"] . "'";
		}
	}
	else
	{
		$stmt1 = $con->prepare("SELECT MAX(id) FROM {$vendorTableName}");
		$stmt1->execute();
		
		$result1 = $stmt1->get_result();
		$row1 = $result1->fetch_assoc();
		
		$vendorcode = "sv00" . ($row1['MAX(id)'] + 1);

		$stmt2 = $con->prepare("INSERT INTO {$vendorTableName} (name,username,password,contactno,city,vendorcode) VALUES (?,?,?,?,?,?)");

		mysqli_stmt_bind_param($stmt2 , "ssssss", $name, $username, $password, $contactno, $city, $vendorcode);

		$stmt2->execute();
		
		$responseData = "success:Vendor succesfully registered! Please login and continue";
	}
	
	echo $responseData;
	mysqli_close($con);
?>




