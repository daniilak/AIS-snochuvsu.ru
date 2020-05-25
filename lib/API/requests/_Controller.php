<?php
require_once(__DIR__ . '/_DB.php');
require_once(__DIR__ . '/../members/_DB.php');
require_once(__DIR__ . '/../supervisors/_DB.php');
require_once(__DIR__ . '/../recs/_DB.php');

class Requests extends RequestsDB {
	
	
	function sendRequest() {
		if (!isset($_POST['name_project'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['members'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['leaders'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['idsec'])) {
			$this->withJson(['error'=>'no param']);
		}
		$IDEv = intval($_POST['idsec']);
		$d = $this->insert($IDEv);
		$data = $this->selectByID($d);
		
		$name = trim(strip_tags($_POST['name_project']));
		$this->updateField("name_project", $name, $d);
		$this->updateField("is_moderator", 1, $d);
		$mem = new MembersDB();
		
		$sup = new SuperVisorsDB();
		$members = json_decode($_POST['members'],true);
		foreach($members as $member) {
			$mId = $mem->insert($d);
			$lFN = trim($member['lN']);
			$lFNAr = explode(" ", $lFN);
			$lFN = $lFNAr[0];
			// var_dump($member['inst']);
			$parse = $mem->parseLKCHUVSU(
				$mId,
				$member['inst'],
				$lFN,
				trim($member['num']),
				$member['b'],
				$member['fN'],
				$member['mN'],
				$member['city'],
				$member['n_o'],
				$member['phone']
			);
			if ($parse[0] == 1) {
				return ['answer'=> 1];
			}
		}
		$leaders = json_decode($_POST['leaders'],true);
		foreach($leaders as $leader) {
			$idLead = $sup->insert($IDEv);
			// var_dump($idLead);
			$sup->updateField("id_request", "[".$d."]", $idLead);
			$sup->updateField("first_name", $leader['fN'], $idLead);
			$sup->updateField("last_name", $leader['lN'], $idLead);
			$sup->updateField("middle_name", $leader['mN'], $idLead);
			$sup->updateField("id_position", $leader['pos'], $idLead);
		}
		
		
		
		return ['answer'=> 0];
	}
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
		$answer = [];
		$mem = new MembersDB();
		foreach ($data as $key => $d) {
			$answer[$key] = $d;
			$answer[$key]['members'] = $mem->select($d['ID']);
		}
		
		return $answer;
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
		$key = $_POST['key'];
		if ($key == "r_name") {
			$this->updateField("name_project", trim($_POST['value']), $_POST['id']);
		} else {
			$this->updateField($key, trim($_POST['value']), $_POST['id']);
		}
		return ['done' => true];
	}
	
	function setPlace() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['place'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->updateField('place', $_POST['place'], $_POST['id']);

		return ['done' => true];
	}
	
	function moderator() {
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$this->updateField('is_moderator', 0, $_POST['id']);

		return ['done' => true];
	}
	
	
	
	
	function append(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$d = $this->insert($_POST['id']);
		$data = $this->selectByID($d);
		$answer = [];
		$recs = new RecsDB();
		$recs->selectNameListByIDEvent($d);
		foreach ($recs->selectNameListByIDEvent($d) as $rec) {
			$recs->appendRecomRequest($rec['ID'], $d);
		}
		$mem = new MembersDB();
		foreach ($data as $key => $d) {
			$answer[$key] = $d;
			$answer[$key]['members'] = $mem->select($d['ID']);
		}
		
		return $answer;
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
	function getList(){
		if (!isset($_POST['id'])) {
			$this->withJson(['error'=>'no param']);
		}
		$rData = $this->select($_POST['id'], 1);
		require_once(__DIR__ . '/../positions/_DB.php'); $positions = new PositionsDB(); $positionsData = $positions->select();
		require_once(__DIR__ . '/../supervisors/_DB.php'); $supervisors = new SupervisorsDB();
		$supervisorsData = $supervisors->select($_POST['id']);
		$members = new MembersDB();
		if (count($rData) == 0) {
			return ['data'=>"<center><p><b>".$this->selectCountQueries($_POST['id'])[0]['count']."</b>  заявки(ок) на модерации </p><p>Ещё нет участников...</p></center>"];
			die();
		}
		
		$rStr = ""; 
		foreach ($rData as $rKey => $r) {
			$mStr = [];
			foreach ($members->select($r['ID']) as $mem) {
				$mStr []= trim($mem['last_name']).' '.trim($mem['first_name']).' '.trim($mem['middle_name']).', '
					.$mem['groupname'];
			}
			$sStr = [];
			foreach ($supervisorsData as $sup) {
				if (in_array($r['ID'], json_decode($sup['id_request'],true))) {
					$posSup = "";
					foreach ($positionsData as $p) {
						if ($p['ID'] == $sup['id_position']){
							$posSup = $p['name'];
							break;
						}
					}
					$sStr []= trim($sup['last_name']).' '.trim($sup['first_name']).' '.trim($sup['middle_name']).', '
						.mb_strtolower($posSup);
				}
			}
			$rStr .= '<p>№'
				. ($rKey + 1) 
				.' <b>«'
				. $r['name_project'] 
				.'»</b> <b>'
				. (($r['place'] != 4) 
					? '<span data-toggle="tooltip" title="" class="badge bg-green">'.$r['place'].' место </span>'
					: "") 
				. '</b> '
				. ( (count($mStr) > 0) ? implode(', ', $mStr) : "" ) 
				.' '. ( (count($sStr) > 0) ? ' Руководитель(-и): '.implode(', ', $sStr) : "" ) 
				.';</p>';
		}
		
		return ['data'=>$rStr];
	}
	
	function replace() {
		if (!isset($_POST['id_old_event'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['id_event'])) {
			$this->withJson(['error'=>'no param']);
		}
		if (!isset($_POST['id_request'])) {
			$this->withJson(['error'=>'no param']);
		}
		require_once(__DIR__ . '/../supervisors/_DB.php');
		$supervisors = new SuperVisorsDB();
		$idReq = $_POST['id_request'];
		$sData = $supervisors->select($_POST['id_old_event']);
		if (count($sData) > 0) {
			foreach ($sData as $s) {
				$supReq = json_decode($s['id_request'],true);
				if (count($supReq) > 0) {
					$tmp = [];
					foreach($supReq as $su) {
						if ($su == $idReq) {
							$newIDSup = $supervisors->insert($_POST['id_event']);
							$supervisors->updateField("id_request", "[".$su."]", $newIDSup);
							$supervisors->updateField("first_name", $s['first_name'], $newIDSup);
							$supervisors->updateField("last_name", $s['last_name'], $newIDSup);
							$supervisors->updateField("middle_name",$s['middle_name'], $newIDSup);
							$supervisors->updateField("id_position", $s['id_position'], $newIDSup);
						} else {
							$tmp [] = $su;
						}
					}
				}
			}
		}
		
		$this->updateField("place", "4", $_POST['id_request']);
		$this->updateField("id_section", $_POST['id_event'], $_POST['id_request']);
		return ['data'=>true];
	}
}
