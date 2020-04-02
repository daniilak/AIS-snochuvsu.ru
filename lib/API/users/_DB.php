<?php

class UsersDB {
	function selectByID($id) {
		return DataBase::SQL(
            "SELECT `ID`, `id_vk`, `id_role`, `first_name` FROM `users` WHERE `ID` = ?",
            [$id]
        );
		
	}
	function select() {
		return DataBase::SQL(
            "SELECT `ID`, `id_vk`, `id_role`, `first_name` FROM `users` ORDER BY `first_name`"
        );
	}
	function updateStatusUser($status) {
		
	}
	
}