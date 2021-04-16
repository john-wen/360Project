<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
		$valid = true;
		
		if (!isset($_POST["userpost"])) {
			$valid = false;
		}
		if (!isset($_POST["Topic"])) {
			$valid = false;
		}
		
		if ($valid == true) {
			$sql = $connection->prepare("SELECT * FROM users WHERE username = ? AND email = ?");
			$sql -> bind_param("ss", $_SESSION['username'], $_SESSION['email']);
			$sql -> execute();
			
			$results = mysqli_stmt_get_result($sql);
			$resultNumber = $results->num_rows;
			
			if ($resultNumber > 0) {
				$sql = $connection->prepare("INSERT INTO posts (topic,content,user,pfp) VALUES(?,?,?,?)");
				$sql -> bind_param("ssss", $_POST["Topic"], $_POST["userpost"],$_SESSION['username'],$_SESSION['pfp']);
				$sql -> execute();
			}
			
			mysqli_free_result($results);
		}
	}
	
	mysqli_close($connection);
}
?>
