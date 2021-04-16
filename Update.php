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
		
		$hasImage = true;
		
		$target_dir = "pfp/";
		
		if ($_FILES['pfp']['size'] == 0 || $_FILES['pfp']['error'] != 0) {
			$hasImage = false;
		}
		
		if ($valid == true) {
			$sql = $connection->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
			$sql -> bind_param("ss", $_POST["username"], $_POST["email"]);
			$sql -> execute();
			
			$results = mysqli_stmt_get_result($sql);
			$resultNumber = $results->num_rows;
			
			if ($resultNumber > 0) {
				echo "UserExists";
			} else {
				if ($hasImage == true) {
					$sql = $connection->prepare("UPDATE users SET username = ?,pfp = ?, email = ?, password = ? WHERE username = ?");
					$sql -> bind_param("sssss", $_POST['username'], $_POST['username'], $_POST['email'], $_POST['password'], $_SESSION['username']);
					$sql -> execute();
					$_SESSION['pfp'] = $_POST['username'];
					$temp = explode(".", $_FILES["pfp"]["name"]);
					$newfilename =  $_POST['username'] . '.' . end($temp);
				
					move_uploaded_file($_FILES["pfp"]["tmp_name"], $target_dir.$newfilename);
				}else{
					$sql = $connection->prepare("UPDATE users SET username = ?,pfp = 'Default', email = ?, password = ? WHERE username = ?");
					$sql -> bind_param("ssss", $_POST['username'], $_POST['email'], $_POST['password'], $_SESSION['username']);
					$sql -> execute();
					$_SESSION['pfp'] = "Default";
				}
			
				$_SESSION['loggedin'] = true;
				$_SESSION['username'] = $_POST["username"];
				$_SESSION['password'] = $_POST["password"];
				$_SESSION['email'] = $_POST['email'];
			}
			
			mysqli_free_result($results);
		}
	}
	
	mysqli_close($connection);
}
?>
