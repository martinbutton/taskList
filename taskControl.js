/* Task List: Task Control Script
 * - M.Button.
 */

var formElem=document.getElementById("taskForm"); // Task Form Element
var lastTaskId="closed"; // Task Select Toggle
var formBtn; // Holds a value to say which form button has been clicked

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
		document.getElementById("saveButton").value="Save";
		taskElemTitle.style.display="none";
		lastTaskId=taskId;

		taskDetails(taskId);
	}
}

/* Calculate Y-position for task form for a given the task number in the list */
function formPos(taskId) {
	var yPos=135;

	if (taskId.length > 4) {
		var taskNum=taskId.substring(4,taskId.indexOf("-"));
		yPos+=(taskNum * 75); // 75px addon for each task
	}

	return yPos;
}

/* Update form with selected tasks data */
function taskDetails(taskId) {
	// Create a xmlhttp object for AJAX
	if (window.XMLHttpRequest) {
		// For IE7+, Firefox, Chromw, Safari and Opera
		xmlhttp=new XMLHttpRequest();
	}
	else {
		// For IE5 and IE6
		xmlhttp=new ActiveXObject(Microsoft.XMlHTTP);
	}

	// Wait for backend to return data, then insert into form fields
	xmlhttp.onreadystatechange=function() {
		if (this.readyState==4 && this.status==200) {
			var taskDetailsJSON=JSON.parse(this.responseText);

			// Set title and comment fields
			document.getElementById("title").value=taskDetailsJSON.title;
			document.getElementById("comments").innerHTML=taskDetailsJSON.comments;
			document.getElementById("comments").value=taskDetailsJSON.comments; // Buggy on some browser if value isn't also set.

			// Set Start and End date selectors
			var dateFrom=new Date(+taskDetailsJSON.startDate*1000);
			var dateToo=new Date(+taskDetailsJSON.endDate*1000);
			setCustomDate("From",dateFrom.getDate(),dateFrom.getMonth()+1,dateFrom.getFullYear());
			setCustomDate("Too",dateToo.getDate(),dateToo.getMonth()+1,dateToo.getFullYear());
		}
	}

	// Send AJAX request to backend
	xmlhttp.open("GET","getFormData.php?task="+taskId,true);
	xmlhttp.send();
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
	document.getElementById("saveButton").value="Create";
}

/* pressBtn(btn) My JS Hack.  M.Button.
 * ^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^
 * This function is called by 'onclick' event assigned to each form button.
 * The buttons name field is passed to this function and stored as a global variable which is later used by the 
 * validateForm() function called by onsubmit.
 */
 function pressBtn(btn) {
	formBtn=btn;
}

/* Frontend Task Form Validation Routine called by forms 'onsubmit' event */
function validateForm() {
	// Check if 'delCancel' or 'submit' button was clicked and check buttons current value to determine if this is
	// a delete task request or a cancelation when creating a new event.
	if (formBtn=="delCancel") {
		if (document.getElementById('cancelButton').value=="Cancel") { return true; }

		// TODO: Provide 'Are you sure you want to delete this Task' dialog box here.
		return false;
	}

	// Obtain Form Data
	var title=document.forms["formData"]["title"].value;
	var dayFrom=document.getElementById("dayFrom").value;
	var monthFrom=document.getElementById("monthFrom").selectedIndex;
	var yearFrom=document.getElementById("yearFrom").value;
	var dayToo=document.getElementById("dayToo").value;
	var monthToo=document.getElementById("monthToo").selectedIndex;
	var yearToo=document.getElementById("yearToo").value;

	// Check task title field has a value
	if (title==null || title=="") { 
		alert("Title is required!");
		return false;
	}

	// Convert HTML date elements into a JS Date object
	var dateFrom=new Date(yearFrom,monthFrom,dayFrom);
	var dateToo=new Date(yearToo,monthToo,dayToo);

	// Check to see if from date is not ahead too date
	if (dateFrom > dateToo) {
		alert("The End Date must be on or after the Start Date!");
		return false;
	}

	return true;
}
