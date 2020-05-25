<?php

class CommentsDB {
	
	function __construct() {
		$this->nameTable = 'comments';
	}
	
	function select() {
		return DataBase::SQL(
            "SELECT 
            `".$this->nameTable."`.`id_user`,
            `".$this->nameTable."`.`text`,
            `users`.`first_name`,
            `users`.`photo`,
            `users`.`ID`
            FROM `".$this->nameTable."`
            INNER JOIN `users` ON `".$this->nameTable."`.`id_user` = `users`.`id_vk`
            ORDER BY `".$this->nameTable."`.`ID` ASC"
        );
	}
	function insert($text) {
		DataBase::SQL(
			"INSERT INTO `".$this->nameTable."`  (`id_user`, `text`) VALUES (?,?)",
			[ $GLOBALS['user']['id_vk'] ,$text],
			false
		);
		return $this->getLast();
	}
	
	function getLast() {
		$s = DataBase::SQL("SELECT MAX(`ID`) AS `max` FROM `".$this->nameTable."` LIMIT 1");
		return $s[0]['max'];
	}
	
	
}