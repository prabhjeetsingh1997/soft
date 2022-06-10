<?php
include('config/init.php');

if($_GET['action'] == 'getEmp'){
	if (isset($_POST)) {
	$emp_list = $objAdmin->getEmployee();
	if($emp_list)
	{
		echo json_encode($emp_list);
		exit;
	}
	else
	{
		echo 0;
	}
	}else{
		echo 2;
	}
}

if ($_GET['action'] == 'assignEmp') {
	$user_id = $_POST['user_id'];
	$query_id = $_POST['id'];
	$emp_list = $objAdmin->AssignEmployee($user_id,$query_id);
	if ($emp_list) {
		echo 1;
	}else{
		echo 0;
	}
}

?>