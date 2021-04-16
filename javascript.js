
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
			
			location.reload();
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
				
			location.reload();
		};
		
		CloseRegister()
		phpSend.send(formData);

		return false
}

function AJAXSendtopic() {
		var formData = new FormData(document.getElementById("Userform"))
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "createtopic.php", true);
	
		phpSend.onreadystatechange = function() {
		};
		phpSend.send(formData);
		
		alert('Topic Created');
		
		return false
}

function AJAXSendPost() {
		var formData = new FormData(document.getElementById("Userform"))
		var phpSend = new XMLHttpRequest();
		phpSend.open("POST", "createpost.php", true);
	
		phpSend.onreadystatechange = function() {
			console.log(this.response)

		};
		formData.append('Topic', sessionStorage.getItem('Topic'));
		phpSend.send(formData);

		alert('Reply Posted');

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
		location.reload();
	}
}

function CloseLogin() {
	document.getElementById("LogIn").style.display = "none";
}


function CloseRegister() {
  document.getElementById("Register").style.display = "none";
}
