<?php

class SuperVisorsDB {
	
	function __construct() {
		$this->nameTable = 'leaders';
	}
	
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id]
        );
	}
	function deleteByID($id) {
		DataBase::SQL(
            "DELETE FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id],
            false
        );
	}
	function select($id_section) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `id_section` = ? ORDER BY `ID`",
            [$id_section]
        );
	}
	function insert($id_section) {
		$userID = (isset($GLOBALS['user'])) ? $GLOBALS['user']['id_vk'] : 1;
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`id_user_who_add`,`id_section`) VALUES (?,?)",
			[1, $id_section],
			false
		);
		return $this->getLast();
	}

	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	
	function selectCountSuperVisors($id_section) {
		return DataBase::SQL(
            "SELECT COUNT(*) as 'count' FROM `".$this->nameTable."` WHERE `id_section` = ?",
            [$id_section]
        );
	}

	function updateField($key, $value, $id) {
		DataBase::SQL("UPDATE  `".$this->nameTable."` SET `".$key."` = ?  WHERE `ID` = ?;",[trim($value), $id], false);
	}
	
	
}