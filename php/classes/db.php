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
	protected function fetchRow($sql){

		if(!$result = $dbLink->query($sql)) die('There was an error running the fetchRow query [' . $dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data[] = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	protected function fetchAssoc($sql){

		if(!$result = $this->dbLink->query($sql)) die('There was an error running the fetchAssoc query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_assoc()) {
				$data[] = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	protected function getSingleRow($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getSingleRow query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_assoc()) {
				$data = $row;
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	protected function getFirstRowItems($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getFirstRowItem query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data[] = $row[0];
			}

		return $data;
	}

	/*
	*	(string) $sql - MySQL query
	*/
	protected function getFirstRowItem($sql){
		if(!$result = $this->dbLink->query($sql)) die('There was an error running the getFirstRowItem query [' . $this->dbLink->error . ']');

			while ($row = $result->fetch_row()) {
				$data = $row[0];
			}

		return $data;
	}

	protected function insertData($sql){
		return $this->dbLink->query($sql);
	}
}//end of class

?>