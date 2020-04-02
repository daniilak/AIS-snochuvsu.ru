<?php
require_once(__DIR__ . '/_DB.php');
class Members extends MembersDB {
	
	function append(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert($_POST['id']);
	
		return $this->selectByID($d);
	}
	function remove() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		
		$this->deleteByID($_POST['id']);
		
		return ['done' => true];
	}
	function update() {
		if (!isset($_POST['id']) 
			|| !isset($_POST['typeInst'])
			|| !isset($_POST['lname'])
			|| !isset($_POST['num_stud'])
			|| !isset($_POST['stip'])
			|| !isset($_POST['fname'])
			|| !isset($_POST['mname'])
			|| !isset($_POST['city'])
			|| !isset($_POST['name_org'])
			|| !isset($_POST['phone'])) {
			$this->withJson(['error'=>'no param']);
		}
		return $this->parseLKCHUVSU(
			$_POST['id'],intval($_POST['typeInst']),trim($_POST['lname']),trim($_POST['num_stud']),intval($_POST['stip']),trim($_POST['fname']),trim($_POST['mname']),trim($_POST['city']),trim($_POST['name_org']),trim($_POST['phone'])
		);
		
	}
	
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
