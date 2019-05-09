<?php
	define('HOST','localhost');
	define('USERNAME', 'root');
	define('PASSWORD','$1stylD0d');
	define('DB','catalog');
	
	$con = mysqli_connect(HOST,USERNAME,PASSWORD,DB);
	
	$jsonResultList = array();	
	
	$stmt = $con->prepare("SELECT * FROM categorysubcategorymapping");	
				
	$stmt->execute();
	$result = $stmt->get_result();
	
	while ($row = $result->fetch_assoc()) 
	{		
		array_push($jsonResultList, $row);
	}
	
	echo json_encode(array_values($jsonResultList));

	mysqli_close($con);
?>