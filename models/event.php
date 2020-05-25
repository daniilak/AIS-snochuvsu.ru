<?php
Cookies::authCheck();
if ($GLOBALS['user']['id_role'] < 2) {
	echo "System closed";die();
}
$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateSetVar('name_role', Cookies::getNameUserRole());
$template->templateCompile();
$template->templateDisplay();