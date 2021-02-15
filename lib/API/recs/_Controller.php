<?php
require_once(__DIR__ . '/_DB.php');
require_once(__DIR__ . '/../events/_DB.php');
require_once(__DIR__ . '/../requests/_DB.php');
class Recs extends RecsDB {
	
	function get() {
		if (!isset($_POST['id_event'])) {
			$this->withJson(['error'=>'no param']);
		}
		$ev = new EventsDB();
		$idConf = $ev->selectIDConf($_POST['id_event']);
		$list = $this->selectNameListByIDEvent($idConf);
		
		$d = $this->getRecomInnerRequest($_POST['id_event']);
		$checked = [];
		foreach ($this->getRecomInnerRequest($_POST['id_event']) as $recs) {
			$checked[$recs['id_recom']][] = $recs['id_request'];
		}
		//
		$checkedAnswer = [];
		foreach ($checked as $key => $check) {
			$checkedAnswer[$key] = '['.implode(",",$check).']';
		}
		
		return ['list'=>$list, 'checked'=>$checked];
	}
	function getAll() {
		
		$ev = new EventsDB();

		return ['data'=>$ev->getAllRecoms()];

	}
	function update() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['value'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['id_event'])) {
			$this->withJson(['error'=>'no param']);
		}
		$val = json_decode($_POST['value'], true);
		$idRec = intval($_POST['id']);
		$re = new RequestsDB();
		$recs = $re->selectListID($_POST['id_event']);
		if (count($recs) > 0 )
			foreach ($recs as $rec) {
				$this->updateRecomRequest(0, $rec['ID'],$idRec);
				foreach($val as $v) {
					
					 $this->updateRecomRequest(1, $v,$idRec);
				}
			}
		
		return ['data'=>true];
		
	}
	
	function add(){
		return "no";
		if (!isset($_POST['text'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert(intval($_POST['text']));
		
		return $d;
	}
	function remove(){
		return "no";
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
