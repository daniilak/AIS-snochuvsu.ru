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
	
	function getAllData() {
		$d = $this->select();
		
		$d = array_reverse($d);
		return $d;
	}
	function add(){
		if (!isset($_POST['name'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['name']));
		
		return $d;
	}
	function setConfActive(){
		if (!isset($_POST['new_active'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->set_new_active(intval($_POST['new_active']));
		return ['success'=>true];
	}
	function setConfName(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['conf_name'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->set_conf_name(intval($_POST['id']),$_POST['conf_name']);
		return ['success'=>true];
	}
	function setRecName(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['rec_name'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->set_rec_name(intval($_POST['id']),$_POST['rec_name']);
		return ['success'=>true];
	}
	function removeRec(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->remove_rec(intval($_POST['id']));
		return ['success'=>true];
	}
	function appendRec(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		return $this->append_rec(intval($_POST['id']));
	}
	function setDate(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['val'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['date'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->set_date(intval($_POST['id']),$_POST['val'],$_POST['date']);
		
		
		return ['success'=>true];
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
