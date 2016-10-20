<!DOCTYPE html>
<?PHP session_start();?>

<html>
<head>
	<title>Task List: Logout</title>
</head>
<body style="background-color: #406640;">
<div style="color: white; text-align: center;">Logging out...</div>

<?PHP
/* Task List: Log a user out by destroying session data and cookie.
 * - M.Button.
 */

session_unset();
session_destroy();
setcookie("loginEmail","",time()-3600,"/taskList");
header("Location: http://" . $_SERVER['SERVER_NAME'] . ":" . $_SERVER['SERVER_PORT'] . "/taskList/login.php");
?>

</body>
</html>
