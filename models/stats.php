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
$events = $stats->countEvents();
$template->templateSetVar('countEvents',  $events['cnt'] );
$template->templateSetVar('ListEvents',  $events['l'] );


$strCountEventsByFac = "";
$strCountEventsByType = "";
foreach ($stats->getFacs() as $fac) {
	// var_dump($stats->countEventsOnFac($fac['ID']));
	$strCountEventsByFac .= '
	{
		    name: "'.$fac['full_name'].'",
		    data: ['.$stats->countEventsByFac($fac['ID']).'],
	},';
}
foreach ($stats->getTypeEventsList() as $f) {
	$strCountEventsByType .= '
	{
		    name: "'.$f['type'].'",
		    data: ['.$stats->countEventsByType($f['ID']).'],
	},';
}
$strcountRecoms = "";
// foreach ($stats->countRecoms() as $f) {
	
// }
$template->templateSetVar('countEventsByFac',  $strCountEventsByFac );
$template->templateSetVar('countEventsByType',  $strCountEventsByType );
$template->templateSetVar('countRecoms',  $strcountRecoms );


$template->templateCompile();
$template->templateDisplay();