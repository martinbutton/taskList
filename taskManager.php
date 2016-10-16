<?PHP

/* Task List: Task management, PHP Backend call functions
 * - M.Button.
 */

require 'dbControl.php';
require "taskView.php";

function getTasks() {
	// Connect to database
	$dbAccess=new dbControl("localhost","tasklist","taskuser","password");

	// Check if db connection was successful
	if ($dbAccess==null) {
		echo "<center>Error: Cannot connect to database!</center>";
		die;
	}

	// Check if there has been an error retrieving records from db
	$sqlrecords=$dbAccess->readDbTasks();
	if ($sqlrecords==null) {
		echo "<center>Error: fetching tasks from database!</center>";
		$dbAccess->closeDb();
		die;
	}

	// Check if tasks exist in the database and if so, display them
	if (count($sqlrecords)==0) {
			echo "<center>No tasks to display!</center>";
	}
	else {
		foreach ($sqlrecords as $sqlvalues) {
			echo "startDate: " . $sqlvalues['startDate'];
			echo ", endDate: " . $sqlvalues['endDate'];
			echo ", title: " . $sqlvalues['title'];
			echo ", comments: " . $sqlvalues['comments'];
			echo ", email: " . $sqlvalues['email'] . "<br>\n";
		}
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
	if (validateTask()) { 
		// TODO: Perform Database calls here
		echo "Going to create a new task.<br>";
	}

	$dbAccess=new dbControl("localhost","tasklist","taskuser","password");

/*
	if ($dbAccess->insertDbTask(2000, 3000, "test write", "testing DB write.", "marty@outerorbit.org")) {
		echo "write success!";
	}
	else {
		echo "write failure!";
	}
*/

	// Close DB connection
	$dbAccess->closeDb();
}
?>
