<?php ob_start();
	//error_reporting(0);
	//error_reporting(E_ALL);
	//date_default_timezone_set('Asia/Kolkata');
    if($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1'){
      ini_set('upload_tmp_dir',$_SERVER["DOCUMENT_ROOT"].'/van/'); 
	}
	else
	{
		ini_set('session.save_path',$_SERVER["DOCUMENT_ROOT"].'/soft/session');
		ini_set('upload_tmp_dir',$_SERVER["DOCUMENT_ROOT"].'/soft/temp_upload'); 
	}

    session_start();
	# ----------------------------------------------------------------------------------------------------
	# DEFINE APP FOLDER
	# ----------------------------------------------------------------------------------------------------
	if($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1')
	{
		    $config = array(
			'host'		=> 'localhost',
			'username' 	=> 'root',
			'password' 	=> '',
			'dbname' 	=> 'travelcrm'
		);
    }
	else
	{
			$config = array(
			'host'		=> 'localhost',
			'username' 	=> 'lidtry8f_softwer',
			'password' 	=> 'm@wGTc8%2Ash',
			'dbname' 	=> 'lidtry8f_software'
		);
	}
	// ---------- Cookie Info ---------- //
	/*$cookie_jobseeker = 'jobseekerAuth';
	$cookie_time = (3600 * 24 * 30); // 30 days
	$cookie_emp = 'empAuth';*/



	# ----------------------------------------------------------------------------------------------------
	# Website NAME
	# ----------------------------------------------------------------------------------------------------
	
	define(@APP_NAME, "TravlerCRM");

	# ----------------------------------------------------------------------------------------------------
	# Website Title
	# ----------------------------------------------------------------------------------------------------
	

	# ----------------------------------------------------------------------------------------------------
	# Website HEAD KEYWORDS
	# ----------------------------------------------------------------------------------------------------
	//index
	
		define(@APP_HEAD_KEYWORDS, "TravlerCRM");
	# ----------------------------------------------------------------------------------------------------
	# Website HEAD DESCRIPTION
	# ----------------------------------------------------------------------------------------------------
	define(@APP_HEAD_DESCRIPTION, " TravlerCRM ".APP_NAME);
	# ----------------------------------------------------------------------------------------------------
	# Website HEAD Title
	# ----------------------------------------------------------------------------------------------------
	define(@APP_HEAD_TITLE, APP_NAME." TravlerCRM ");
	
	

	# ----------------------------------------------------------------------------------------------------
	# DEFINE APP FOLDER
	# ----------------------------------------------------------------------------------------------------
	
	if($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1')
	{
	   define(@APP_FOLDER, "/travlecrm/admin");
	}
	else
	{
	   define(@APP_FOLDER, "/");
	}
	
	# ----------------------------------------------------------------------------------------------------
	# DEFINE APP ROOT
	# ----------------------------------------------------------------------------------------------------

	define(@APP_ROOT, $_SERVER["DOCUMENT_ROOT"].APP_FOLDER);

	# ----------------------------------------------------------------------------------------------------
	# DEFINE DEFAULT URL
	# ----------------------------------------------------------------------------------------------------

	define(@APP_URL, "https://".$_SERVER["HTTP_HOST"].APP_FOLDER);
// Create connection
//$db = new mysqli($config['host'], $config['username'], $config['password'], $config['dbname']);
// Check connection
// if($db->connect_error) {
//   die("Connection failed: " . $db->connect_error);
// }

	
try{
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}
catch(PDOException $e){
  echo 'Connection failed: ' . $e->getMessage();
}
?>