<?php

class PositionsDB {
	
	function __construct() {
		$this->nameTable = 'positions';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `name`"
        );
	}
}