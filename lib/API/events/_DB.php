<?php

class EventsDB {
	function __construct() {
		$this->nameTable = 'sections';
	}
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id]
        );
		
	}
	function selectPassByID($id_event) {
		return DataBase::SQL("SELECT `pass` FROM  `".$this->nameTable."`  WHERE `ID` = ?",[$id_event]);
	}
	function selectIdAndName($id_fac) {
		return DataBase::SQL("SELECT `ID`, name FROM  `".$this->nameTable."`  WHERE `id_fac` = ? ORDER BY `name`",[$id_fac]);
	}
	function selectIDConf($id_event) {
		return DataBase::SQL(
            "SELECT `id_event` FROM `".$this->nameTable."` WHERE `ID` = ? ORDER BY `ID`",
            [$id_event]
        )[0]['id_event'];
	}
	
	function select($id_event, $fac, $type, $search, $for = 0) {
		$str = "";
		if ($fac != 1) { $str .= " AND id_fac = ".$fac; }
		if ($type != 0) { $str .= " AND id_type_section = ".$type; }
		if (strlen($search) > 0) { $str .= " AND name LIKE '".$search."%' "; }

		if ($for != "0") { $str .= " AND who LIKE '%".$for."%'"; }
		return DataBase::SQL(
            "SELECT 
            	`".$this->nameTable."`.ID,
            	id_fac,
            	id_type_section,
            	name,
            	datetime,
            	location,
            	description,
            	`".$this->nameTable."`.`phone`,
            	`".$this->nameTable."`.secretary_vk_id as vk_id,
            	users.first_name as fName
            	FROM `".$this->nameTable."`
            	LEFT JOIN users
            	ON users.id_vk = secretary_vk_id
            	WHERE `id_event` = ? ". $str ." ORDER BY `name`",
            [$id_event]
        );
	}
	
	function insert($data) {
		DataBase::SQL(
            "INSERT INTO `".$this->nameTable."` (`secretary_vk_id`,`id_event`,`id_fac`,`id_type_section`,`name`,`datetime`,`location`,`pass`) VALUES (?,?,?,?,?,?,?,?)",
			$data,
			false
        );
        
        $id = $this->getLast();
        for ($i = 1; $i <= 3; $i++) { 
			DataBase::SQL("INSERT INTO `managers` (`id_section`,`type_manager`) VALUES (?,?)", [$id, $i],false);
		}
		
		return $id;
	}
	
	function deleteByID($id) {
		DataBase::SQL("DELETE FROM  `".$this->nameTable."` WHERE `ID` = ?;",[$id], false);
	}
	function updateEvent($key, $value, $id) {
		DataBase::SQL("UPDATE  `".$this->nameTable."` SET `".$key."` = ?  WHERE `ID` = ?;",[$value, $id], false);
	}
	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	function getCountNotChuvsu($id) {
		$s = DataBase::SQL("SELECT COUNT(*) as `c`
			FROM `requests`
			INNER JOIN `users_sections`
			ON `users_sections`.`id_request` = `requests`.`ID`
			WHERE `requests`.`ID` = ? AND `users_sections`.`name_organization` != 'ФГБОУ ВО «ЧГУ им. И.Н. Ульянова»'
			GROUP BY `users_sections`.`name_organization`",
			[$id]);
		if (isset($s[0])) {
			return true;
		}

		return false;
	}
	
	
	
	
}