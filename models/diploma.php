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
// require_once(__DIR__ . '/../lib/API/juri/_DB.php'); $juri = new JuriDB();
require_once(__DIR__ . '/../lib/API/conf/_DB.php'); $conf = new ConfDB();
require_once(__DIR__ . '/../lib/API/eventTypes/_DB.php'); $eventTypes = new EventTypesDB();
require_once(__DIR__ . '/../lib/API/facs/_DB.php'); $facs = new FacsDB();
require_once(__DIR__ . '/../lib/API/instTypes/_DB.php');$instTypes = new InstTypesDB();
function getSign($place, $id_fac,$facs) {
	$sign = '
		<div class="row" style="font-size:20px;">
			<div class="col-2"></div><div class="col-3">Ректор</div><div class="col-3"></div><div class="col-3 text-right">А.Ю. Александров</div>
		</div>
		<br>
		<br>
		<div class="row" style="font-size:20px;">
			<div class="col-2"></div><div class="col-4">Научный руководитель СНО</div><div class="col-2"></div><div class="col-3 text-right">А.Н. Захарова</div>
		</div>
	';
	if ($place != 1) {
		$sign = '
			<div class="row" style="font-size:20px;">
				<div class="col-2"></div><div class="col-3">Проректор по научной работе</div><div class="col-3"></div><div class="col-3 text-right">Е.Н. Кадышев</div>
			</div>
			<br>
			<div class="row" style="font-size:20px;">
				<div class="col-2"></div><div class="col-4">Научный руководитель СНО</div><div class="col-2"></div><div class="col-3 text-right">А.Н. Захарова</div>
			</div>
			<br>
			<div class="row" style="font-size:20px;">
				<div class="col-2"></div>
				<div class="col-4">
					'.((intval($id_fac) < 17) ? "Декан " : ((intval($id_fac) == 18) ? "Директор" : "Заведующий кафедрой") )
					.' '.$facs->selectByID($id_fac)[0]['description'].'</div>
				<div class="col-2"></div>
				<div class="col-3 text-right">'.$facs->selectByID($id_fac)[0]['decan'].'</div>
			</div>
		';
	}
	return $sign;
}

function getSups($supervisorsData, $positionsData, $ID) {
		$supArr = [];
		if (count($supervisorsData) > 0) {
			$supStr = ((count($supervisorsData) > 1) ?  "<p>Научные руководители:</p>" :  "<p>Научный руководитель:</p>");
			foreach ($supervisorsData as $skey => $sup) {
				if (in_array($ID, json_decode($sup['id_request'],true))) {
					$posSup = "";
					foreach ($positionsData as $p) {
						if ($p['ID'] == $sup['id_position']){
							$posSup = $p['name'];
							break;
						}
					}
					$supArr []= 
					'<p style="font-size:20px;margin-bottom: 0 !important;">
						<b>'.mb_strtolower($posSup).' '.trim($sup['last_name']).' '.trim($sup['first_name']).' '.trim($sup['middle_name'])
						.', </b>
					</p>';
				}
			}
		}
		return 
			((count($supArr) > 0) 
				? ((count($supArr) > 1) ?  '<p style="margin-bottom: 0 !important;">Научные руководители:</p>' :  '<p style="margin-bottom: 0 !important;">Научный руководитель:</p>').implode("", $supArr)
				: "");
}

$dataEvent = $events->selectByID($idEvent)[0];
$rData = $requests->select($idEvent);

// if ($GLOBALS['user']['id_vk'] != "385818590") {echo "В разработке, осталось совсем чуть-чуть"; die();}
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

// var_dump($dataEvent);

$diplomaArr = ''; $topIndex = 0; $supervisorsData = $supervisors->select($idEvent); $dateArr = explode(" ", $dataEvent['datetime']); $dateArr = explode("-", $dateArr[0]);


