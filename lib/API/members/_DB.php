<?php

class MembersDB {
	
	function __construct() {
		$this->nameTable = 'users_sections';
	}
	function deleteByID($id) {
		return DataBase::SQL(
            "DELETE FROM `".$this->nameTable."` WHERE `ID` = ?",
            [$id],
            false
        );
	}
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `ID` = ? ORDER BY `ID`",
            [$id]
        );
	}
	function select($id_section) {
		return DataBase::SQL(
            "SELECT * FROM `".$this->nameTable."` WHERE `id_request` = ? ORDER BY `ID`",
            [$id_section]
        );
	}
	function insert($id) {
		$idUser = (isset($GLOBALS['user'])) ? $idUser = $GLOBALS['user']['id_vk'] : 0;
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`id_user_who_add`,`id_request`) VALUES (?,?)",
			[$idUser, $id],
			false
		);
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
	
		return $this->getLast();
	}
	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	
	function selectCountMembers($id_section) {
		return DataBase::SQL(
            "SELECT COUNT(*) as 'count' FROM `".$this->nameTable."` WHERE `id_section` = ?",
            [$id_section]
        );
	}
	function parseLKCHUVSU($id, $idTypeInst, $lName,$num_student, $b,  $fname, $mname, $cityOrg, $nameOrg, $phone) {
    	if ($idTypeInst == 0) {
    		$isChuvsu = 1;
	    	$record = Ref::student_info($num_student,trim($lName));
	    	// var_dump($record);
	    	if (isset($record['record'])) {
	    		$record = (isset($record['record'][0])) ? $record['record'][count($record['record']) - 1]  : $record['record'];
				$fam = (is_array($record['fam'])) ? implode(" ", $record['fam']) : $record['fam'];
				$nam = (is_array($record['nam'])) ? implode(" ", $record['nam']) : $record['nam'];
				$oth = (is_array($record['oth'])) ? implode(" ", $record['oth']) : $record['oth'];
				if (is_array($record['groupname'])) {
					$record['groupname'] = '';
				}
				$this->updateData(
					$id,
					$idTypeInst,
					$fam, // $lName
					$nam, // $fname
					$oth, // $mname
					$num_student,
					$b,
					$cityOrg,$nameOrg,
					$phone,
					$isChuvsu,
					$record['faculty_id'],$record['groupname'],$record['course'],$record['level']
				);
				return ["0", $id,$idTypeInst,$fam,$nam, $oth,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,
					$record['faculty_id'],$record['groupname'],$record['course'],$record['level']
				];
	    	} else {
	    		$this->updateData($id,$idTypeInst,$lName,$fname,$mname,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,0,"",0,"");
	    		return ["1", $id,$idTypeInst,$lName,$fname,$mname,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,0,"",0,""];
	    	}
    	} else {
    		$isChuvsu = 0;
    		$this->updateData($id,$idTypeInst,$lName,$fname,$mname,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,0,"",0,"");
    		return ["2", $id,$idTypeInst,$lName,$fname,$mname,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,0,"",0,""];
    	}
    }

	function updateData($id,$idTypeInst,$lName,$fname,$oth,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,$fID,$gr,$c,$lev) {
		DataBase::SQL(
            "UPDATE `".$this->nameTable."` 
            SET
            `id_type_inst` = ?,
            `last_name` = ?,
            `first_name` = ?,
            `middle_name` = ?,
            `num_student` = ?,
            `stip` = ?,
            `city` = ?,
            `name_organization` = ?,
            `phone` = ?,
            `is_chuvsu` = ?,
            `faculty_id` = ?,
            `groupname` = ?,
            `course` = ?,
            `level` = ?
            WHERE `ID` = ?",
            [$idTypeInst,trim($lName),$fname,$oth,$num_student,$b,$cityOrg,$nameOrg,$phone,$isChuvsu,$fID,$gr,$c,$lev, $id],
            false
        );
	}
	
	
	
}