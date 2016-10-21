<?php

/* dbControl Class - Manages db connection and operations
 * - M.Button.
 */

class dbControl {
	// Object Field Variables
	private $server,$database,$username,$password;
	private $sqlconn;

	// Construct database connection
	public function __construct($server,$database,$username,$password) {
		$this->server=$server;
		$this->database=$database;
		$this->username=$username;
		$this->password=$password;
	
		// Attempt to establish connection
		try {
			$this->sqlconn=new PDO("mysql:host=" . $this->server . ";dbname=" . $this->database, $this->username, $this->password);
			$this->sqlconn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			return $this->sqlconn;
		}
		catch (PDOException $e) {
			return null;
		}
	}

	/* Retrieve tasks from database */
	public function readDbTasks($loginUser) {
		try {
			// Prepare Select Statement
			$sqlstm=$this->sqlconn->prepare("select id, startDate, endDate, title, comments, email from tasks where email='" . $loginUser . "' order by endDate");
			$sqlstm->execute();

			// Set the resulting array to be associative
			$sqlstm->setFetchMode(PDO::FETCH_ASSOC);

			// Fetch all tasks
			$sqlrecords=$sqlstm->fetchAll();
			return $sqlrecords;
		}
		catch (PDOException $e) {
			return null;
		}
	}

	/* Write a new task into the database */
	public function insertDbTask($startDate, $endDate, $title, $comments, $email) {
		try {
			$sqlstm=$this->sqlconn->prepare("insert into tasks (startDate, endDate, title, comments, email)"
											. " values (:startDate, :endDate, :title, :comments, :email)");
			$sqlstm->bindParam(':startDate', $startDate);
			$sqlstm->bindParam(':endDate', $endDate);
			$sqlstm->bindParam(':title', $title);
			$sqlstm->bindParam(':comments', $comments);
			$sqlstm->bindParam(':email', $email);

			$sqlstm->execute();
			return true;
		}
		catch (PDOException $e) {
			return false;
		}
	}

	/* Update a task in the database */
	public function updateDbTask($id, $startDate, $endDate, $title, $comments, $email) {
		$sqlcmd="update tasks set ";
		$sqlcmd.="startDate=" . $startDate . ", ";
		$sqlcmd.="endDate=" . $endDate . ", ";
		$sqlcmd.="title='" . $title . "', ";
		$sqlcmd.="comments='" . $comments . "' ";
		$sqlcmd.="where id=" . $id;

		try {
			$sqlstm=$this->sqlconn->prepare($sqlcmd);
			$sqlstm->execute();
			return true;
		}
		catch (PDOException $e) {
			return false;
		}
	}

	/* Delete a task in the database */
	public function deleteDbTask($id) {
		$sqlcmd="delete from tasks where id=" . $id;

		try {
			$sqlstm=$this->sqlconn->prepare($sqlcmd);
			$sqlstm->execute();
			return true;
		}
		catch (PDOException $e) {
			return false;
		}
	}

	/* Close DB connection */
	public function closeDb() {
		$this->sqlconn=null;
	}
}
?>
