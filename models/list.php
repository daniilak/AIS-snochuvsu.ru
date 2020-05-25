<?php
Cookies::authCheck();
require_once('lib/Stats.php');

$box = '<br><table id="example" style="width:100%" class="display">
<thead><tr>
<td>Название секции</td>
<td>Дата</td>
<td>Место</td>
<td>Факультет</td>
<td>Тип секции</td>
<td>Название работы</td>
<td>Место</td>
<td>%</td>
<td>Фамилия</td>
<td>Имя</td>
<td>Отчество</td>
<td>Откуда</td>
<td>Организация</td>
<td>Город</td>
<td>Б/К</td>
<td>Группа</td>
<td>Уровень</td>
<td></td>
</tr></thead> <tbody>';


$data = DataBase::SQL("
	SELECT 
	`requests`.`ID`,
	`sections`.`name`,
	`sections`.`datetime`,
	`sections`.`location`,
	`facs`.`full_name`,
	`type_sections`.`type`,
	`requests`.`name_project`,
	IF(`requests`.`place` = 4 ,'', `requests`.`place`) as `place`
	FROM `sections`
	INNER JOIN `requests` ON `requests`.`id_section` = `sections`.`ID`
	INNER JOIN `type_sections` ON `type_sections`.`ID` = `sections`.`id_type_section`
	INNER JOIN `facs` ON `facs`.`ID` = `sections`.`id_fac`
	WHERE `sections`.`id_event` = 5 AND `requests`.`is_moderator` = 0");
foreach($data as $d) {
	$users = DataBase::SQL("
		SELECT 
		`users_sections`.`last_name`,
		`users_sections`.`first_name`,
		`users_sections`.`middle_name`,
		`user_types_inst`.`type` as `type_in`,
		`users_sections`.`num_student`,
		`users_sections`.`name_organization`,
		`users_sections`.`city`,
		IF(`users_sections`.`stip` = 1 ,'Бюджет', 'Контракт') as `stip`,
		`users_sections`.`groupname`,
		`users_sections`.`level`
		FROM `users_sections`
		INNER JOIN `user_types_inst` ON  `users_sections`.`id_type_inst` = `user_types_inst`.`ID`
		
		WHERE `users_sections`.`id_request`= ?", [$d['ID']]);
	foreach($users as $u) {
	
		$box .= "<tr>
			<td>".$d['name']."</td>
			<td>".$d['datetime']."</td>
			<td>".$d['location']."</td>
			<td>".$d['full_name']."</td>
			<td>".$d['type']."</td>
			<td>".$d['name_project']."</td>
			<td>".$d['place']."</td>
			<td>".round(1/count($users), 2)."</td>
			
			<td>".$u['last_name']."</td>
			<td>".$u['first_name']."</td>
			<td>".$u['middle_name']."</td>
			<td>".$u['type_in']."</td>
			<td>".$u['num_student']."</td>
			<td>".$u['name_organization']."</td>
			<td>".$u['city']."</td>
			<td>".$u['stip']."</td>
			<td>".$u['groupname']."</td>
			<td>".$u['level']."</td>
		</tr>";
	}
}
$box .=' </tbody></table>';
$template->templateSetVar('content',  $box );


$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateSetVar('name_role', Cookies::getNameUserRole());
$template->templateCompile();
$template->templateDisplay();