<?php
require_once(__DIR__ . '/_DB.php');
class Manual extends ManualDB {
	
	function getUsersList(){
		return $this->selectUsersList($GLOBALS['user']['id_role']);
	}
	
	function updateUserMode() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['new_role'])) {
			$this->withJson(['error'=>'no param']);
		}
		if ($GLOBALS['user']['id_role'] <= $_POST['new_role']) {
			$this->updateUserRole($_POST['id'],  $_POST['new_role']);
			return ['done' => true];	
		} 
	}

	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
