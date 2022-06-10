<?php ob_start();
error_reporting(E_ERROR | E_WARNING | E_PARSE);
    if($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1'){
      ini_set('upload_tmp_dir',$_SERVER["DOCUMENT_ROOT"].'/van/'); 
	}
	else
	{
	  
		ini_set('session.save_path',$_SERVER["DOCUMENT_ROOT"].'/parichay/session/');
		ini_set('upload_tmp_dir',$_SERVER["DOCUMENT_ROOT"].'/parichay/tmp/'); 
		
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
			'username' 	=> '',
			'password' 	=> '',
			'dbname' 	=> 'travelcrm'
		);
	}
	// ---------- Cookie Info ---------- //
	/*$cookie_jobseeker = 'jobseekerAuth';
	$cookie_time = (3600 * 24 * 30); // 30 days
	$cookie_emp = 'empAuth';*/



	# ----------------------------------------------------------------------------------------------------
	# Website NAME
	# ----------------------------------------------------------------------------------------------------
	
	define(@APP_NAME, "van");

	# ----------------------------------------------------------------------------------------------------
	# Website Title
	# ----------------------------------------------------------------------------------------------------
	

	# ----------------------------------------------------------------------------------------------------
	# Website HEAD KEYWORDS
	# ----------------------------------------------------------------------------------------------------
	//index
	
		define(@APP_HEAD_KEYWORDS, "van");
	# ----------------------------------------------------------------------------------------------------
	# Website HEAD DESCRIPTION
	# ----------------------------------------------------------------------------------------------------
	define(@APP_HEAD_DESCRIPTION, " van ".APP_NAME);
	# ----------------------------------------------------------------------------------------------------
	# Website HEAD Title
	# ----------------------------------------------------------------------------------------------------
	define(@APP_HEAD_TITLE, APP_NAME." van ");
	
	

	# ----------------------------------------------------------------------------------------------------
	# DEFINE APP FOLDER
	# ----------------------------------------------------------------------------------------------------
	
	if($_SERVER['REMOTE_ADDR']=='127.0.0.1' || $_SERVER['REMOTE_ADDR']=='::1')
	{
	   define(@APP_FOLDER, "/van/admin/");
	}
	else
	{
	   define(@APP_FOLDER, "/parichay/admin/");
	}
	
	# ----------------------------------------------------------------------------------------------------
	# DEFINE APP ROOT
	# ----------------------------------------------------------------------------------------------------

	define(@APP_ROOT, $_SERVER["DOCUMENT_ROOT"].APP_FOLDER);

	# ----------------------------------------------------------------------------------------------------
	# DEFINE DEFAULT URL
	# ----------------------------------------------------------------------------------------------------

	define(@APP_URL, "http://".$_SERVER["HTTP_HOST"].APP_FOLDER);

	
try{
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
}
catch(PDOException $e){
   echo 'Connection failed: ' . $e->getMessage();
}
