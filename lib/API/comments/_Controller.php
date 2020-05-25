<?php
require_once(__DIR__ . '/_DB.php');

class Comments extends CommentsDB {
	
	function getAll() {
		$d = $this->select();
		
		return $d;
	}
	function add(){
		if (!isset($_POST['text'])) {
			$this->withJson(['error'=>'no param']);
		}

		$d = $this->insert($_POST['text']);
		
		return $d;
	}

	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
