<!DOCTYPE html>

<?php 
session_start(); 
?> 
<script>


function checkLogIn(){
	if (sessionStorage.getItem('LogInStatus') == "true") {
	document.getElementById("LogInButton").innerHTML = "Log Out";
	document.getElementById("RegisterButton").innerHTML = "Profile";
	}
}

</script>


<html lang = "en">
<head>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<link href="css/MainCSS.css" rel="stylesheet">
	<title>Project</title>
</head>
<body onload="checkLogIn()">

<script>

function AJAXLogIn() {
		var formData = new FormData(document.getElementById("LogInForm"))
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "logIn.php", true);
	
		phpSend.onreadystatechange = function() {
			if (this.response == 1) {
				document.getElementById("LogInButton").innerHTML = "Log Out";
				document.getElementById("RegisterButton").innerHTML = "Profile";
				sessionStorage.setItem('LogInStatus', true);
			}else{
				document.getElementById("LogInButton").innerHTML = "Log In";
			}
					console.log(this.response)
		};
	
		phpSend.send(formData);
	
		CloseLogin()
	
		return false
}


function AJAXRegister() {
		if (document.getElementById("password1").value !== document.getElementById("password2").value) {
			alert("Passwords do not match");
		return false
		}
		
		var formData = new FormData(document.getElementById("RegisterForm"))
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "register.php", true);
	
		phpSend.onreadystatechange = function() {
			if (this.response == "UserExists") {
				alert('A user with this username or email already exists!');
			}
			if (this.response == 1) {
				document.getElementById("LogInButton").innerHTML = "Log Out";
				document.getElementById("RegisterButton").innerHTML = "Profile";
				sessionStorage.setItem('LogInStatus', true);
			}else{
				document.getElementById("LogInButton").innerHTML = "Log In";
			}
				
		};
		
		CloseRegister()
		phpSend.send(formData);

		return false
}

function AJAXUpdate() {
		var formData = new FormData(document.getElementById("UpdateForm"))
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "Update.php", true);
	
		phpSend.onreadystatechange = function() {
			if (this.response == "UserExists") {
				alert('A user with this username or email already exists!');
			}
				
		};
	
		phpSend.send(formData);

		return false
}

function openLogin() {
	if (sessionStorage.getItem("LogInStatus") == "false"){
		document.getElementById("LogIn").style.display = "block";
		document.getElementById("Register").style.display = "none";
	}else{
		sessionStorage.setItem('LogInStatus', false);
		document.getElementById("LogInButton").innerHTML = "Log In";
		document.getElementById("RegisterButton").innerHTML = "Register";
		
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "logIn.php", true);
		phpSend.send({});
	}
}

function CloseLogin() {
  document.getElementById("LogIn").style.display = "none";
}

function openRegister() {
	if (sessionStorage.getItem("LogInStatus") == "false"){
		document.getElementById("Register").style.display = "block";
		document.getElementById("LogIn").style.display = "none";
	}else{
		location.reload();
	}
}

function CloseRegister() {
  document.getElementById("Register").style.display = "none";
}

</script>

<div class = "topNavBar">
	<a href = "MainPage.html">Home</a>
	<div class="topNavSearch">
		<form action="">
			<input type="text" placeholder="Search.." name="search">
			<button type="submit">Submit</button>
		</form>
	</div>
	
	<div class="topNavBarRight">
		<button id = "LogInButton" class="LogIn" onclick="openLogin()">Log In</button>
		<button id = "RegisterButton" class="Register" onclick="openRegister()">Register</button>
	</div>
</div>

<div id="LogIn">
  <form class="popUp" id = "LogInForm" onsubmit="return AJAXLogIn()">
    <h1>Login</h1>

    <label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>

    <button type="submit" class="popUp">Login</button>
    <button type="button" class="popUp popUpCancel" onclick="CloseLogin()">Close</button>
  </form>
</div>

<div id="Register">
  <form class="popUp" id = "RegisterForm" onsubmit="return AJAXRegister()">
    <h1>Register</h1>

	<label for="username"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="username" required>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" id = "password1" required>

	<label for="passwordConfirm"><b>Confirm Password</b></label>
    <input type="password" placeholder="Reenter Password" name="passwordConfirm" id = "password2" required>

    <button type="submit" class="popUp">Register</button>
    <button type="button" class="popUp popUpCancel" onclick="CloseRegister()">Close</button>
  </form>
</div>

<div id="main">
	<header id="masthead">
	<?php echo "<h1> Welcome back ".$_SESSION['username']."!</h1>"; ?>
 
	</header>

	<article id="right-sidebar" style="height:auto;">
	    <div class = "pfp">
			<figure>
				<?php echo '<img src="pfp/' . $_SESSION['pfp'] . '.jpg" style="width:100%;height:auto;" />'; ?>
			</figure>
		</div>
	</article>

	<article id="center" style="height:auto;>
		<?php echo '<h2> Email: ' . $_SESSION['email'] . '</h2><br><br>'; ?>
		
		<div id="Update">
			<form class="popUp" id = "UpdateForm" onsubmit="return AJAXUpdate()">
			<h1>Update Profile</h1>

			<label for="username"><br><b>Username</b><br></label>
			<input type="text" placeholder="Enter Username" name="username" style="width:50%" required>

			<label for="email"><br><b>Email</b><br></label>
			<input type="text" placeholder="Enter Email" name="email" style="width:50%" required>

			<label for="password"><br><b>Password</b><br></label>
			<input type="password" placeholder="Enter Password" name="password" style="width:50%" required>

			<label for="passwordConfirm"><br><b>Confirm Password</b><br></label>
			<input type="password" placeholder="Reenter Password" name="passwordConfirm" style="width:50%" required>

			<label for="pfp"><br><b>Profile Image</b></label>
			<input type="file" name="pfp" id="pfp"><br>

			<button type="submit" class="popUp" style="width:53%">Update</button>
		</form>
	</div>
</form>
	</article>
</div>

<footer>
   <div class="footer-related">
      <h2>My Discussion Forum</h2>
   </div>
   <div class="footer-section">
      <h2>Contact Us</h2>
   </div>
</footer>

</body>
</html>




