<?php
require_once(__DIR__ . '/_DB.php');
class Users extends UsersDB {
	function getByID() {
		if (!isset($_POST['user_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$user = $this->selectByID(intval($_POST['user_id']));
		
		return $user;
	}
	function getAll() {
		$user = $this->select();
		
		return $user;
	}
	
	function upStatusUser() {
		$user = [];
		
		return $user;
	}
	
	function downStatusUser() {
		$user = [];
		
		return $user;
	}
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
