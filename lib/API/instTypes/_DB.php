<?php

class InstTypesDB {
	
	function __construct() {
		$this->nameTable = 'user_types_inst';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID`"
        );
	}
}