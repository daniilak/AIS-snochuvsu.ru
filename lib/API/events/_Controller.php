<?php
require_once(__DIR__ . '/_DB.php');
require_once(__DIR__ . '/../requests/_DB.php');
require_once(__DIR__ . '/../managers/_DB.php');

class Events extends EventsDB {
	
	function getByID() {
		
		if (!isset($_POST['event_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$id = intval($_POST['event_id']);
		
		$data = $this->selectByID(intval($_POST['event_id']));
		if (!isset($data[0])) {
			return false;
		} else {
			$data = $data[0];
		}
		
		if ($GLOBALS['user']['id_role'] < 2 ) {
			if (!isset($_SESSION) || empty($_SESSION['code_sect_'.$id]) || $_SESSION['code_sect_'.$id] != "Done") {
				$answer = [
					"name"=> $data['name'],
					"needPass"=>1
				]; 
				return $answer;
			}
			$data['pass'] = null;
		}
		$data['needPass'] = 0;
		return $data;
	}
	
	function getForReplace() {
		if (!isset($_POST['id_fac'])) {
			$this->withJson(['error'=>'no param']);
		}
		return $this->selectIdAndName(intval($_POST['id_fac']));
	}
	function getAll() {
		if (!isset($_POST['conf_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_fac'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_type'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_search'])) {
			$this->withJson(['error'=>'no param']);
		}
		
		$r = new RequestsDB();
		$man = new ManagersDB();
		$data = $this->select(intval($_POST['conf_id']), intval($_POST['filter_fac']), intval($_POST['filter_type']), $_POST['filter_search']);
		$answer = [];
		foreach ($data as $key => $d) {
			$answer[] = $d;
			$answer[$key]["c1"] = $r->selectCountRequests($d['ID'])[0]['count'];
			$answer[$key]["c2"] = $man->selectCountManagers($d['ID'])[0]['count'];
			$answer[$key]["c3"] = $r->selectCountQueries($d['ID'])[0]['count'];
		}
		
		return $answer;
	}
	
	function getAllByDate() {
		if (!isset($_POST['conf_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_fac'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_type'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['filter_search'])) {
			$this->withJson(['error'=>'no param']);
		}
		$filter_for = (!isset($_POST['filter_for'])) ? 0 : $_POST['filter_for'];

		
		$r = new RequestsDB();
		$man = new ManagersDB();
		$data = $this->select(
			intval($_POST['conf_id']),
			intval($_POST['filter_fac']),
			intval($_POST['filter_type']),
			$_POST['filter_search'],
			$filter_for
		);
		$answer = [];
		foreach ($data as $key => $d) {
			
			$date = explode(" ", $d["datetime"])[0];
			if (!isset($answer[$date])) {
				$answer[$date] = [];
			}
			$d["m1"] = $man->selectGreatManagers($d['ID'])[0];
			$d["m2"] = $man->selectGreatManagers($d['ID'])[0];
			
			$answer[$date][] = $d;
		}
		
		return $answer;
	}
	
	
	function pass(){
		if (!isset($_POST['pass'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['id_event'])) {
			$this->withJson(['error'=>'no param']);
		}
		$request = $this->selectPassByID($_POST['id_event']);
		if (isset($request[0]) && $request[0]['pass'] == trim($_POST['pass'])) {
			$_SESSION['code_sect_'.$_POST['id_event']] = "Done";
			return ['done' => '1'];
		}
		return ['done' => '2'];
		
	}
	
	function update() {
		if (!isset($_POST['key'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['value'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['event_id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->updateEvent($_POST['key'], $_POST['value'], $_POST['event_id']);
		return ['done' => true];
	}
	function placeDis() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['checked'])) {
			$this->withJson(['error'=>'no param']);
		}
		if ($this->getCountNotChuvsu($_POST['id'])) {
			$this->updateEvent("id_disabled_place", intval($_POST['checked']), $_POST['id']);
			return ['data' => true];	
		}
		return ['data' => false];
	}
	
	
	function remove() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->deleteByID(intval($_POST['id']));
		return ['data' => true];
	}
	
	function append(){
		if (!isset($_POST['name'])
			|| !isset($_POST['conf-id'])
			|| !isset($_POST['fac'])
			|| !isset($_POST['date'])
			|| !isset($_POST['pass'])
			|| !isset($_POST['location'])
			|| !isset($_POST['type'])
			) {
			$this->withJson(['error'=>'no param']);
		}

		$data = [$GLOBALS['user']['id_vk'],intval($_POST['conf-id']), intval($_POST['fac']), intval($_POST['type']), trim($_POST['name']), intval($_POST['date']),trim($_POST['location']),trim($_POST['pass'])];
		$d = $this->insert($data);
		
		return $d;
	}
	
	
	function withJson($arr){
		echo json_encode($arr);
		exit();
	}
}
