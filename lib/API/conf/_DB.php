<?php

class ConfDB {
	
	function __construct() {
		$this->nameTable = 'events';
	}
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id]
        );
	}
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID`"
        );
	}
	function selectActive() {
		return DataBase::SQL(
            "SELECT ID, name_event FROM `".$this->nameTable."` WHERE is_active = 1"
        );
	}
	function insert($text) {
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`name_event`) VALUES (?)",
			[$text]
		);
		return $this->getLast();
	}
	
	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
}