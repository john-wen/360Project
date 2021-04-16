<?php
session_start();

	$host = "localhost";
	$database = "project";
	$user = "project";
	$password = "password";

	$connection = mysqli_connect($host, $user, $password, $database);

	$error = mysqli_connect_error();
	
	if($error != null){
		$output = "<p>Unable to connect to database!</p>";
		exit($output);
	}else {
		$sql = $connection->prepare("SELECT * FROM posts WHERE topic = ?");
		$sql -> bind_param("s", $_POST["Topic"]);
		$sql -> execute();
		
		$results = mysqli_stmt_get_result($sql);
		$data = array();
		
		while($rows = mysqli_fetch_assoc($results)) {
			$data[] = $rows;
		}
		echo json_encode($data);
		
		mysqli_free_result($results);
	}
	
	mysqli_close($connection);
?>
