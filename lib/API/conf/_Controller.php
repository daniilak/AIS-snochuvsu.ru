<?php
require_once(__DIR__ . '/_DB.php');

class Conf extends ConfDB {
	
	function getActive() {
		$d = $this->selectActive()[0];
		
		return $d;
	}
	
	function getAll() {
		$d = $this->select();
		
		return $d;
	}
	function add(){
		if (!isset($_POST['name'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['name']));
		
		return $d;
	}
	function remove(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['id']));
		
		return ['success'=>true];
	}
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
