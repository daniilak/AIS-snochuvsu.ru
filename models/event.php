<?php
Cookies::authCheck();
$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$role = "СуперАдминистратор";
switch($GLOBALS['user']['id_role']) {
	case 0:
		$role = "Пользователь";
		break;
	case 1:
		$role = "Модератор";
		break;
	case 2:
		$role = "Руководство СНО";
		break;
		
}
$template->templateSetVar('name_role', $GLOBALS['user']['first_name'].' Роль: '.$role);
$template->templateCompile();
$template->templateDisplay();