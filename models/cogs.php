<?php
Cookies::authCheck();
$template->templateSetVar('role', $GLOBALS['user']['id_role']);
$template->templateSetVar('name_role', Cookies::getNameUserRole());
$template->templateCompile();
$template->templateDisplay();