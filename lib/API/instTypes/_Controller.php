<?php
require_once(__DIR__ . '/_DB.php');

class InstTypes extends InstTypesDB {
	
	function getAll() {
		$d = $this->select();
		
		return $d;
	}
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
