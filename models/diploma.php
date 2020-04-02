<?php
Cookies::authCheck();
if (strlen(explode("/",$_GET['route'])[1]) == 0) {
	echo "error";die();
}
$idEvent = explode("/",$_GET['route'])[1];

require_once(__DIR__ . '/../lib/API/events/_DB.php');$events = new EventsDB();
require_once(__DIR__ . '/../lib/API/members/_DB.php'); $members = new MembersDB();
require_once(__DIR__ . '/../lib/API/positions/_DB.php'); $positions = new PositionsDB(); $positionsData = $positions->select();
require_once(__DIR__ . '/../lib/API/requests/_DB.php');$requests = new RequestsDB();
require_once(__DIR__ . '/../lib/API/managers/_DB.php');$managers = new ManagersDB();
require_once(__DIR__ . '/../lib/API/recs/_DB.php'); $recs = new RecsDB();
require_once(__DIR__ . '/../lib/API/supervisors/_DB.php'); $supervisors = new SupervisorsDB();
require_once(__DIR__ . '/../lib/API/juri/_DB.php'); $juri = new JuriDB();
require_once(__DIR__ . '/../lib/API/conf/_DB.php'); $conf = new ConfDB();
require_once(__DIR__ . '/../lib/API/eventTypes/_DB.php'); $eventTypes = new EventTypesDB();
require_once(__DIR__ . '/../lib/API/facs/_DB.php'); $facs = new FacsDB();
require_once(__DIR__ . '/../lib/API/instTypes/_DB.php');$instTypes = new InstTypesDB();


$dataEvent = $events->selectByID($idEvent)[0];
$rData = $requests->select($idEvent);
echo "В разработке, осталось совсем чуть-чуть"; die();
if (count($rData) == 0) { echo "Мероприятие без работ/команд/участников. Ограничение системы"; die(); }
if ($dataEvent['id_type_section'] == 1) { 
	$countPlaces = 0;
	$countPlacesOne = 0;
	foreach ($rData as $r) {
		if ($r['place'] != 4) {
			$countPlaces++;
		}
		if ($r['place'] == 1) {
			$countPlacesOne++; 
		}
		if (mb_strlen($r['name_project']) == 0) {
			echo "Ошибка. Нарушение правила: у Вас названия докладов с пустым названием"; die(); 
		}
	}
	if ($dataEvent['id_disabled_place'] == 0) {
		if ($countPlacesOne > 1) {
			echo "Ошибка. Нарушение правила: первое место только может быть одно"; die(); 
		}
		if ($countPlaces > round(count($rData)*0.3)) {
			echo "Ошибка. Нарушение правила 30%"; die(); 
		}
	}

}

$juriData = $juri->select($idEvent);
$jStr = '';
foreach ($juriData as $j) {

	$posJuri = "";
	foreach ($positionsData as $p) {
		if ($p['ID'] == $j['id_position']){
			$posJuri = $p['name'];
			break;
		}
	}
	if (mb_strlen($j['middle_name']) < 1) {
		echo "Ошибка. У комиссии введены не все данные: нужны полные ФИО"; die(); 
	}
	if (mb_strlen($j['first_name']) < 1) {
		echo "Ошибка. У комиссии введены не все данные: нужны полные ФИО"; die(); 
	}
	$jStr .= '
		 <div class="col-3 text-center">
		    <div class="col-md-12"><p>'.trim($j['last_name']).' '.trim($j['first_name']).' '.trim($j['middle_name']).', '.mb_strtolower($posJuri).'</p></div>
		    <div class="col-md-12"><br><p style="border-top: 1px solid #000;">(подпись)</p></div>
		 </div>';
	
}
$supervisorsData = $supervisors->select($idEvent);


$rStr = ""; 
foreach ($rData as $rKey => $r) {

	// var_dump($members->select($r['ID']));
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
			if (mb_strlen($sup['middle_name']) < 1) {
			echo "Ошибка. У научных руководителей введены не все данные: нужны полные ФИО"; die(); 
			}
			if (mb_strlen($sup['first_name']) < 1) {
				echo "Ошибка. У научных руководителей введены не все данные: нужны полные ФИО"; die(); 
			}
			$sStr []= trim($sup['last_name']).' '.trim($sup['first_name']).' '.trim($sup['middle_name']).', '
				.$posSup;
		}
	}
	$rStr .= '<tr>
		<td>'. ($rKey + 1) .'</td>
		<td>'. $r['name_project'] .'</td>
		<td>'. (($r['place'] != 4) ? $r['place'] : "") . '</td>
        <td>'. ( (count($mStr) > 0) ? implode('<hr style="margin: 0;">', $mStr) : "" ) .'</td>
        <td>'. ( (count($sStr) > 0) ? implode('<hr style="margin: 0;">', $sStr) : "" ) .'</td>
	</tr>';
}

$recStr = "";

foreach ($recs->selectNameListByIDEvent($dataEvent['id_event']) as $recomendation) {

	$recStr .= "<p><b>".$recomendation['recommendation'].":</b></p>";
	$bool = 0;
	foreach ($rData as $r) {
		$checkedRecs = $recs->selectRecomRequestChecked($r['ID'], $recomendation['ID']);
		if (count($checkedRecs) > 0) {
			$recStr .= "<p>".$r['name_project']."</p>";
			$bool = 1;
		} 
	}
	if ($bool == 0) {
		$recStr .= "<p>Не выбрано</p>";
	}
}


$template->templateSetVar('name_conf', $conf->selectByID($dataEvent['id_event'])[0]['name_event']);
$template->templateSetVar('name_fac', mb_strtoupper($facs->selectByID($dataEvent['id_fac'])[0]['full_name']));
$template->templateSetVar('name_type', $eventTypes->selectByID($dataEvent['id_type_section'])[0]['type_n']);

$template->templateSetVar('location', trim($dataEvent['location']));
$template->templateSetVar('name', trim($dataEvent['name']));
$template->templateSetVar('datetime', $dataEvent['datetime']);
$template->templateSetVar('table', $rStr);
$template->templateSetVar('juri', $jStr);
$template->templateSetVar('recStr', $recStr);

$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateCompile();
$template->templateDisplay();