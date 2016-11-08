# Task List
---

Designed and developed by Martin Button.


# Description:

Task List is a simple web application that displays tasks in a list which is order by end/due date.  Tasks are store within a MySQL database and delivered to the user using PHP, AJAX, JSON and JavaScript.  This program was developed in order to demonstrate my web development knowledge and makes up part of my development portfolio at: http://serensoftware.com/


# Deployment:

Place all the files in this repository with the exception of the "devNotes" directory onto your PHP enabled web server.
See "devNotes/makedb.sql" for SQL instructions to create the required "tasks" db table and user access.
Modify "taskManager.php" so that Task List can access your DB.  Modify the associated array near the start of the program source:

```
// Edit dbCreds array below with DB access details and credentials.
$dbCreds=array("host"=>"localhost","database"=>"tasklist","user"=>"taskuser","password"=>"password");
```

Task List should now be ready to use.  NOTE: Task List requires JavaScript to be enabled.

Enjoy,
- Martin Button. 21/10/16
