<!DOCTYPE html>
<?PHP session_start();?>
<html>
<!-- Task List: Login Page 
		- M.Button
-->
<head>
	<title>Task List: Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--	<link rel="stylesheet" type="text/css" href="taskList.css"> -->
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>

<!-- PHP Code to handle POST request and set session data and cookie if requested by user -->
<?php
	require "taskView.php";

	if ($_SERVER["REQUEST_METHOD"]) {
		// Check if email address can be obtained of login form
		if (isset($_POST["email"]) && !empty($_POST["email"])) {
			$email=clean_input($_POST["email"]);

			// If selected by user, set a cookie.
			if (isset($_POST["cookieAccept"])) {
				setcookie("loginEmail",$email,time()+(86400*28),"/taskList");
			}
			// Set session data
			$_SESSION['loginUser']=$email;

			// Redirect to taskList
			header("Location: http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/taskList/taskList.php");
		}
	}
?>

<h1>Login Screen</h1>

<form method="POST" onsubmit="return validate();" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
	Email: <input type="text" name="email" id="email" required><br>
	<input type="checkbox" name="cookieAccept" value="acceptCookies"> Accept Cookie Terms.</br>
	<input type="submit" name="submit" value="Login">
</form>

<!-- Embedded JavaScript to validate form input -->
<script>
function validate() {
	var email=document.getElementById("email");

	// Check data has been entered into email address field
	if (email.value==null || email.value=="") { 
		alert("Email Address is required!");
		return false;
	}

	// Validate email address
	if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(email.value)) {} // Do nothing if validation is good.
	else {
   		alert("You have entered an invalid email address!");
   		return false;
   	}

   	return true;
}
</script>

</body>
</html>
