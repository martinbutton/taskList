<?PHP

/* Task List: Task management, PHP Backend call functions
 * - M.Button.
 */

require "dbControl.php";
require "taskView.php";

function getTasks() {
	session_unset(); // Clear task session data so it can be refreshed from DB.

	// Connect to database
	$dbAccess=new dbControl("localhost","tasklist","taskuser","password");

	// Check if db connection was successful
	if ($dbAccess==null) {
		echo "<center>Error: Cannot connect to database!<br>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>";
		die;
	}

	// Check if there has been an error retrieving records from db
	$sqlrecords=$dbAccess->readDbTasks();
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
			// TODO: Add update function call here.
		}

		if (array_key_exists("delCancel", $_POST)) {
			$delCancelBtn=clean_input($_POST['delCancel']);
			// TODO: Do nothing for cancel but add delete function call here.
		}

		// echo "Save Value: " . $saveBtn . ", Forget Button: " . $delCancelBtn . "<br>";
	}
}

/* Create a new task */
function newTask() {
	// Double validate data sent from Front End
	if (($sanitisedPost=validateTask())==null) { return; }

	$dbAccess=new dbControl("localhost","tasklist","taskuser","password");

	if ($dbAccess->insertDbTask($sanitisedPost['startDate'], $sanitisedPost['endDate'], $sanitisedPost['title'], $sanitisedPost['comments'], "marty@outerorbit.org")) {
		$dbAccess->closeDb();
		return; // Write Successful.
	}
	else {
		echo "<center>Error: Problems writing new task to database.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
	}

	// Close DB connection
	$dbAccess->closeDb();
}
?>