foreach ($rData as $rKey => $r) {
	if ($r['place'] == 4) continue;	 $step = "I"; if ($r['place'] == 2) $step = "II"; if ($r['place'] == 3) $step = "III";
	
	// var_dump($dataEvent['id_fac']);
	if (
		$dataEvent['id_type_section'] == 4 
		|| $dataEvent['id_type_section'] == 7
		) {
		echo "Для мероприятий «Встречи» и «Экскурсии» не предусмотрены дипломы."; die(); 
	}
	if ($dataEvent['id_type_section'] == 1 || $dataEvent['id_type_section'] == 6) {
		$str = '<h4 style="margin-bottom: 0 !important;">в '
		.(($dataEvent['id_type_section'] == 1) ? "секции" : "выставке").' «'.$dataEvent['name'].'»</h4><p style="margin-top:5mm;margin-bottom: 0 !important;">
		'.
		(($dataEvent['id_type_section'] == 1) ? "Научная работа" : "Экспонат")
		.':</p><p style="font-size:25px;margin-bottom: 0 !important;"><b>«'.$r['name_project'].'»</b></p>';
		foreach ($members->select($r['ID']) as $mem) {
			$who = "Не выбраны данные у участника";
			if ($mem['is_chuvsu'] == 1) {
				$who ="студент(-ка) ".$mem['course']." курса гр. ".$mem['groupname'].'</h4><h4 style="margin-bottom: 0 !important;">'.((mb_strlen($mem['groupname']) > 0) ? "ФГБОУ ВО «ЧГУ им. И.Н. Ульянова»" : $mem['name_organization']);
				
			} else {
				$who = "участник(-ца) ".$mem['name_organization'].' г. '.$mem['city'];
			}
			$diplomaArr .=$template->templateLoadInString("diploma/section.tpl", [
				"place"=>$step,
				"na"=>"",
				"fio"=> mb_strtoupper(trim($mem['last_name']).' '.trim($mem['first_name']).' '.trim($mem['middle_name'])),
				"who"=>$who,
				"sups"=>getSups($supervisorsData, $positionsData, $r['ID']),
				"str"=>$str,
				"sign"=>getSign($r['place'], $dataEvent['id_fac'],$facs),
				"date"=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0],
				"topIndex_1"=> ($topIndex + 180),
				"topIndex_2"=> ($topIndex + (($r['place'] == 1) ? 317 : 307)),
				"topIndex_3"=> ($topIndex + 380),
				"ID"=>$r['ID'],
				"countPx"=>46,
			]);
			$topIndex = $topIndex + 400;
		}
	}
	if (
		$dataEvent['id_type_section'] == 2 
		|| $dataEvent['id_type_section'] == 3 
		|| $dataEvent['id_type_section'] == 5 
		|| $dataEvent['id_type_section'] == 8
	) {
		$type = "";
		if ($dataEvent['id_type_section'] == 2) $type = "игре";
		if ($dataEvent['id_type_section'] == 3) $type = "олимпиаде";
		if ($dataEvent['id_type_section'] == 5) $type = "квесте";
		if ($dataEvent['id_type_section'] == 8) $type = "конкурсе";
		$str = '<h4>в '.$type.' «'.$dataEvent['name'].'»</h4>';
		$mArr = [];
		foreach ($members->select($r['ID']) as $mem) {
			$who = "Не выбраны данные у участника";
			if ($mem['is_chuvsu'] == 1) {
				$who = "гр. «".$mem['groupname'].'»';
			} else {
				$who = $mem['name_organization'].' г. '.$mem['city'];
			}
			$mArr []= "<b>".mb_strtoupper(trim($mem['last_name']).' '.trim($mem['first_name']).' '.trim($mem['middle_name']))."</b> ".$who;
		}
		$diplomaArr .=$template->templateLoadInString("diploma/section.tpl", [
				"place"=>$step,
				"na"=>"команда",
				"fio"=>$r['name_project'], 
				"who"=>$str,
				"sups"=>getSups($supervisorsData, $positionsData, $r['ID']),
				"str"=>'<p style="font-size:20px;">В составе:<br>'.implode(",<br>", $mArr).'</p>',
				"sign"=>getSign($r['place'], $dataEvent['id_fac'],$facs),
				"date"=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0],
				"topIndex_1"=> ($topIndex + 180),
				"topIndex_2"=> ($topIndex + (($r['place'] == 1) ? 317 : 307)),
				"topIndex_3"=> ($topIndex + 380),
				"ID"=>$r['ID'],
				"countPx"=>46,
		]);
		$topIndex = $topIndex + 400;
	}
	if ($dataEvent['id_type_section'] >= 9) {
		$type = "";
		if ($dataEvent['id_type_section'] == 9) $type = "олимпиаде";
		if ($dataEvent['id_type_section'] == 10) $type = "игре";
		if ($dataEvent['id_type_section'] == 11) $type = "квесте";
		if ($dataEvent['id_type_section'] == 12) $type = "конкурсе";
		$str = '<h4>в '.$type.' «'.$dataEvent['name'].'»</h4><p style="margin-top:5mm;">';
		foreach ($members->select($r['ID']) as $mem) {
			$who = "Не выбраны данные у участника";
			if ($mem['is_chuvsu'] == 1) {
				$who =
					"студент(-ка) "
					.$mem['course']
					." курса гр. "
					.$mem['groupname']
					.'</p><p>'
					.((mb_strlen($mem['groupname']) > 0) ? "ФГБОУ ВО «ЧГУ им. И.Н. Ульянова»" : $mem['name_organization']);
			} else {
				$who = "участник(-ца) ".$mem['name_organization'].' г. '.$mem['city'];
			}
			$diplomaArr .=$template->templateLoadInString("diploma/section.tpl", [
				"place"=>$step,
				"na"=>"",
				"fio"=> mb_strtoupper(trim($mem['last_name']).' '.trim($mem['first_name']).' '.trim($mem['middle_name'])),
				"who"=>$who,
				"sups"=>getSups($supervisorsData, $positionsData, $r['ID']),
				"str"=>$str,
				"sign"=>getSign($r['place'], $dataEvent['id_fac'],$facs),
				"date"=>$dateArr[2].'.'.$dateArr[1].'.'.$dateArr[0],
				"topIndex_1"=> ($topIndex + 180),
				"topIndex_2"=> ($topIndex + (($r['place'] == 1) ? 317 : 307)),
				"topIndex_3"=> ($topIndex + 380),
				"ID"=>$r['ID'],
				"countPx"=>46,
			]);
			$topIndex = $topIndex + 400;
		}
	}
}

if (mb_strlen($diplomaArr) == 0) {
	echo "Не указаны места"; die(); 
}
$template->templateSetVar('table', $diplomaArr);


$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateCompile();
$template->templateDisplay();