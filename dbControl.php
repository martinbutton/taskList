<?php
/* dbControl Class - Manages db connection and operations */
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
	public function readDbTasks() {
		try {
			// Prepare Select Statement
			$sqlstm=$this->sqlconn->prepare("select id, startDate, endDate, title, comments, email from tasks");
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

	/* Close DB connection */
	public function closeDb() {
		$this->sqlconn=null;
	}
}
?>