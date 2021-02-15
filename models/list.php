<?php
Cookies::authCheck();
require_once('lib/Stats.php');
$box = '
<div class="row mb-3"><div class="col-md-3 form-group">
<select class="form-control boxed list_fac">
<option value="1">Все факультеты</option><option value="2">Факультет иностранных языков</option><option value="3">Факультет информатики и вычислительной техники</option><option value="4">Факультет искусств</option><option value="5">Историко-географический факультет</option><option value="6">Машиностроительный факультет</option><option value="7">Медицинский факультет</option><option value="8">Факультет прикладной математики, физики и информационных технологий</option><option value="9">Факультет радиоэлектроники и автоматики</option><option value="10">Факультет русской и чувашской филологии и журналистики</option><option value="11">Строительный факультет</option><option value="12">Факультет управления и социальных технологий</option><option value="13">Химико-фармацевтический факультет</option><option value="14">Экономический факультет</option><option value="15">Факультет энергетики и электротехники</option><option value="16">Юридический факультет</option><option value="17">Кафедра физической культуры и спорта</option><option value="18">Алатырский филиал</option>
</select>
</div>
<div class="col-md-3 form-group"><select  class="form-control boxed list_type">
<option value="0">Все типы</option><option value="1">Секции</option><option value="2">Игры (командные)</option><option value="3">Олимпиады (командные)</option><option value="4">Встречи</option><option value="5">Квесты  (командные)</option><option value="6">Выставки</option><option value="7">Экскурсии</option><option value="8">Конкурсы  (командные)</option><option value="9">Олимпиады (одиночные)</option><option value="10">Игры (одиночные)</option><option value="11">Квесты (одиночные)</option><option value="12">Конкурсы (одиночные)</option>
</select>
</div>
</div>
<div class="form-group">
                  <div class="checkbox"><label><input type="checkbox">Checkbox 1</label></div>
                  <div class="checkbox"><label><input type="checkbox">Checkbox 1</label></div>
                  <div class="checkbox"><label><input type="checkbox">Checkbox 1</label></div>
                  <div class="checkbox"><label><input type="checkbox">Checkbox 1</label></div>
                </div>
                <a href="?list" class="btn btn-info" role="button">Загрузить список</a>';
if (isset($_GET['list'])) {
	

	$box .= '<br><table id="example" style="width:100%" class="display">
	<thead><tr>
	<td>Название секции</td>
	<td>Дата</td>
	<td>Место</td>
	<td>Факультет</td>
	<td>Тип секции</td>
	<td>Название работы</td>
	<td>Место</td>
	<td>%</td>
	<td>ФИО</td>
	<td>Откуда</td>
	<td>Зачетка</td>
	<td>Организация</td>
	<td>Город</td>
	<td>Б/К</td>
	<td>Группа</td>
	<td>Уровень</td>
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
		WHERE `sections`.`id_event` = 6 AND `requests`.`is_moderator` = 0");
	foreach($data as $d) {
		// `user_types_inst`.`type` as `type_in`,
		// INNER JOIN `user_types_inst` ON  `users_sections`.`id_type_inst` = `user_types_inst`.`ID`
		$users = DataBase::SQL("
			SELECT 
			`users_sections`.`last_name`,
			`users_sections`.`first_name`,
			`users_sections`.`middle_name`,
			IFNULL(`user_types_inst`.`type`, 'ЧувГУ') as `type_in`,
			`users_sections`.`num_student`,
			`users_sections`.`name_organization`,
			`users_sections`.`city`,
			IF(`users_sections`.`stip` = 1 ,'Бюджет', 'Контракт') as `stip`,
			`users_sections`.`groupname`,
			`users_sections`.`level`
			FROM `users_sections`
			
			LEFT JOIN `user_types_inst` ON  `users_sections`.`id_type_inst` = `user_types_inst`.`ID`
			WHERE `users_sections`.`id_request`= ?", [$d['ID']]);
	
		foreach($users as $u) {
			$num_student  = ((strlen($u['num_student']) > 0) ? $u['num_student'] : "-");
			$name_organization  = ((strlen($u['name_organization']) > 0) ? $u['name_organization'] : "-");
			$city  = ((strlen($u['city']) > 0) ? $u['city'] : "-");
			$box .= "<tr>
				<td>".$d['name']."</td>
				<td>".$d['datetime']."</td>
				<td>".$d['location']."</td>
				<td>".$d['full_name']."</td>
				<td>".$d['type']."</td>
				<td>".$d['name_project']."</td>
				<td>".$d['place']."</td>
				<td>".round(1/count($users), 2)."</td>
				
				<td>".$u['last_name']." ".$u['first_name']." ".$u['middle_name']."</td>
				<td>".$u['type_in']."</td>
				<td>".$num_student."</td>
				<td>".$name_organization."</td>
				<td>".$city."</td>
				<td>".$u['stip']."</td>
				<td>".$u['groupname']."</td>
				<td>".$u['level']."</td>
			</tr>";
		}
	}
	$box .=' </tbody></table>';
}

	$template->templateSetVar('content',  $box );

$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateSetVar('name_role', Cookies::getNameUserRole());
$template->templateCompile();
$template->templateDisplay();