<?php

class ManualDB {
	
	function __construct() {
		$this->nameTable = '';
	}
	function selectUsersList($id) {
		return DataBase::SQL(
            "SELECT `ID`,`id_vk`,`id_role`,`first_name`,`photo` FROM `users` WHERE `id_role` < ? ORDER BY `users`.`first_name` ASC",
            [$id]
        );
	}

	function updateUserRole($id,$id_role) {
		DataBase::SQL(
            "UPDATE `users` 
            SET
            `id_role` = ?
            WHERE `ID` = ?",
            [$id_role,$id],
            false
        );
	}
	
	
	
}