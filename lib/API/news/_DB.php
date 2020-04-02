<?php

class NewsDB {
	
	function __construct() {
		$this->nameTable = 'panels';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID` DESC"
        );
	}
	function insert($text) {
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`text`) VALUES (?)",
			[$text]
		);
		return $this->getLast();
	}
	
	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	
	
}