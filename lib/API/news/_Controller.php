<?php
require_once(__DIR__ . '/_DB.php');

class News extends NewsDB {
	
	function getAll() {
		$d = $this->select();
		
		return $d;
	}
	function add(){
		if (!isset($_POST['text'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['text']));
		
		return $d;
	}
	function remove(){
		if (!isset($_POST['id_news'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['text']));
		
		return ['success'=>true];
	}
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
