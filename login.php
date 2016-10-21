<!DOCTYPE html>
<?PHP session_start();?>
<html>
<!-- Task List: Login Page 
		- M.Button
-->
<head>
	<title>Task List: Login</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="taskList.css">
	<link rel="stylesheet" type="text/css" href="login.css">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
</head>
<body>
	<div class="pageHeading">Task List</div>

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
			header("Location: http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/taskList/index.php");
		}
	}
?>

<!-- Login Form -->
<div class="taskListPanel">
	<br>
		<form method="POST" onsubmit="return validate();" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
			<div class="loginDialogBox">
				<div style="padding-top: 20px; width: 80%; margin: auto; text-align: center; color: #003300; font-size: 16px;">Please Login:</div>
				<div style="padding-top: 20px; margin: auto; width: 80%;">
					Email: <input type="email" name="email" id="email" placeholder="email@example.com" required>
				</div>
				<br>
				<div style="width: 120px; margin: auto;">
					<input type="submit" name="submit" value="Login" class="loginBtn">
				</div>
				<div style="margin: auto; width: 80%;">
					<input type="checkbox" name="cookieAccept" value="acceptCookies">
					<span style="font-size: 14px;"> Keep me logged in for 28 days.</span>
				</div>
				<div style="font-size: 12px; border-top: 1px solid #999; width: 80%; margin: auto;">
					<b>Cookie Note:</b> By clicking the above box you are also agreeing for cookies to be used in order to give you a better
					experience using this web application.  Your email address maybe used in future to send task reminders only.
					You email address will not be used for any other purpose.
				</div>
				</br>
			</div>
		</form>
	<br>
</div>

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
