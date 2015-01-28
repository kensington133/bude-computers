<?php
class DB {

	protected $dbLink;

	public function __construct(){
		$this->dbLink = new mysqli('localhost', 'root', '5mbf1Q2q', 'final-project');
	}

	public function __destruct(){
		$this->dbLink->close();
	}

	/*
	*	(string) $sql - MySQL query
	*/
	public function fetchRow($sql){

		if(!$result = $dbLink->query($sql)) die('There was an error running the fetchRow query [' . $dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data[] = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	public function fetchAssoc($sql){

		if(!$result = $this->dbLink->query($sql)) die('There was an error running the fetchAssoc query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	public function getSingleRow($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getSingleRow query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_assoc()) {
				$data = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	public function getFirstRowItems($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getFirstRowItem query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data[] = $row[0];
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	public function getFirstRowItem($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getFirstRowItem query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data = $row[0];
			}

		return $data;
	}
}//end of class

?>