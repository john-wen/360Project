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
		if (!isset($_POST["email"])) {
			$valid = false;
		}
		if (!isset($_POST["password"])) {
			$valid = false;
		}
		if (!isset($_POST["passwordConfirm"])) {
			$valid = false;
		}
		
		if ($_POST["password"] == $_POST["passwordConfirm"]){
			if ($valid == true) {
			$sql = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
			$sql -> bind_param("ss", $_POST["username"], $_POST["email"]);
			$sql -> execute();
			
			$results = mysqli_stmt_get_result($sql);
			$resultNumber = $results->num_rows;
			
			if ($resultNumber > 0) {
				echo "UserExists";
			} else {
				$sql = $connection->prepare("INSERT INTO users (username,pfp,email,password) VALUES(?,'Default',?,?)");
				$sql -> bind_param("sss", $_POST["username"], $_POST["email"],$_POST["password"]);
				$sql -> execute();
				
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $_POST["username"];
				$_SESSION['password'] = $_POST["password"];
				$_SESSION['pfp'] = "Default";
				$_SESSION['email'] = $_POST["email"];
				
				echo $_SESSION['loggedin'];
			}
			
			mysqli_free_result($results);
		}
			
		}else{
			
		}
	}

	mysqli_close($connection);
}
?>
