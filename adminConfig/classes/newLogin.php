<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require 'soft/vendor/autoload.php';

class Admin{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}
	
	public function login($email,$password,$userType,$partner_url) {

		//global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called
		if($userType == 'admin')
		{
		    $query = $this->db->select("email, password, admin_id, user_type, employee_type, user_id FROM admin WHERE email = $email AND password = base64_encode($password)");
            $result = $this->db->query($query);

            if($result->num_rows > 0){
                return $query->fetch_row();
            }
			else
			{
				return false;
			}
		
		}
		else
		{
		    $query1 = $this->db->select("email, password, admin_id, user_type, employee_type, user_id FROM admin WHERE user_id = $email AND password= base64_encode($password) AND partner_url=$partner_url");
            $result = $this->db->query($query1);
            if($result->num_rows > 0){
                return true;
            }
			else
			{
				return false;
			}
		}
	
	}
}
?>