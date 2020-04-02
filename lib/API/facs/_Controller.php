<?php
require_once(__DIR__ . '/_DB.php');

class Facs extends FacsDB {
	
	function getByID() {
		if (!isset($_POST['fac_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->selectByID(intval($_POST['fac_id']));
		
		return $d;
	}
	function getAll() {
		
		$d = $this->select();
		
		return $d;
	}
	
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
