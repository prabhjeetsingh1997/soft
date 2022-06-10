<?php
include('config/init.php');
	$db = $config['dbname'];
	$exportData=$objAdmin->getExportLeads($_GET['action']);
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=dskeventall.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('id','parent_fname', 'email', 'relationship', 'mobile_no','alternative_no','address','city','state','zip','child_fname','age','payment_status','amount'));
	if (count($exportData) > 0) 
	{
    	foreach ($exportData as $row) {
        	fputcsv($output, $row);
    	}
	}
?>