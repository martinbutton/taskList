<?PHP
/* Task List: Check if user is authenticated.  Looks for a valid session or cookie.
 * - M.Button.
 */

/* Obtain if there is a valid session, if not attempt to create session if there is a cookie set */
function checkCookie() {
	// Check if there is an active session
	if (!isset($_SESSION['loginUser']) || empty($_SESSION['loginUser'])) {
		// If an authenticated session cannot be found, see if there is a cookie set
		if (!isset($_COOKIE['loginEmail'])) {
			// Redirect to login page if no cookie is set.
			header("Location: http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/taskList/login.php");
			die;
		}

		// If cookie was found, make this available in the session
		$_SESSION['loginUser']=$_COOKIE['loginEmail'];
	}
}

/* Return current login in users email address to display in Logout link */
function userName() {
	if (isset($_SESSION['loginUser']) || !empty($_SESSION['loginUser'])) {
		echo $_SESSION['loginUser'];
	}
	else {
		echo "?";
	}
}
?>
