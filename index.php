<!DOCTYPE html>
<?PHP session_start();?>
<html>
<!-- Task List: Task List View
		- M.Button
-->
<head>
	<title>Task List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="taskList.css">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<?PHP require 'taskManager.php'; require 'cookie.php';?>
</head>
<body>
	<div class="pageHeading">
		Task List
		<a href="logout.php" id="logoutLink">Logout: <?PHP userName();?></a>
	</div>

	<!-- Check if user is authenticated -->
	<?PHP checkCookie();?>

	<div class="taskListPanel">
		<!-- Check if any data has been posted and display tasks -->
		<?php checkPost(); getTasks();?>
	</div>

	<!-- Task Form -->
	<div id="taskForm">
	<form id="formData" method="POST" onsubmit="return validateForm();" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		<div style="margin-left: 7%; margin-right: 7%; padding-bottom: 20px;">
			Title: <input style="width: 100%;" class="formFields" type="text" name="title" id="title">
		</div>

		<div id="dateFrom">
			<div style="display: inline-block; width: 55px;">Start Date:</div>
			<select id="dayFrom" class="formFields" name="dayFrom">
				<option value="dd">dd</option>
			</select>
			<select id="monthFrom" class="formFields" name="monthFrom">
				<option value="mmm">mmm</option>
			</select>
			<select id="yearFrom" class="formFields" name="yearFrom">
				<option value="yy">yy</option>
			</select>
		</div>

		<div id="dateToo">
			<div style="display: inline-block; width: 55px;">End Date:</div>
			<select id="dayToo" class="formFields" name="dayToo">
				<option value="dd">dd</option>
			</select>
			<select id="monthToo" class="formFields" name="monthToo">
				<option value="mmm">mmm</option>
			</select>
			<select id="yearToo" class="formFields" name="yearToo">
				<option value="yy">yy</option>
			</select>
		</div>

		<div id="commentBox">
			Comments:<br>
			<textarea id="comments" name="comments" class="formFields" style="width: 100%; resize: none;" rows="3"></textarea>
		</div>

		<div style="width: 90%; margin: auto; padding-top: 20px;">
			<input type="submit" name="delCancel" value="Cancel" class="formFields" id="cancelButton" onclick="pressBtn('delCancel');">
			<input type="submit" name="submit" value="Create" class="formFields" id="saveButton" onclick="pressBtn('submit');">
		</div>
	</form>
	</div>

	<!-- New task button and dialog -->
	<div id="newTaskForm">Create a New Task</div>
	<div id="addButton" onclick="newTask();">+</div>

	<script src="dateControl.js"></script>
	<script src="taskControl.js"></script>
</body>
</html>
