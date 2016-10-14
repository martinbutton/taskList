<?PHP
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
