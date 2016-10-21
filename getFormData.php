<?PHP
session_start();

/* Task List: Process AJAX request and return a DB entry JSON object to FE.
 * - M.Button.
 */

// Obtain session details and process form value AJAX request
getFormDetails();

/* Process AJAX request for form data from backend session */
function getFormDetails() {
	// Obtain task ID representing the task in the DB
	if (strlen($_REQUEST['task'])>6) {
		$taskId=substr($_REQUEST['task'],strpos($_REQUEST['task'],"-")+1);
	}
	else {
		echo "{\n\"title\": \"" . JSONescapes($sqlvalues['title']) . "\"\n}\n";
		die;
	}

	// Obtain DB records from session data
	$sqlrecords=$_SESSION['taskRecords'];

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
