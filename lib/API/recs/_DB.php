<?php

class RecsDB {
	
	function __construct() {
		$this->nameTable = 'recommendations';
	}
	
	function selectNameListByIDEvent($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `id_event` = ?",
            [$id]
        );
	}
	function appendRecomRequest($idRec, $idEv) {
		return DataBase::SQL(
            "INSERT INTO `recom_request` (`id_request`, `id_recom`) VALUES (?, ?)",
            [$idRec, $idEv],
            false
        );
	}

	function selectRecomRequestChecked($idRec, $idEv) {
		return DataBase::SQL(
            "SELECT * FROM `recom_request` WHERE `id_request` = ? AND `id_recom` = ? AND `checked` = 1",
            [$idRec, $idEv]
        );
	}
	function updateRecomRequest($val, $idRec, $idEv) {
		$t = DataBase::SQL(
            "SELECT * FROM  `recom_request`  WHERE `id_request` = ? AND `id_recom` = ?",
            [$idRec, $idEv]
        );
        if (!isset($t[0])) {
        	DataBase::SQL(
	            "INSERT INTO `recom_request` (`id_request`, `id_recom`) VALUES (?, ?)",
	            [$idRec, $idEv],
	            false
	        );
        }
		return DataBase::SQL(
            "UPDATE `recom_request` SET `checked` = ?  WHERE `id_request` = ? AND `id_recom` = ?",
            [$val, $idRec, $idEv],
            false
        );
	}
	function getRecomInnerRequest($id) {
		return DataBase::SQL(
            "SELECT `recom_request`.`id_request`, `recom_request`.`id_recom`, `recom_request`.`checked`
			FROM `requests`
			INNER JOIN `recom_request` ON `requests`.`ID` = `recom_request`.`id_request`
			WHERE `requests`.`id_section` = ? AND `checked` = 1",
            [$id]
        );
	}
	function getRecomAllInnerRequest($id) {
		return DataBase::SQL(
            "SELECT `recom_request`.`id_request` as `id`
			FROM `requests`
			INNER JOIN `recom_request` ON `requests`.`ID` = `recom_request`.`id_request`
			INNER JOIN `sections` ON `requests`.`id_section` = `sections`.`ID`
			WHERE `requests`.`id_section` = ?",
            [$id]
        );
	}
	
	
	

	function selectByIDEvent($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` ORDER BY `ID`",
            [$id]
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