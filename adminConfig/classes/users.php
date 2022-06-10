<?php 
class Users{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}	
	
	public function update_userinfo($userId, $usertype, $updstr){
		if($usertype == 'agent')
		{
			$query = $this->db->prepare("UPDATE `agent` SET $updstr WHERE `id` = ?");
		}
		else{
			$query = $this->db->prepare("UPDATE `supplier` SET $updstr WHERE `id` = ?");
		}

		$query->bindValue(1, $userId);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function update_addressinfo($userId, $usertype, $updstr){
		if($usertype == 'agent')
		{
			$query = $this->db->prepare("UPDATE `agent` SET $updstr WHERE `id` = ?");
		}
		else{
			$query = $this->db->prepare("UPDATE `supplier` SET $updstr WHERE `id` = ?");
		}

		$query->bindValue(1, $userId);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function chkOldPass($userId, $usertype, $old_pass) {
		//echo $old_pass;
		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called
		/* Two create a Hash you do */
		//$password_hash = $bcrypt->genHash($old_pass);
		if($usertype == 'agent')
		{
			//echo "SELECT password FROM `agent` WHERE `id` = $userId ";
			$query = $this->db->prepare("SELECT password FROM `agent` WHERE `id` = ?");
		}
		else{
			$query = $this->db->prepare("SELECT password FROM `supplier` WHERE `id` = ?");
		}
		$query->bindValue(1, $userId);

		try{
			$query->execute();
			$stored_password = $query->fetchColumn();
			echo ($data);
			$bcrypt->verify($old_pass, $stored_password);
			if($bcrypt->verify($old_pass, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return true;	// returning the user's id.
			}else{
				return false;	
			}
			//echo ($data);
			 //true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function change_password($userId, $usertype, $new_pass) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called
		/* Two create a Hash you do */
		$password_hash = $bcrypt->genHash($new_pass);
		if($usertype == 'agent')
		{
			$query = $this->db->prepare("UPDATE `agent` SET `password` = ? WHERE `id` = ?");
		}
		else{
			$query = $this->db->prepare("UPDATE `supplier` SET `password` = ? WHERE `id` = ?");
		}
		$query->bindValue(1, $password_hash);
		$query->bindValue(2, $userId);

		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function recover($email, $generated_string, $type) {

		if($generated_string == 0){
			return false;
		}else{
			if($type == 'agent')
			{	
				$query = $this->db->prepare("SELECT COUNT(`id`) FROM `agent` WHERE `email` = ? AND `generated_string` = ?");
			}else{
				$query = $this->db->prepare("SELECT COUNT(`id`) FROM `supplier` WHERE `email` = ? AND `generated_string` = ?");
			}
			$query->bindValue(1, $email);
			$query->bindValue(2, $generated_string);

			try{

				$query->execute();
				$rows = $query->fetchColumn();

				if($rows == 1){
					global $bcrypt;
					//$username = $this->fetch_info('username', 'email', $email); // getting username for the use in the email.
					//$user_id  = $this->fetch_info('id', 'email', $email);// We want to keep things standard and use the user's id for most of the operations. Therefore, we use id instead of email.
					
					if($type == 'agent')
					{
						$queryuser = $this->db->prepare("SELECT id, uname FROM `agent` WHERE email = ?");
					}
					else{
						$queryuser = $this->db->prepare("SELECT id, uname FROM `supplier` WHERE email = ?");
					}
					$queryuser->bindValue(1, $email);
					$queryuser->execute();
					$data 				= $queryuser->fetch();
					$username 	= $data['uname']; // user name
					$user_id   	= $data['id']; // id of the user to be returned if the password is verified, below.
			
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$generated_password = substr(str_shuffle($charset),0, 10);

					//$this->change_password($user_id, $generated_password, $type);
					
					$password_hash = $bcrypt->genHash($generated_password);					
					if($type == 'agent')
					{
						$query = $this->db->prepare("UPDATE `agent` SET `generated_string` = 0, password=? WHERE `id` = ?");
					}
					else{
						//echo "UPDATE `supplier` SET `generated_string` = 0, password=$password_hash WHERE `id` = $user_id";
						$query = $this->db->prepare("UPDATE `supplier` SET `generated_string` = 0, password=? WHERE `id` = ?");
					}
					

					$query->bindValue(1, $password_hash);
					$query->bindValue(2, $user_id);
	
					$query->execute();

					mail($email, 'Your password', "Hello " . $username . ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n-Messageing Team");
					//echo 'Your password', "Hello " . $username . ",\n\nYour your new password is: " . $generated_password . "\n\nPlease change your password once you have logged in using this password.\n\n-Messageing Team";
				}else{
					return false;
				}

			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

    public function fetch_info($what, $field, $value){

		$allowed = array('id', 'username', 'first_name', 'last_name', 'gender', 'bio', 'email'); // I have only added few, but you can add more. However do not add 'password' eventhough the parameters will only be given by you and not the user, in our system.
		if (!in_array($what, $allowed, true) || !in_array($field, $allowed, true)) {
		    throw new InvalidArgumentException;
		}else{
		
			$query = $this->db->prepare("SELECT $what FROM `users` WHERE $field = ?");

			$query->bindValue(1, $value);

			try{

				$query->execute();
				
			} catch(PDOException $e){

				die($e->getMessage());
			}

			return $query->fetchColumn();
		}
	}

	public function confirm_recover($email, $type){

		//$username = $this->fetch_info('username', 'email', $email);// We want the 'id' WHERE 'email' = user's email ($email)
		if($type == 'agent')
		{
			$queryuser = $this->db->prepare("SELECT uname FROM `agent` WHERE email = ?");
		}
		else{
			$queryuser = $this->db->prepare("SELECT uname FROM `supplier` WHERE email = ?");
		}
		$queryuser->bindValue(1, $email);
		$queryuser->execute();
		$username = $queryuser->fetchColumn();
		
		$unique = uniqid('',true);
		$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10);
		
		$generated_string = $unique . $random; // a random and unique string
		if($type == 'agent')
		{
			$query = $this->db->prepare("UPDATE `agent` SET `generated_string` = ? WHERE `email` = ?");
		}
		else{
			$query = $this->db->prepare("UPDATE `supplier` SET `generated_string` = ? WHERE `email` = ?");
		}	
		$query->bindValue(1, $generated_string);
		$query->bindValue(2, $email);

		try{
			
			$query->execute();

			return mail($email, 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\n".APP_URL."/recover.php?email=" . $email . "&generated_string=" . $generated_string ."&type=".$type. "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Messageing Team");
			//echo 'Recover Password', "Hello " . $username. ",\r\nPlease click the link below:\r\n\r\n".APP_URL."/recover.php?email=" . $email . "&generated_string=" . $generated_string ."&type=".$type. "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Messageing Team";	
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	 
	public function email_exists($email, $type) {
		//echo "SELECT COUNT(`id`) FROM `users` WHERE `email`= $email";
		//die;	
		if($type == 'agent')
		{
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `agent` WHERE `email`= ?");
		}
		else{
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `supplier` WHERE `email`= ?");
		}
		$query->bindValue(1, $email);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows >= 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function user_exists($username, $type) {
		//echo "SELECT COUNT(`id`) FROM `users` WHERE `email`= $email";
		//die;	
		if($type == 'agent')
		{
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `agent` WHERE `uname`= ?");
		}
		else{
			$query = $this->db->prepare("SELECT COUNT(`id`) FROM `supplier` WHERE `uname`= ?");
		}
		$query->bindValue(1, $username);
	
		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function get_country_list() {
		$query = $this->db->prepare("SELECT * FROM `countrymaster` ORDER BY id DESC");
		try{

			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_contryNameById($contryid) {
		$query = $this->db->prepare("SELECT country FROM `countrymaster` WHERE countrymasterid= ?");
		$query->bindValue(1, $contryid);
		try{
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_stats_list($cid) {
	
		$query = $this->db->prepare("SELECT statemasterid FROM `statemaster` WHERE countrymasterid= ?");
		$query->bindValue(1, $cid);
	
		try{
			$query->execute();
			/* $data 				= $query->fetch();
			$state_id 	= $data['statemasterid']; // stored hashed password

			$query1 = $this->db->prepare("SELECT * FROM `citymaster` WHERE statemasterid= ?");
			$query1->bindValue(1, $state_id);
			$query1->execute(); */
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	public function get_city_list($sid) {
	
		$query = $this->db->prepare("SELECT * FROM `citymaster` WHERE statemasterid= ? ORDER BY city DESC");
		$query->bindValue(1, $sid);
	
		try{
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function get_cityNameById($cityid) {
	
		$query = $this->db->prepare("SELECT city FROM `citymaster` WHERE citymasterid= ? ORDER BY city DESC");
		$query->bindValue(1, $cityid);
	
		try{
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function agent_register($agency_name, $anualTover_currency, $anualTover_val, $agent_name_prefix, $agent_Fname, $agent_Lname, $position, $address1, $address2, $address3, $country, $city, $postal_code, $telephone, $email, $fax, $website, $hear_about, $trading_years, $staff_quantity, $IATA, $ATOL, $ABTA, $other, $user_name, $password){

		global $bcrypt; // making the $bcrypt variable global so we can use here

		$time 		= time();
		$status = 0;
		$ip 		= $_SERVER['REMOTE_ADDR']; // getting the users IP address
		$userPass = $password;
		$address = $address1.' '.$address2.' '.$address3;
		$password   = $bcrypt->genHash($password);
	    $anualTover_currency = '';
		$anualTover_val      = 0;
      
       $query 	= $this->db->prepare("INSERT INTO agent(`uname`, `name_prefix`, `first_name`, `last_name`, `position`, `email`, `phone`, `fax`, `password`, `city`, `address`, `country`, `pin_code`, `agnecy_name`, `website`, `turnover_currency`, `turnouver_amount`, `hear_about`, `no_trading_years`, `no_of_staff`, `member_IATA`, `member_ATOL`, `member_ABTA`, `member_other`, `ip`, `time`, `status`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$query->bindValue(1, $user_name);
		$query->bindValue(2, $agent_name_prefix);
		$query->bindValue(3, $agent_Fname);
		$query->bindValue(4, $agent_Lname);
		$query->bindValue(5, $position);
		$query->bindValue(6, $email);
		$query->bindValue(7, $telephone);
		$query->bindValue(8, $fax);
		$query->bindValue(9, $password);
		$query->bindValue(10, $city);
		$query->bindValue(11, $address);
		$query->bindValue(12, $country);
		$query->bindValue(13, $postal_code);
		$query->bindValue(14, $agency_name);
		$query->bindValue(15, $website);
		$query->bindValue(16, $anualTover_currency);
		$query->bindValue(17, $anualTover_val);
		$query->bindValue(18, $hear_about);
		$query->bindValue(19, $trading_years);
		$query->bindValue(20, $staff_quantity);
		$query->bindValue(21, $IATA);
		$query->bindValue(22, $ATOL);
		$query->bindValue(23, $ABTA);
		$query->bindValue(24, $other);
		$query->bindValue(25, $ip);
		$query->bindValue(26, $time);
		$query->bindValue(27, $status);
		
		try{
		 
			$query->execute();
			$headersnw = 'From: register@firstdmc.com';
			mail($email, 'Welcome Firstdmc.com', "\nDear " . $agent_Fname. ",\r\nThank you for registering & requesting logins to our site. \r\nWe will endeavour to activate your account within the next 48 hours,\r\nWe look forward to doing business together.\n\nMany Thanks & Regards,\r\nFirstdmc.com", $headersnw);
			
			return $this->db->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function supplier_register($trading_name, $cmpny_reg_no, $position, $name_prefix,$fname,$lname, $address, $country, $city, $postal_code, $telephone, $email, $fax, $website, $hear_about, $language, $trading_years, $username, $sup_password, $alertnatenumber){
	

		global $bcrypt; // making the $bcrypt variable global so we can use here

		$time 		= date('Y-m-d H:i:s');
		$status = 0;
		$ip 		= $_SERVER['REMOTE_ADDR']; // getting the users IP address
		$userPass = $sup_password;
		$sup_password   = $bcrypt->genHash($sup_password);
       
        $query 	= $this->db->prepare("INSERT INTO supplier(`uname`, `name_prefix`, `first_name`, `last_name`,`compny_registration_num`, `email`, `phone`, `password`, `city`, `address`, `country`, `pin_code`, `company_name`, `designation`, `fax`, `website`, `hear_about`, `language_response`, `agency_trading_years`, `ip`, `time`, `status`, `mobile_number`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");

		$query->bindValue(1, $username);
		$query->bindValue(2, $name_prefix);
		$query->bindValue(3, $fname);
		$query->bindValue(4, $lname);
		$query->bindValue(5, $cmpny_reg_no);
		$query->bindValue(6, $email);
		$query->bindValue(7, $telephone);
		$query->bindValue(8, $sup_password);
		$query->bindValue(9, $city);
		$query->bindValue(10, $address);
		$query->bindValue(11, $country);
		$query->bindValue(12, $postal_code);
		$query->bindValue(13, $trading_name);
		$query->bindValue(14, $position);
		$query->bindValue(15, $fax);
		$query->bindValue(16, $website);
		$query->bindValue(17, $hear_about);
		$query->bindValue(18, $language);
		$query->bindValue(19, $trading_years);
		$query->bindValue(20, $ip);
		$query->bindValue(21, $time);
		$query->bindValue(22, $status);			
		$query->bindValue(23, $alertnatenumber);			
		try{
			$query->execute();
			
			$lstid = $this->db->lastInsertId();
			if($lstid)
			{
			   $headers = 'From: register@firstdmc.com';
				mail($email, 'Welcome Firstdmc.com', "Dear " . $fname. ",\r\n\nThank you for registering & requesting logins to our site. \r\nWe will endeavour to activate your account within the next 48 hours,\r\nWe look forward to doing business together.\n\nMany Thanks & Regards, \r\nFirstdmc.com", $headers);
				return $lstid; 
				
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function login($useremail, $password, $type) {

		global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called
		if($type == 'agent')
		{
		//echo "SELECT `password`, `id` FROM `agent` WHERE `email` = 'devtilante@gmail.com'";
			$query = $this->db->prepare("SELECT `password`, `id` FROM `agent` WHERE `email` = ? OR uname = ?");
		}
		else{
			$query = $this->db->prepare("SELECT `password`, `id` FROM `supplier` WHERE `email` = ? OR uname = ?");
		}
		$query->bindValue(1, $useremail);
		$query->bindValue(2, $useremail);

		try{
			
			$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password']; // stored hashed password
			$id   				= $data['id']; // id of the user to be returned if the password is verified, below.
			$bcrypt->verify($password, $stored_password);
			if($bcrypt->verify($password, $stored_password) === true){ // using the verify method to compare the password with the stored hashed password.
				return $id;	// returning the user's id.
			}else{
				return false;	
			}

		}catch(PDOException $e){
			die($e->getMessage());
		}
	
	}
	
	
	public function chkUserStatus($uId) {
	
		$query = $this->db->prepare("SELECT status FROM `supplier` WHERE id = ?");
		$query->bindValue(1, $uId);
	
		try{

			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function chkagentsStatus($uId) {
	
		$query = $this->db->prepare("SELECT status FROM `agent` WHERE id = ?");
		$query->bindValue(1, $uId);
	
		try{

			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	public function activate($email, $email_code) {
		
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email` = ? AND `email_code` = ? AND `confirmed` = ?");

		$query->bindValue(1, $email);
		$query->bindValue(2, $email_code);
		$query->bindValue(3, 0);

		try{

			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				
				$query_2 = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");

				$query_2->bindValue(1, 1);
				$query_2->bindValue(2, $email);				

				$query_2->execute();
				return true;

			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}


	public function email_confirmed($username) {

		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `users` WHERE `email`= ? AND `confirmed` = ?");
		$query->bindValue(1, $username);
		$query->bindValue(2, 1);
		
		try{
			
			$query->execute();
			$rows = $query->fetchColumn();

			if($rows == 1){
				return true;
			}else{
				return false;
			}

		} catch(PDOException $e){
			die($e->getMessage());
		}

	}

	public function userdata($id, $type) {
		//echo "SELECT * FROM `users` WHERE `id`= $id";
		//die;
		if($type == 'agent')
		{
			$query = $this->db->prepare("SELECT * FROM `agent` WHERE `id`= ?");
		}
		else{
			$query = $this->db->prepare("SELECT * FROM `supplier` WHERE `id`= ?");
		}
		$query->bindValue(1, $id);

		try{

			$query->execute();

			return $query->fetch();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	
	public function Add_Gallary($userId, $userType, $filetype, $fileName){

		$time 		= time();
		$status = 0;
		$ip 		= $_SERVER['REMOTE_ADDR']; // getting the users IP address
        $query 	= $this->db->prepare("INSERT INTO gallary(`userId`, `user_type`,`file_name`,`file_type`,`ip`,`date`,`status`) VALUES (?,?,?,?,?,?,?)");

		$query->bindValue(1, $userId);
		$query->bindValue(2, $userType);
		$query->bindValue(3, $fileName);
		$query->bindValue(4, $filetype);
		$query->bindValue(5, $ip);
		$query->bindValue(6, $time);
		$query->bindValue(7, $status);
		
		try{
			$query->execute();
			return $this->db->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function upd_Video($vid_id, $fileName){

        $query 	= $this->db->prepare("UPDATE gallary SET file_name = ? WHERE id = ? LIMIT 1");

		$query->bindValue(1, $fileName);
		$query->bindValue(2, $vid_id);
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function viewGallary($userId, $userType, $filetype) {
		$query = $this->db->prepare("SELECT * FROM `gallary` WHERE `userId`= ? AND user_type =? AND file_type=? ORDER BY id desc");
		$query->bindValue(1, $userId);
		$query->bindValue(2, $userType);
		$query->bindValue(3, $filetype);

		try{

			$query->execute();

			return $query->fetchAll();

		} catch(PDOException $e){

			die($e->getMessage());
		}

	}
	
	public function activate_video($vid){
		$query = $this->db->prepare("UPDATE `gallary` SET status = 1 WHERE `id` = ?");
		$query->bindValue(1, $vid);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function deactivate_video($vid){
		$query = $this->db->prepare("UPDATE `gallary` SET status = 0 WHERE `id` = ?");
		$query->bindValue(1, $vid);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	
	public function activate_broucer($vid){
		$query = $this->db->prepare("UPDATE `brochures` SET status = 1 WHERE `id` = ?");
		$query->bindValue(1, $vid);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function deactivate_broucer($vid){
		$query = $this->db->prepare("UPDATE `brochures` SET status = 0 WHERE `id` = ?");
		$query->bindValue(1, $vid);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function upload_brochure($userId, $country, $fileName){
		$status = 1;
        $query 	= $this->db->prepare("INSERT INTO brochures(`userId`,`brochure`,`status`,`countryId`) VALUES (?,?,?,?)");

		$query->bindValue(1, $userId);
		$query->bindValue(2, $fileName);
		$query->bindValue(3, $status);
		$query->bindValue(4, $country);
		
		try{
			$query->execute();
			return $this->db->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function getBrochure($userId) {
		$query = $this->db->prepare("SELECT * FROM `brochures` WHERE `userId`= ? ORDER BY id desc");
		$query->bindValue(1, $userId);
	
		try{
			$query->execute();
			return $query->fetchAll();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	
}