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
		if (!isset($_POST["username"])) {
			$valid = false;
		}
		if (!isset($_POST["password"])) {
			$valid = false;
		}
		
		if ($valid == true) {
			$sql = $connection->prepare("SELECT * FROM users WHERE username = ? AND password = ?");
			$sql -> bind_param("ss", $_POST["username"], $_POST["password"]);
			$sql -> execute();
			
			$results = mysqli_stmt_get_result($sql);
			$resultNumber = $results->num_rows;
			
			if ($resultNumber > 0) {
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $_POST["username"];
				$_SESSION['password'] = $_POST["password"];
				
				while($row = mysqli_fetch_assoc($results)) {
				$_SESSION['pfp'] = $row['pfp'];
				$_SESSION['email'] = $row["email"];
				}
				
			} else {
				$_SESSION['loggedin'] = false;
			}
			
			echo $_SESSION['loggedin'];
			
			mysqli_free_result($results);
			
		} else{
			$_SESSION['loggedin'] = false;
		}
	}
	
	mysqli_close($connection);

}
?>
