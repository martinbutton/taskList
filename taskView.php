<?PHP

/* Task List: Validates data before it is stored in DB.  Creates HTML UI task elements when data is read from DB.
 * - M.Button.
 */

/* Display HTML code output of rendered task records */
function displayTasks($sqlrecords) {
	if ($sqlrecords==null) { return; }

	$taskViewId=0;

	foreach ($sqlrecords as $sqlvalues) {
		// Set startDate and endDate values
		$startDate=convertDate($sqlvalues['startDate']);
		$endDate=convertDate($sqlvalues['endDate']);

		echo "<div id='task" . $taskViewId . "' class='taskPanel' onclick='expandTask(\"task" . $taskViewId . "\");'>\n";
		echo "<div class='startDateCol'>";
		echo "Start: " . $startDate;
		echo "</div>\n";
		echo "<div class='taskTitleLabelCol'>";
		echo "Title:";
		echo "</div>\n";
		echo "<div class='endDateCol'>";
		echo "End: " . $endDate;
		echo "</div>\n";
		echo "<div id='task" . $taskViewId . "Title' class='taskTitleRow'>";
		echo $sqlvalues['title'];
		echo "</div>\n</div>\n";

		$taskViewId++;
/*
		echo "Start: " . $startDate . ", End: " . $endDate . "<br>";

		echo "title: " . $sqlvalues['title'];
		echo ", comments: " . $sqlvalues['comments'];
		echo ", email: " . $sqlvalues['email'] . "<br>\n";
*/
	}
}

/* Converts date from Unix Timestamp to dd/mmm/yyyy format */
function convertDate($unixDate) {
		$dateArray=getdate($unixDate);

		// Get day and see if leading 0 needs to be added
		$day=$dateArray['mday'];
		if ($day<10) { $day="0" . $day; }

		$displayDate=$day . "/" . substr($dateArray['month'],0,3) . "/" . $dateArray['year'];
		return $displayDate;
}

/* Clean user input to ensure it is safe to use */
function clean_input($value) {
	$value=trim($value);
	$value=stripslashes($value);
	$value=htmlspecialchars($value);
	return $value;
}

/* Validate the users input */
function validateTask() {
	// Check Title has been entered.
	$title=clean_input($_POST['title']);

	if (strlen($title)<1) {
		echo "<center>Error: Title Empty.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
		return null;
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
		return null;		
	}

	if (strlen($dayToo . $monthToo . $yearToo)<1) {
		echo "<center>Error: End Date Malformed.";
		echo "<p>Back end change not accepted!</p>";
		echo "<a href='taskList.php' style='color: white;'>Okay</a><br><br></center>"; 
		return null;		
	}

	// Convert to Unix timestamp
	$dateFrom=strtotime($dayFrom . " " . $monthFrom . " " . $yearFrom);
	$dateToo=strtotime($dayToo . " " . $monthToo . " " . $yearToo);

	// Clean comments input and add to associative array
	$comments=clean_input($_POST['comments']);
	$sanitisedPost=array("startDate"=>$dateFrom,"endDate"=>$dateToo,"title"=>$title,"comments"=>$comments);

	return $sanitisedPost;

/*	-- Check Code --

	echo "dateFrom :" . $dateFrom . ", dateToo: " . $dateToo . "<br>";

	// Conversion Code to check time stamp
	$convDateFrom=getDate($dateFrom);
	$convDateToo=getDate($dateToo);
	echo "CONV: Day From: " . $convDateFrom['mday'] . " " . $convDateFrom['month'] . " " . $convDateFrom['year'] . "<br>";
	echo "CONV: Day Too: " . $convDateToo['mday'] . " " . $convDateToo['month'] . " " . $convDateToo['year'] . "<br>";
*/
}