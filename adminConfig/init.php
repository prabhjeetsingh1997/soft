<?php 
    $array = explode('/',$_SERVER['DOCUMENT_ROOT']);
    array_pop($array);
    $path = implode('/',$array);
    $realpath = $path.'/'.'mrscapital.in/soft/adminConfig/database.php';
if(file_exists($realpath))
{
    require $realpath;
}else{
    echo "there is problem including database";
}
// require 'soft/adminConfig/database.php';
 
// require APP_ROOT.'soft/adminConfig/classes/admin.php';
// require APP_ROOT.'soft/adminConfig/classes/users.php';
// require APP_ROOT.'soft/adminConfig/classes/client.php';
// require APP_ROOT.'soft/adminConfig/classes/hotel.php';
// require APP_ROOT.'soft/adminConfig/classes/transporter.php';
// require APP_ROOT.'soft/adminConfig/classes/travel_agent.php';
// require APP_ROOT.'soft/adminConfig/general.php';
// require APP_ROOT.'soft/adminConfig/bcrypt.php';

require $path.'/mrscapital.in/soft/adminConfig/classes/admin.php';
require $path.'/mrscapital.in/soft/adminConfig/classes/users.php';
require $path.'/mrscapital.in/soft/adminConfig/classes/client.php';
require $path.'/mrscapital.in/soft/adminConfig/classes/hotel.php';
require $path.'/mrscapital.in/soft/adminConfig/classes/transporter.php';
require $path.'/mrscapital.in/soft/adminConfig/classes/travel_agent.php';
require $path.'/mrscapital.in/soft/adminConfig/general.php';
require $path.'/mrscapital.in/soft/adminConfig/bcrypt.php';

$general 	    = new General();
$bcrypt 	    = new Bcrypt(12);
$objAdmin 		= new Admin($db);
$objclient 		= new Client($db);
$users	 		= new Users($db);
$objhotel 		= new Hotel($db);
$objtransporter = new Transporter($db);
$objtravel 		= new Travel($db);
$errors = array();

if(($general->logged_in_admin() === true))  {
    if(isset($_SESSION['admin_Id']))
    {
        $admin_Id 	= $_SESSION['admin_Id']; 
    }
}