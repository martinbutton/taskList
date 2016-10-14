<!DOCTYPE html>
<html>
<head>
	<title>Task List</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="taskList.css">
	<link href="https://fonts.googleapis.com/css?family=Oswald" rel="stylesheet">
	<?php require 'dbControl.php'; require 'taskManager.php';?>
</head>
<body>
	<div class="pageHeading">Task List</div>

	<div id="taskListPanel">
		<!-- TODO: Check for post incase db needs updating before reading. -->
		<?php getTasks();?>
	</div>

	<div id="taskForm">
	<!-- 	<form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> -->
	<form id="formData" method="POST" onsubmit="return validateForm();">
		<div style="margin-left: 7%; margin-right: 7%; padding-bottom: 20px;">
			Title: <input style="width: 100%;" class="formFields" type="text" name="title">
		</div>

		<div id="dateFrom">
			<div style="display: inline-block; width: 55px;">Start Date:</div>
			<select id="dayFrom" class="formFields">
				<option value="dd">dd</option>
			</select>
			<select id="monthFrom" class="formFields">
				<option value="mmm">mmm</option>
			</select>
			<select id="yearFrom" class="formFields">
				<option value="yy">yy</option>
			</select>
		</div>

		<div id="dateToo">
			<div style="display: inline-block; width: 55px;">End Date:</div>
			<select id="dayToo" class="formFields">
				<option value="dd">dd</option>
			</select>
			<select id="monthToo" class="formFields">
				<option value="mmm">mmm</option>
			</select>
			<select id="yearToo" class="formFields">
				<option value="yy">yy</option>
			</select>
		</div>

		<div id="commentBox">
			Comments:<br>
			<textarea name="comments" class="formFields" style="width: 100%; resize: none;" rows="3"></textarea>
		</div>

		<div style="width: 90%; margin: auto; padding-top: 20px;">
			<input type="button" name="delete" value="Delete" class="formFields" id="cancelButton">
			<input type="submit" name="submit" value="Save" class="formFields" id="saveButton" formaction="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
		</div>
	</form>
	</div>

	<div id="newTaskForm">Create a New Task</div>

	<div id="addButton" onclick="newTask();">+</div>

	<script src="dateControl.js"></script>
	<script>setDateField("From",2010,2020); setDateField("Too",2016,2020); setCustomDate("Too",20,11,2018);</script>
	<script src="taskControl.js"></script>
</body>
</html>
