/* Task Control Script
 * - M.Button
 */

 var formElem=document.getElementById("taskForm");
 var lastTaskId="closed";

/* Expand Selected Task and close others that might be open */
function expandTask(taskId) {
	var taskElem=document.getElementById(taskId);
	var taskElemTitle=document.getElementById(taskId+"Title");
	var lastTaskElem;

	// If a previous task is open when clicking this task, close previous task
	if (lastTaskId!=taskId && lastTaskId!="closed") {
		lastTaskElem=document.getElementById(lastTaskId);
		lastTaskElem.style.height="65px";
		lastTaskElem.style.backgroundColor="#ddd";
		document.getElementById(lastTaskId+"Title").style.display="block";
	}

	// Toggle opening and closing of task panel
	if (taskElem.style.height=="315px") {
		formElem.style.display="none";
		taskElem.style.height="65px";
		taskElem.style.backgroundColor="#ddd";
		taskElemTitle.style.display="block";
		lastTaskId="closed";
	}
	else {
		formElem.style.top=formPos(taskId) + "px";
		formElem.style.display="block";
		taskElem.style.height="315px"; // Was 300px;
		taskElem.style.backgroundColor="white";
		document.getElementById("cancelButton").value="Remove";
		taskElemTitle.style.display="none";
		lastTaskId=taskId;
	}
}

/* Calculate Y-position for task form for a given the task number in the list */
function formPos(taskId) {
	var yPos=135;

	if (taskId.length > 4) {
		taskNum=taskId.slice(4); // Extract task number from the end of the task Id
		yPos+=(taskNum * 75); // 75px addon for each task
	}

	return yPos;
}

/* Add a new task */
function newTask() {
	// Close open tasks panel if one if open
	if (lastTaskId!="closed") {
		lastTaskElem=document.getElementById(lastTaskId);
		lastTaskElem.style.height="65px";
		lastTaskElem.style.backgroundColor="#ddd";
		document.getElementById(lastTaskId+"Title").style.display="block";
		formElem.style.display="none";
		lastTaskId="closed";
	}

	// Display new task form
	formElem.style.display="block";
	formElem.style.top="124px";
	document.getElementById("newTaskForm").style.display="block";
	document.getElementById("cancelButton").value="Cancel";
}

function validateForm() {
	var title=document.forms["formData"]["title"].value;

	// Test Fullname field
	if (title==null || title=="") { alert("Title is required!"); return false;}

	// TODO: Do testing for endDate being before startDate
	return true;
}
