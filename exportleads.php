<?php
include('config/init.php');
	$db = $config['dbname'];
	$exportData=$objAdmin->getExportLeads($_GET['action']);
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=Allleads.csv');
	$output = fopen('php://output', 'w');
	fputcsv($output, array('id','name', 'Email', 'mobile_no', 'alternative_no','created_at'));
	if (count($exportData) > 0) 
	{
    	foreach ($exportData as $row) {
        	fputcsv($output, $row);
    	}
	}
?>