<?php

class EventTypesDB {
	
	function __construct() {
		$this->nameTable = 'type_sections';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID`"
        );
	}
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id]
        );
	}
}