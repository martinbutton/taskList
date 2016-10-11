/*
 * [       Javascript: DateMenu v2.0 - 06/10/16                        ]
 * [             Code: Martin Button - marty@outerorbit.org            ]
*/

// Globals
var dateFieldList=[]; // Contains an array holding an object containing details of the date fields.
var months=["January","February","March","April","May","June","July","August","September","October","November","December"];

/* Places the date element (day,month,year) into a dateFieldList array of dateField objects
 * Call this First from the HTML page!
 */
function setDateField(dateElem,yearFrom,yearToo) {
	// Create an dateField object and populate it
	var dateField={elem:null, day:null, month:null, year:null, yearFrom:null, yearToo:null};
	dateField.elem=dateElem;
	dateField.day=document.getElementById("day" + dateElem);
	dateField.month=document.getElementById("month" + dateElem);
	dateField.year=document.getElementById("year" + dateElem);

	// If defined set yearFrom and yearToo values, otherwise use current year.
	var today=new Date();
	if (yearFrom==undefined) {
		dateField.yearFrom=today.getFullYear();
	}
	else {
		dateField.yearFrom=yearFrom;
	}

	if (yearToo==undefined) {
		dateField.yearToo=dateField.yearFrom;
	}
	else {
		dateField.yearToo=yearToo;
	}

	// Pop dateField onto dateFieldList array and call setDate()
	dateFieldList[dateFieldList.length]=dateField;
	setDate(dateElem);
//	console.log("setDateField() dateFieldList length: " + dateFieldList.length);
}

/* Returns a dateField objects for a given date Element */
function getDateField(dateElem) {
	var i;

	// Look through array of dateField objects to find element
	for (i=0; i<dateFieldList.length; i++) {
		if (dateFieldList[i].elem==dateElem) {return dateFieldList[i];}
	}

	return null; // Not found, return null.
}

/* Populate the date fields
 * dateElem = Contains the date select element ID naming convention
 */
function setDate(dateElem) {
	// Obtain Elements
	var dateFields=getDateField(dateElem);
//	console.log("elem: " + dateFields.elem + ", yearFrom: " + dateFields.yearFrom + ", yearToo: " + dateFields.yearToo);

	// Initialise Variables
	var listStr="";
	var i;

	// Populate Months
	for (i=0; i<months.length; i++) {
		listStr+="<option value='" + months[i] + "'>" + months[i] + "</option>";
	}
	dateFields.month.innerHTML=listStr;

	// Populate Years
	listStr="";
	for (i=dateFields.yearFrom; i<dateFields.yearToo+1; i++) {
		listStr+="<option value='" + i + "'>" + i + "</option>";
	}
	dateFields.year.innerHTML=listStr;

	// Populate days and select todays date
	var today=new Date();
	var yearSelect=today.getFullYear()-dateFields.yearFrom;
	dateFields.month.selectedIndex=today.getMonth();
	dateFields.year.selectedIndex=yearSelect;
	setDay(dateFields.day,months[today.getMonth()],today.getFullYear());
	dateFields.day.selectedIndex=today.getDate()-1;

	// Add event handlers to month and year fields.
	dateFields.month.addEventListener("change",function() {changeDay(dateFields.elem);});
	dateFields.year.addEventListener("change",function() {changeDay(dateFields.elem);});
}

/* Called by Event Handlers - calls setDay() to change the number of days in the month when the month or year is changed */
function changeDay(dateElem) {
	var dateFields=getDateField(dateElem);
	var selectedDay=dateFields.day.selectedIndex;
	var maxDays=setDay(dateFields.day,months[dateFields.month.selectedIndex],dateFields.yearFrom + dateFields.year.selectedIndex);

	if (maxDays<=selectedDay) {
		selectedDay=maxDays-1;
	}
	dateFields.day.selectedIndex=selectedDay;

//	console.log("Event! elem: " + dateFields.elem + ", Selected Month: " + months[dateFields.month.selectedIndex] + ", Selected Year: " + (dateFields.yearFrom + dateFields.year.selectedIndex) + ", Max Days: " + maxDays);
}

/* Allow a customer date to be provided and displayed in the date selectors. */
function setCustomDate(dateElem,day,month,year) {
	var dateFields=getDateField(dateElem);
	day--; month--;

	// Check year is within the range of years in the year selector
	if (year>dateFields.yearToo || year<dateFields.yearFrom) { return false; }

	// Set date selectors to customer date
	year-=dateFields.yearFrom;
	dateFields.month.selectedIndex=month;
	dateFields.year.selectedIndex=year;
	setDay(dateFields.day,months[month],year);
	dateFields.day.selectedIndex=day;
	return true;
}

/* Set the number of days in the date field depending on month and leap year */
function setDay(dayElem,month,year) {
	// Adjust number of days in the Month depending on which Month is selected.
	var maxDays=31;

	if (month=="February") {
		// Check for leap years
		if (isLeapYear(year)) {
			maxDays=29;
		} else {
			maxDays=28;
		}
	}
	else if( month=="April" || month=="June" || month=="September" || month=="November")
	{
		maxDays=30;
	}

	// Populate Days
	var i;
	var listStr="";
	for (i=1; i<maxDays+1; i++) {
		listStr+="<option value='" + i + "'>" + i + "</option>";
	}
	dayElem.innerHTML=listStr;

	return maxDays;
}

/* ### Returns true if the year is a leap year. ### */
function isLeapYear(currentYear)
{
	// Computer clocks; epoch is 1970.  1972 would of been the first leap year.
	if (currentYear<1972) {
		return false;
	}
	
	// By taking the current year, subtracting the earlest leap year in computing (1972)
	// and dividing by 4, if there is no remainder then it is a leap year.
	if ((currentYear-1972) % 4==0) {
		return true;
	}
	
	return false;
}
