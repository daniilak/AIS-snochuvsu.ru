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
	function set_new_active($id) {
		DataBase::SQL("UPDATE `".$this->nameTable."` SET `is_active` = 0;", false, false);
		DataBase::SQL(
            "UPDATE `".$this->nameTable."` SET `is_active` = 1 WHERE `ID` = ?", [$id], false
        );
    }
    function set_conf_name($id, $conf_name) {
		DataBase::SQL(
            "UPDATE `".$this->nameTable."` SET `name_event` = ? WHERE `ID` = ?", [$conf_name, $id], false
        );
    }
    function set_rec_name($id, $rec_name) {
		DataBase::SQL(
            "UPDATE `recommendations` SET `recommendation` = ? WHERE `ID` = ?", [$rec_name, $id], false
        );
    }
    function remove_rec($id) {
		DataBase::SQL(
            "DELETE FROM `recommendations` WHERE `ID` = ?", [$id], false
        );
    }
    function append_rec($id) {
		DataBase::SQL(
            "INSERT INTO `recommendations` (`id_event`) VALUES (?)", [$id], false
        );
        $s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `recommendations` LIMIT 1");
		return DataBase::SQL("SELECT * FROM `recommendations` WHERE `ID` = ? LIMIT 1",[$s[0]['max']]);
    }
    function set_date($id, $val, $type) {
		DataBase::SQL(
            "UPDATE `".$this->nameTable."` SET `".$type."` = ? WHERE `ID` = ?", [$val, $id], false
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