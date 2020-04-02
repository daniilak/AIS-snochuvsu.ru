<?php

class FacsDB {
	
	function __construct() {
		$this->nameTable = 'facs';
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
}