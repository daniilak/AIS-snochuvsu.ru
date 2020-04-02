<?php
require_once('lib/Stats.php');
$id = 5;
$stats = new Stats($id);

$box = '<table class="table table-bordered table-hover">';
foreach ($stats->countSections() as $row) {
	$box .= '<tr><td>'.$row['name'].'</td><td>'.$row['count'].'</td></tr>';
}
$box .='</table>';

$template->templateSetVar('content',  $box );
$template->templateCompile();
$template->templateDisplay();