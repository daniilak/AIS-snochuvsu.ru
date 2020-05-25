<?php

class RequestsDB {
	
	function __construct() {
		$this->nameTable = 'requests';
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
	function select($id_section, $moder = 0) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `id_section` = ? ". (($moder == 1) ? " AND `is_moderator` = 0 " : "")." ORDER BY `ID`",
            [$id_section]
        );
	}
	function selectListID($id_section) {
		return DataBase::SQL(
            "SELECT `ID` FROM `".$this->nameTable."` WHERE `id_section` = ? ORDER BY `ID`",
            [$id_section]
        );
	}

	function insert($id_section) {
		$idUser = (isset($GLOBALS['user'])) ? $idUser = $GLOBALS['user']['id_vk'] : 0;
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`id_user_who_add`,`id_section`) VALUES (?,?)",
			[$idUser, $id_section],
			false
		);
		return $this->getLast();
	}

	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	
	function selectCountRequests($id_section) {
		return DataBase::SQL(
            "SELECT COUNT(*) as 'count' FROM `".$this->nameTable."` WHERE `id_section` = ?",
            [$id_section]
        );
	}
	function selectCountQueries($id_section) {
		return DataBase::SQL(
            "SELECT COUNT(*) as 'count' FROM `".$this->nameTable."` WHERE `id_section` = ? AND `is_moderator` != 0",
            [$id_section]
        );
	}
	function updateField($key, $value, $id) {
		DataBase::SQL("UPDATE  `".$this->nameTable."` SET `".$key."` = ?  WHERE `ID` = ?;",[$value, $id], false);
	}
	
	
}