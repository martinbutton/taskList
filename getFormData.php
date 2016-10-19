<?PHP
/* Task List: Validates data before it is stored in DB.  Creates HTML UI task elements when data is read from DB.
 * - M.Button.
 */

// Obtain session details and process form value AJAX request
session_start();
getFormDetails();

/* Process AJAX request for form data from backend session */
function getFormDetails() {
	// Obtain task ID representing the task in the DB
	if (strlen($_REQUEST['task'])>6) {
		$taskId=substr($_REQUEST['task'],strpos($_REQUEST['task'],"-")+1);
		// echo "DB Task ID: " . $taskId;
	}
	else {
		echo "Failed!";
		die;
	}

	// Obtain DB records from session data
	$sqlrecords=$_SESSION['taskRecords'];
	// print_r($sqlrecords);

	// Search for task details and return a JSON object.
	echo "{\n";
	foreach ($sqlrecords as $sqlvalues) {
		if ($sqlvalues['id']==$taskId) {
			echo "\"id\": \"" . $sqlvalues['id'] . "\",\n";
			echo "\"title\": \"" . JSONescapes($sqlvalues['title']) . "\",\n";
			echo "\"startDate\": \"" . $sqlvalues['startDate'] . "\",\n";
			echo "\"endDate\": \"" . $sqlvalues['endDate'] . "\",\n";
			echo "\"comments\": \"" . JSONescapes($sqlvalues['comments']) . "\"\n";
		}
	}
	echo "}\n";

	// Update taskId session varable with current returned task Id.
	// This can then be used with update and delete operations.
	$_SESSION['taskDbId']=$taskId;
}

/* Escape \n, \r and \t characters and qoutes */
function JSONescapes($str) {
	$str=str_replace("\n", "\\n", $str);
	$str=str_replace("\r", "\\r", $str);
	$str=str_replace("\t", "\\t", $str);
	$str=str_replace("&amp;", "&", $str);
	$str=str_replace("&quot;", '\\"', $str);
	return $str;
}
?>
