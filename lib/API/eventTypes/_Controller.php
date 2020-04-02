<?php
require_once(__DIR__ . '/_DB.php');

class EventTypes extends EventTypesDB {
	
	function getAll() {
		$d = $this->select();
		
		return $d;
	}
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
