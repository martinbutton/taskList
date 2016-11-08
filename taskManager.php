<?PHP

/* Task List: Task management, PHP Backend call functions
 * - M.Button.
 */

require "dbControl.php";
require "taskView.php";

// Edit dbCreds array below with DB access details and credentials.
$dbCreds=array("host"=>"localhost","database"=>"tasklist","user"=>"taskuser","password"=>"password");

/* Retrieve tasks stored in database */
function getTasks() {
	global $dbCreds;

	// Connect to database
	$dbAccess=new dbControl($dbCreds['host'],$dbCreds['database'],$dbCreds['user'],$dbCreds['password']);
	// $dbAccess=new dbControl("localhost","tasklist","taskuser","password");

	// Check if db connection was successful
	if ($dbAccess==null) {
		echo "<center>Error: Cannot connect to database!<br>";
		echo "<a href='index.php' style='color: white;'>Okay</a><br><br></center>";
		die;
	}

	// Check if there has been an error retrieving records from db
	$sqlrecords=$dbAccess->readDbTasks($_SESSION['loginUser']);
/*	if ($sqlrecords==null) {
		echo "<center>Error: fetching tasks from database!<br>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>";
		$dbAccess->closeDb();
		die;
	}
*/
	// Check if tasks exist in the database and if so, display them
	if (count($sqlrecords)==0) {
			echo "<center>No tasks to display!</center>";
			$_SESSION['taskRecords']=null;
	}
	else {
		$_SESSION['taskRecords']=$sqlrecords;
		displayTasks($sqlrecords);
	}

	// Close DB connection
	$dbAccess->closeDb();
}

/* Check if this is a request from clicking the Cancel/Delete button or the Update/Create button */
function checkPost() {
	if ($_SERVER["REQUEST_METHOD"] == "POST") {
		if (array_key_exists("submit", $_POST)) {
			$saveBtn=clean_input($_POST['submit']);
			if ($saveBtn=="Create") { newTask(); }
			if ($saveBtn=="Save") { updateTask(); }
		}

		if (array_key_exists("delCancel", $_POST)) {
			$delCancelBtn=clean_input($_POST['delCancel']);
			if ($delCancelBtn=="Remove") { deleteTask(); }

			// NOTE: Do nothing if the Cancel button is click on the New Task Screen.
		}
	}
}

/* Delete open selected task */
function deleteTask() {
	global $dbCreds;
	$taskId=$_SESSION['taskDbId'];

	$dbAccess=new dbControl($dbCreds['host'],$dbCreds['database'],$dbCreds['user'],$dbCreds['password']);
	if ($dbAccess->deleteDbTask($taskId)) {
		$dbAccess->closeDb();
		return; // Delete Successful.
	}
	else {
		echo "<center>Error: Problems deleting task in database.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='index.php' style='color: white;'>Okay</a><br><br></center>"; 			
	}

	// Close DB Connection
	$dbAccess->closeDb();
}

/* Update the existing selected task */
function updateTask() {
	global $dbCreds;

	if (($sanitisedPost=validateTask())==null) { return; }

	// Escape title and comments for SQL storage by escaping single quote.  Note: Only needs doing on update!
	$sanitisedPost['title']=str_replace("'", "''", $sanitisedPost['title']);
	$sanitisedPost['comments']=str_replace("'", "''", $sanitisedPost['comments']);

	$taskId=$_SESSION['taskDbId'];
	$dbAccess=new dbControl($dbCreds['host'],$dbCreds['database'],$dbCreds['user'],$dbCreds['password']);

	// Do update here
	if ($dbAccess->updateDbTask($taskId,$sanitisedPost['startDate'], $sanitisedPost['endDate'], $sanitisedPost['title'], $sanitisedPost['comments'], $_SESSION['loginUser'] )) {
		$dbAccess->closeDb();
		return; // Write Successful.
	}
	else  {
		echo "<center>Error: Problems writing task update to database.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='index.php' style='color: white;'>Okay</a><br><br></center>"; 	
	}

	// Close DB Connection
	$dbAccess->closeDb();
}

/* Create a new task */
function newTask() {
	global $dbCreds;

	// Double validate data sent from Front End
	if (($sanitisedPost=validateTask())==null) { return; }

	$dbAccess=new dbControl($dbCreds['host'],$dbCreds['database'],$dbCreds['user'],$dbCreds['password']);

	if ($dbAccess->insertDbTask($sanitisedPost['startDate'], $sanitisedPost['endDate'], $sanitisedPost['title'], $sanitisedPost['comments'], $_SESSION['loginUser'])) {
		$dbAccess->closeDb();
		return; // Write Successful.
	}
	else {
		echo "<center>Error: Problems writing new task to database.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='index.php' style='color: white;'>Okay</a><br><br></center>"; 
	}

	// Close DB connection
	$dbAccess->closeDb();
}
?>
