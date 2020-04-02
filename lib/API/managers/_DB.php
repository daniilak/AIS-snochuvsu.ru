<?php

class ManagersDB {
	
	function __construct() {
		$this->nameTable = 'managers';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID`"
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
	
	function selectCountManagers($id_section) {
		return DataBase::SQL(
            "SELECT COUNT(*) as 'count' FROM `".$this->nameTable."` WHERE `id_section` = ?",
            [$id_section]
        );
	}
	function selectGreatManagers($id_section) {
		return DataBase::SQL(
            "SELECT CONCAT(`last_name`, ' ', `first_name`, ' ', `middle_name`) as `fio`, `id_position` FROM `".$this->nameTable."` WHERE `id_section` = ? AND `type_manager` != 3",
            [$id_section]
        );
	}
	
	
}