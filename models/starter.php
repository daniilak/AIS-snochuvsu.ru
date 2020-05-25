<?php
Cookies::authCheck();
$template->templateSetVar('name_role', Cookies::getNameUserRole());
$template->templateCompile();
$template->templateDisplay();