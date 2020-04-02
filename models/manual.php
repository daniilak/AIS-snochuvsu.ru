<?php
Cookies::authCheck();
if ($GLOBALS['user']['id_role'] < 2) {
	header('Location: /', true, 307);
    die();
}
$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$role = "СуперАдминистратор";
switch($GLOBALS['user']['id_role']) {
	case 0:
		$role = "Пользователь системы";
		break;
	case 1:
		$role = "Модератор системы";
		break;
	case 2:
		$role = "Администратор системы";
		break;
		
}
$template->templateSetVar('name_role', $GLOBALS['user']['first_name'].' Роль: '.$role);
$template->templateCompile();
$template->templateDisplay();