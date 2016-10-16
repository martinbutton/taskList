<?PHP

/* Task List: Validates data before it is stored in DB.  Creates HTML UI task elements when data is read from DB.
 * - M.Button.
 */

function clean_input($value) {
	$value=trim($value);
	$value=stripslashes($value);
	$value=htmlspecialchars($value);
	return $value;
}

function validateTask() {
	// Check Title has been entered.
	$title=clean_input($_POST['title']);

	if (strlen($title)<1) {
		echo "<center>Error: Title Empty.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
		return false;
	}

	// Check the Start date isn't after the End date
	$dayFrom=clean_input($_POST['dayFrom']);
	$monthFrom=clean_input($_POST['monthFrom']);
	$yearFrom=clean_input($_POST['yearFrom']);

	$dayToo=clean_input($_POST['dayToo']);
	$monthToo=clean_input($_POST['monthToo']);
	$yearToo=clean_input($_POST['yearToo']);

	if (strlen($dayFrom . $monthFrom . $yearFrom)<1) {
		echo "<center>Error: Start Date Malformed.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
		return false;		
	}

	if (strlen($dayToo . $monthToo . $yearToo)<1) {
		echo "<center>Error: End Date Malformed.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
		return false;		
	}

	return true;

/*	-- Check Code --

	// Convert to Unix timestamp
	$dateFrom=strtotime($dayFrom . " " . $monthFrom . " " . $yearFrom);
	$dateToo=strtotime($dayToo . " " . $monthToo . " " . $yearToo);

	echo "dateFrom :" . $dateFrom . ", dateToo: " . $dateToo . "<br>";

	// Conversion Code to check time stamp
	$convDateFrom=getDate($dateFrom);
	$convDateToo=getDate($dateToo);
	echo "CONV: Day From: " . $convDateFrom['mday'] . " " . $convDateFrom['month'] . " " . $convDateFrom['year'] . "<br>";
	echo "CONV: Day Too: " . $convDateToo['mday'] . " " . $convDateToo['month'] . " " . $convDateToo['year'] . "<br>";
*/
}