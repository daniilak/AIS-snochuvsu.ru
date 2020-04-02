<?php
require_once(__DIR__ . '/_DB.php');
class SuperVisors extends SuperVisorsDB {
	
	function getByID() {
		if (!isset($_POST['request_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->selectByID(intval($_POST['request_id']));
		
		return $d;
	}
	function getAll() {
		if (!isset($_POST['event_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$data = $this->select(intval($_POST['event_id']));

		
		return $data;
	}
	
	function update() {
		if (!isset($_POST['key'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['value'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->updateField($_POST['key'], $_POST['value'], $_POST['id']);
		return ['done' => true];
	}
	
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
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
