<?php  
class Admin{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}
	
	public function update_admin($col, $val, $uId){
		$query = $this->db->prepare("UPDATE `users` SET `$col` = ? WHERE `id` = ?");

		$query->bindValue(1, $val);
		$query->bindValue(2, $uId);
		
		try{
			$query->execute();
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function search($q){
		alert("edfewf");
		$query = $this->db->prepare("select id,username from admin where username like '%$q%' order by id LIMIT 5");

		$query->bindValue(1, $q);
				
		try{
			$query->execute();
			$count=$query->rowCount();
			
			if($count)
			{
				return true;
			}
			else
			{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function email_exists($email)
	{
		$query = $this->db->prepare("select `email` from `admin` where `email`=?");
		$query->bindValue(1,$email);
		try{
			$query->execute();
			$count=$query->rowCount();
			
			if($count)
			{
				return true;
			}
			else
			{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_countery() {
		$query = $this->db->prepare("SELECT * FROM countrymaster ");
		 $query->bindValue(1, 0);
		try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	public function get_state($id) {
		$query = $this->db->prepare("SELECT * FROM statemaster WHERE countrymasterid IN($id) order by id");
		 $query->bindValue(1, $id);
		try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	public function get_city($id) {
		$query = $this->db->prepare("SELECT * FROM citymaster WHERE statemasterid = ?  order by id");
		 $query->bindValue(1, $id);
		try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	public function get_stateAll(){
		$query = $this->db->prepare("SELECT * FROM statemaster order by id ASC");
		try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	
	public function get_stateByItsId($id){
		$query = $this->db->prepare("SELECT * FROM statemaster WHERE id = $id");
		try{
				$query->execute();
				return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	
	public function get_cityAll($ids) {
		if($ids == '' || $ids == 'null')
		{
			$con = '';
		}
		else
		{
			$con = "IN($ids)";
		}
		
		//echo "SELECT * FROM citymaster WHERE statemasterid $con order by id";
		$query = $this->db->prepare("SELECT * FROM citymaster WHERE statemasterid $con order by id");
		try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
				die($e->getMessage());
		}
	}
	
	public function condidate_exists($ca_Name, $dob, $fa_Name)
	{
		$dob = date('Y-m-d', strtotime($dob));
		//echo "SELECT id FROM `user_details` WHERE username='$ca_Name' AND date_of_birth='$dob' AND father_name='$fa_Name'";
		$query=$this->db->prepare("SELECT id FROM `user_details` WHERE username=? AND date_of_birth=? AND father_name=?");
			
		$query->bindvalue(1, $ca_Name);
		$query->bindValue(2,  $dob);
		$query->bindValue(3,  $fa_Name);
		try{
			$query->execute();
			$count=$query->rowCount();
			
			if($count)
			{
				return true;
			}
			else
			{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function forget_password($email,$confirm_pass) {
		$unique = uniqid('',true);
		$random = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'),0, 10);
		
		$generated_string = $unique . $random; // a random and unique string
		
		$query = $this->db->prepare("UPDATE `admin` SET `forget_pass_string` = ? WHERE `email` = ?");
		$query->bindValue(1, $generated_string);
		$query->bindValue(2, $email);
		try{
			$query->execute(); 

			return mail($email, 'Recover Password', "Hello,\r\nPlease click the link below:\r\n\r\nhttp://lidtravel.com/parichay/admin/recover.php?email=" . $email . "&generated_string=" . $generated_string . "\r\n\r\n We will generate a new password for you and send it back to your email.\r\n\r\n-- Parichay Sammelan Team");
			//return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
		
	}
	
	public function recover($email, $generated_string) {

		if($generated_string == 0){
			return false;
		}else{
	
			$query = $this->db->prepare("SELECT COUNT(`admin_id`) FROM `admin` WHERE `email` = ? AND `forget_pass_string` = ?");

			$query->bindValue(1, $email);
			$query->bindValue(2, $generated_string);

			try{

				$query->execute();
				$rows = $query->fetchColumn();

				if($rows == 1){
					
					$charset = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
					$newPass = substr(str_shuffle($charset),0, 10);
					
					$query = $this->db->prepare("UPDATE `admin` SET `password` = ?, forget_pass_string = '0' WHERE `email` = ? AND forget_pass_string=?");

					$query->bindValue(1, md5($newPass));
					$query->bindValue(2, $email);
					$query->bindValue(3, $generated_string);
					$query->execute();
					
					return mail($email, 'Your password', "Dear,\n\nYour your new password is: " . $newPass . "\n\nPlease change your password once you have logged in using this password.\n\n-Parichay Sammelan Team");
					

				}else{
					return false;
				}

			} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
		public function reset_password($old_pass, $confirm_pass,$admin_Id) {
		
		$query = $this->db->prepare("SELECT `password`, `email` FROM `admin` WHERE admin_Id=?");
		$query->bindValue(1, $admin_Id);
			try{
				$query->execute();
			$data 				= $query->fetch();
			$stored_password 	= $data['password'];
		    $email   			= $data['email'];
			//echo base64_encode($old_pass).'=='.$stored_password;
			if(base64_encode($old_pass)  == $stored_password){
				//echo 'mmmmm';
				$query = $this->db->prepare("UPDATE `admin` SET `password` = ? WHERE `email` = ?");
				$query->bindValue(1,base64_encode($confirm_pass));
				$query->bindValue(2, $email);
				$query->execute();
				return true;
			}else{
				return false;	
			}
			}catch(PDOException $e){
			die($e->getMessage());
		}
		}

		
		
		public function itinerary_management($data) {
			extract($data);
			$country=implode(',',$country);
			$strState=implode(',',$state);
			$strCity=implode(',',$city);
			
			$durationcity = implode(',', $tblCity);
			
			if(!empty($editId)){
				//echo "UPDATE itinerary_management SET `country`='$country', `state`='$strState', `city`='$strCity', `title`='$title', `itinerary`='$itinerary', duration_city = '$durationcity', duration='$duration' WHERE id='$editId'";
				//die;
				$query = $this->db->prepare("UPDATE itinerary_management SET `country`=?, `state`=?, `city`=?, `title`=?, `itinerary`=?, duration_city = ?, duration=?, duration_detail =? WHERE id=?");
				$query->bindValue(1, $country);
				$query->bindValue(2, $strState);
				$query->bindValue(3, $strCity);
				$query->bindValue(4, $title);
				$query->bindValue(5, $itinerary);
				$query->bindValue(6, $durationcity);
				$query->bindValue(7, $duration);
				$query->bindValue(8, $iteDurationDetail);
				$query->bindValue(9, $editId);
				
				try{
					$query->execute();
					return $this->manage_vehicle_cost($data, $editId);
					//return true;
				} catch (PDOException $e){
					die($e->getMessage());
				}
			}else{
			$query = $this->db->prepare("INSERT INTO itinerary_management(`country`, `state`, `city`, `title`, `itinerary`, `duration`,`duration_city`,duration_detail) VALUES (?,?,?,?,?,?,?,?)");
			$query->bindValue(1, $country);
			$query->bindValue(2, $strState);
			$query->bindValue(3, $strCity);
			$query->bindValue(4, $title);
			$query->bindValue(5, $itinerary);
			$query->bindValue(6, $duration);
			$query->bindValue(7, $durationcity);
			$query->bindValue(8, $iteDurationDetail);
			
			try{
				$query->execute();
				$lastrID = $this->db->lastInsertId();
				return $this->manage_vehicle_cost($data, $lastrID);
				//return true;
			} catch (PDOException $e){
				die($e->getMessage());
			}
			
		}
	}
	
	public function manage_vehicle_cost($data, $itinId)
	{
		/* echo 'asdfa';
		print_r($data);
		die; */
		extract($data);
		$itineraryVehicle = $this->get_vehicleitinerary();
		foreach($itineraryVehicle as $vehicle)
		{
			$vehCleid = $vehicle['id'];
			$vehCleCost = $_POST['cost_'.$vehCleid];
			$vehCleCostId = $_POST['vehcostId_'.$vehCleid];
			if($vehCleCostId == '')
			{
				$ItineraryCost = $this->db->prepare("INSERT INTO itinerary_vehicle_cost(`itenary_id`, `vehicle_id`, `cost`) VALUES (?,?,?)");
				$ItineraryCost->bindValue(1, $itinId);
				$ItineraryCost->bindValue(2, $vehCleid);
				$ItineraryCost->bindValue(3, $vehCleCost);
				$ItineraryCost->execute();
			}
			else
			{
				$ItineraryCost = $this->db->prepare("UPDATE itinerary_vehicle_cost SET cost = ? WHERE id = ? LIMIT 1");
				$ItineraryCost->bindValue(1, $vehCleCost);
				$ItineraryCost->bindValue(2, $vehCleCostId);
				$ItineraryCost->execute();
			}
		}
		
		for($i=1; $i<10; $i++)
		{
			$interestName = $_POST['intName_'.$i];
			$interestCost = $_POST['intCost_'.$i];
			$intCostId = $_POST['intrestCostid_'.$i];
			if($intCostId == '')
			{
				$InterestCost = $this->db->prepare("INSERT INTO itinerary_interest_cost(`itenary_id`, `interest_name`, `cost`) VALUES (?,?,?)");
				$InterestCost->bindValue(1, $itinId);
				$InterestCost->bindValue(2, $interestName);
				$InterestCost->bindValue(3, $interestCost);
				$InterestCost->execute();
			}
			else
			{
				$InterestCost = $this->db->prepare("UPDATE itinerary_interest_cost SET interest_name = ?, cost = ? WHERE id = ? LIMIT 1");
				$InterestCost->bindValue(1, $interestName);
				$InterestCost->bindValue(2, $interestCost);
				$InterestCost->bindValue(3, $intCostId);
				$InterestCost->execute();
			}
			
		}
		return true;
	}
	
	public function getAllItinerary(){
		$query = $this->db->prepare("SELECT * FROM itinerary_management ORDER BY id DESC");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllQuery($admin_Id, $user_type, $empType, $queryType,$start_from,$record_per_page){
		
		if($user_type == 'admin' || $empType == 1)
		{
			//echo 'aasdfasd';
			$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType ORDER BY id DESC LIMIT $start_from, $record_per_page");
		}
		else
		{
			//echo "SELECT * FROM query WHERE employeeId = $admin_Id AND query_type = $queryType ORDER BY id DESC";
			$query = $this->db->prepare("SELECT * FROM query WHERE employeeId = $admin_Id AND query_type = $queryType ORDER BY id DESC LIMIT $start_from, $record_per_page");
		}
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}


	public function getAllQueryResult($admin_Id, $user_type, $empType, $queryType)
	{
		if($user_type == 'admin' || $empType == 1)
		{
			//echo 'aasdfasd';
			$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType ORDER BY id DESC");
		}
		else
		{
			//echo "SELECT * FROM query WHERE employeeId = $admin_Id AND query_type = $queryType ORDER BY id DESC";
			$query = $this->db->prepare("SELECT * FROM query WHERE employeeId = $admin_Id AND query_type = $queryType ORDER BY id DESC");
		}
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getAllInHandQuery($user_type, $empType, $queryType,$start_from,$record_per_page,$user_id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND (status != 2 AND status != 3)  ORDER BY id DESC LIMIT $start_from, $record_per_page");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getAllInHandQueryResult($user_type, $empType, $queryType,$user_id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND (status != 2 AND status != 3) ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function deleteItineraryById($id){
		$query=$this->db->prepare("DELETE from itinerary_management WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteQueryById($id){
		$query=$this->db->prepare("DELETE from query WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getCountryNameById($id){
		
		$query = $this->db->prepare("SELECT * FROM countrymaster WHERE id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getStateNameById($id){
		
		$query = $this->db->prepare("SELECT * FROM statemaster WHERE id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getCityById($id){
		
		$query = $this->db->prepare("SELECT * FROM citymaster WHERE id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
		
public function client_prsnl_detail($data) {
		extract($_POST);
		
$dob_date = date('Y-m-d',strtotime($dob_date));
		$anvsryData = date('Y-m-d',strtotime($anvsryData));	
		
		$query = $this->db->prepare("INSERT INTO client(`tilte`, `f_name`, `m_name`, `l_name`, `dob`, `anniversary`) VALUES (?,?,?,?,?,?)");
		$query->bindValue(1, $client_title);
		$query->bindValue(2, $f_name);
		$query->bindValue(3, $m_name);
		$query->bindValue(4, $l_name);
		$query->bindValue(5, $dob_date);
		$query->bindValue(6, $anvsryData);
	
	
		try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}



public function client_company_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE client SET organisation=?, job_title=? WHERE id='".$clientId."'");
		$query->bindValue(1, $Organization);
		$query->bindValue(2, $job_title);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function client_offical_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE client SET client_id=?, client_refrence=? , sale_representative=?, cilent_user_id=? , client_password=? WHERE id='".$clientId."'");
		$query->bindValue(1, $client_id);
		$query->bindValue(2, $client_refrence);
		$query->bindValue(3, $sale_representative);
		$query->bindValue(4, $Client_user_id);
		$query->bindValue(5, $Client_user_pass);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function client_bank_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE client SET pan_number=?, account_name=? , account_number=?, bank_name=? , branch=? , ifsc_code=? WHERE id='".$clientId."'");
		$query->bindValue(1, $client_panNo);
		$query->bindValue(2, $client_acc_name);
		$query->bindValue(3, $client_acc_no);
		$query->bindValue(4, $client_bank);
		$query->bindValue(5, $client_branch);
		$query->bindValue(6, $client_ifsc);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function client_doc_detail($pan_file_name,$photo_file_name,$address_file_name,$adhaar_file_name , $password_file_name) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE client SET pan_card_copy=?, photo=? , adhaar_card_copy=?,  passport_copy=? , address_card_copy=? WHERE id='".$clientId."'");
		$query->bindValue(1, $pan_file_name);
		$query->bindValue(2, $photo_file_name);
		$query->bindValue(3, $address_file_name);
		$query->bindValue(4, $adhaar_file_name);
		$query->bindValue(5, $password_file_name);
	
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}





public function register($name,$email,$password,$perAddress,$resAddress)
	{
		$query=$this->db->prepare("insert into `admin`(username,email,password,parmanent_address,residence_address) values(?,?,?,?,?)");
		$query->bindvalue(1, $name);
		$query->bindValue(2, $email);
		$query->bindValue(3, md5($password));
		$query->bindValue(4, $perAddress);
		$query->bindValue(5, $resAddress);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
/*	----------------------------------------------Employee Form personal details------------------------------------------*/	
	public function adduser($data)
	{
		extract($data);
		//Test if it is a shared client
		$ip='';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		//Is it a proxy address
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		//The value of $ip at this point would look something like: "192.0.34.166"
		
		//print_r($data);
		$dob = date('Y-m-d',strtotime($dob));
		$userType = 'Employee';
		//$userPhone = $code.'-'.$phoneNum;
		//$userEmail = $userEmail[0];
		$employee_allmails = '';
		foreach($userEmail as $mails){
			$employee_allmails .= $mails.',';
		}
		$employee_allmailss = rtrim($employee_allmails,',');
		$employee_allmails = $employee_allmailss;
		
			//echo "insert into admin(name_perfix, first_name, middle_name, last_name, email, father_name_perfix, father_first_name, father_middle_name, father_last_name, mother_name_prefix, mother_first_name, mother_middle_name, mother_last_name, data_of_birth, user_type, ip_address,email_address) values('".$name_prefix."','".$firstname."','".$middle."','".$lastname."','".$userEmail[0]."','".$faPrefix."','".$faFName."','".$faMName."','".$faLName."','".$moPrefix."','".$MoFname."','".$MoMname."','".$MoLname."','".$dob."','".$userType."','".$ip."','".$employee_allmails."')";
			
		$query=$this->db->prepare("insert into admin(name_perfix, first_name, middle_name, last_name, email, father_name_perfix, father_first_name, father_middle_name, father_last_name, mother_name_prefix, mother_first_name, mother_middle_name, mother_last_name, data_of_birth, user_type, ip_address,email_address) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$query->bindvalue(1, $name_prefix);
		$query->bindValue(2, $firstname);
		$query->bindValue(3, $middle);
		$query->bindValue(4, $lastname);
		$query->bindValue(5, $userEmail[0]);
		$query->bindValue(6, $faPrefix);
		$query->bindValue(7, $faFName);
		$query->bindValue(8, $faMName);
		$query->bindValue(9, $faLName);
		$query->bindValue(10, $moPrefix);
		$query->bindValue(11, $MoFname);
		$query->bindValue(12, $MoMname);
		$query->bindValue(13, $MoLname);
		$query->bindValue(14, $dob);
		$query->bindValue(15, $userType);
		$query->bindValue(16, $ip);
		$query->bindValue(17, $employee_allmails);
		try{
			$query->execute(); 
			return $lastrID = $this->db->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		
	}
	
	public function edituser($data)
	{
		extract($data);
		//Test if it is a shared client
		$ip='';
		if (!empty($_SERVER['HTTP_CLIENT_IP'])){
		  $ip=$_SERVER['HTTP_CLIENT_IP'];
		//Is it a proxy address
		}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
		  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
		}else{
		  $ip=$_SERVER['REMOTE_ADDR'];
		}
		//The value of $ip at this point would look something like: "192.0.34.166"
		
		//print_r($data);
		$dob = date('Y-m-d',strtotime($dob));
		$userType = 'Employee';
		//$userPhone = $code.'-'.$phoneNum;
		$employee_allmails = '';
		foreach($userEmail as $mails){
			$employee_allmails .= $mails.',';
		}
		$employee_allmailss = rtrim($employee_allmails,',');
		$employee_allmails = $employee_allmailss;
		
		if(trim($userId) != '')
		{
			$query=$this->db->prepare("UPDATE admin SET name_perfix = ?, first_name=?, middle_name=?, last_name=?, email=?, father_name_perfix=?, father_first_name=?, father_middle_name=?, father_last_name=?, mother_name_prefix=?, mother_first_name=?, mother_middle_name=?, mother_last_name=?, data_of_birth=?, user_type=?, ip_address=?, email_address=? WHERE admin_id = ?");
			$query->bindvalue(1, $name_prefix);
			$query->bindValue(2, $firstname);
			$query->bindValue(3, $middle);
			$query->bindValue(4, $lastname);
			$query->bindValue(5, $userEmail[0]);
			$query->bindValue(6, $faPrefix);
			$query->bindValue(7, $faFName);
			$query->bindValue(8, $faMName);
			$query->bindValue(9, $faLName);
			$query->bindValue(10, $moPrefix);
			$query->bindValue(11, $MoFname);
			$query->bindValue(12, $MoMname);
			$query->bindValue(13, $MoLname);
			$query->bindValue(14, $dob);
			$query->bindValue(15, $userType);
			$query->bindValue(16, $ip);
			$query->bindValue(17, $employee_allmails);
			$query->bindValue(18, $userId);
			try{
				$query->execute(); 
				return $userId;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			
			$query=$this->db->prepare("insert into admin(name_perfix, first_name, middle_name, last_name, email, father_name_perfix, father_first_name, father_middle_name, father_last_name, mother_name_prefix, mother_first_name, mother_middle_name, mother_last_name, data_of_birth, user_type, ip_address,email_address) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$query->bindvalue(1, $name_prefix);
			$query->bindValue(2, $firstname);
			$query->bindValue(3, $middle);
			$query->bindValue(4, $lastname);
			$query->bindValue(5, $userEmail[0]);
			$query->bindValue(6, $faPrefix);
			$query->bindValue(7, $faFName);
			$query->bindValue(8, $faMName);
			$query->bindValue(9, $faLName);
			$query->bindValue(10, $moPrefix);
			$query->bindValue(11, $MoFname);
			$query->bindValue(12, $MoMname);
			$query->bindValue(13, $MoLname);
			$query->bindValue(14, $dob);
			$query->bindValue(15, $userType);
			$query->bindValue(16, $ip);
			$query->bindValue(17, $employee_allmails);
		
		}
		try{
			$query->execute(); 
			return $lastrID = $this->db->lastInsertId();
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function addUserContactDetails($rowId, $userMobile, $code, $type, $panel_name)
	{
		//echo "insert into `phone_number`(admin_id,contact_no,code,type) values('".$rowId."','".$userMobile."','".$code."','".$type."')";
		
		$query=$this->db->prepare("insert into `phone_number`(panel_id, contact_no, code, type, panel_name) values(?,?,?,?,?)");
		$query->bindvalue(1, $rowId);
		$query->bindValue(2, $userMobile);
		$query->bindValue(3, $code);
		$query->bindValue(4, $type);
		$query->bindValue(5, $panel_name);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function addUserAddressDetails($rowId, $add1, $add2,$country, $city, $state, $pin, $type, $ptype)
	{
		//echo "insert into `address_details`(admin_id,address1,address2,city,state,pin_code,address_type, panel_type) values('".$rowId."','".$add1."','".$add2."','".$city."','".$state."','".$pin."','".$type."','".$ptype."')";
		
		$query=$this->db->prepare("insert into `address_details`(admin_id,address1,address2,country,city,state,pin_code,address_type, panel_type) values(?,?,?,?,?,?,?,?,?)");
		$query->bindvalue(1, $rowId);
		$query->bindValue(2, $add1);
		$query->bindValue(3, $add2);
		$query->bindValue(4, $country);
		$query->bindValue(5, $city);
		$query->bindValue(6, $state);
		$query->bindValue(7, $pin);
		$query->bindValue(8, $type);
		$query->bindValue(9, $ptype);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function edituserContactDetails($conNumId,$rowId,$userMobile,$code,$type, $panel_name)
	{
		
		if(!empty($conNumId)){
			$query=$this->db->prepare("UPDATE phone_number SET contact_no = ?, code=?, type=?, panel_id = ?,panel_name=? WHERE id=?");
			$query->bindvalue(1, $userMobile);
			$query->bindValue(2, $code);
			$query->bindValue(3, $type);
			$query->bindValue(4, $rowId);
			$query->bindValue(5, $panel_name);
			$query->bindValue(6, $conNumId);
			try{
				$query->execute(); 
				return true;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}else{
			$query=$this->db->prepare("insert into `phone_number`(panel_id,contact_no,code,type,panel_name) values(?,?,?,?,?)");
			$query->bindvalue(1, $rowId);
			$query->bindValue(2, $userMobile);
			$query->bindValue(3, $code);
			$query->bindValue(4, $type);
			$query->bindValue(5, $panel_name);
			try{
				$query->execute(); 
				return true;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	
	public function edituserAddressDetails($addrId,$rowId, $add1, $add2, $country,$city, $state, $pin, $type,$panel_type)
	{
		if(!empty($addrId)){
			$query=$this->db->prepare("UPDATE address_details SET address1 = ?, address2=?, country=?, city=?, state=?, pin_code=?, address_type=?, admin_id = ?, panel_type=? WHERE id=?");
			$query->bindvalue(1, $add1);
			$query->bindValue(2, $add2);
			$query->bindValue(3, $country);
			$query->bindValue(4, $city);
			$query->bindValue(5, $state);
			$query->bindValue(6, $pin);
			$query->bindValue(7, $type);
			$query->bindValue(8, $rowId);
			$query->bindValue(9, $panel_type);
			$query->bindValue(10, $addrId);
			try{
				$query->execute(); 
				return true;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}else{
			$query=$this->db->prepare("insert into `address_details`(admin_id,address1,address2,country,city,state,pin_code,address_type,panel_type) values(?,?,?,?,?,?,?,?,?)");
			$query->bindvalue(1, $rowId);
			$query->bindValue(2, $add1);
			$query->bindValue(3, $add2);
			$query->bindValue(4, $country);
			$query->bindValue(5, $city);
			$query->bindValue(6, $state);
			$query->bindValue(7, $pin);
			$query->bindValue(8, $type);
			$query->bindValue(9, $panel_type);
			try{
				$query->execute(); 
				return true;
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function add_new_option($data){
		extract($data);
		if($table=='designation'){
			$query=$this->db->prepare("insert into designation (designation_name) VALUES(?)");
		}else{
			$query=$this->db->prepare("insert into department (department_name ) VALUES(?)");
		}
		
		$query->bindValue(1, $value);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getAllDesignation(){
		
		$query = $this->db->prepare("SELECT * FROM designation ORDER BY designation_id	ASC");
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getAllDepartment(){
		
		$query = $this->db->prepare("SELECT * FROM department ORDER BY department_id ASC");
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getDesignationById($id){
		
		$query = $this->db->prepare("SELECT * FROM designation WHERE designation_id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getDepartmentById($id){
		
		$query = $this->db->prepare("SELECT * FROM department WHERE department_id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function addUserInfo($rowId,$employee_id,$usrEmailArr)
	{
		$query=$this->db->prepare("UPDATE admin SET email_address = ?, user_id=?  WHERE admin_id = ?");
		$query->bindvalue(1, $usrEmailArr);
		$query->bindValue(2, $employee_id);
		$query->bindValue(3, $rowId);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
/*	-------------------------------------------------------------------------------------------------------------------*/	

/*	----------------------------------------------Employee Form Official Detail-----------------------------------------*/	
	public function addEmpOfficialDetail($empRowId, $designation, $department, $joingDate, $terminationDate,$userPass,$empType)
	{
		$joingDate = date('Y-m-d', strtotime($joingDate));
		
		if(trim($terminationDate) == '')
		{
			$terminationDate = '0000-00-00';
		}	
		else
		{
			$terminationDate = date('Y-m-d', strtotime($terminationDate));
		}
		
		//echo "UPDATE admin SET designation = '$designation', department = '$department', joining_date = '$joingDate', termination_date = '$terminationDate'  WHERE admin_id = $empRowId";
		//die;
		
		$user_id = $empRowId;
		$empId = $this->autogenerate_id($user_id, 'E');
		
		$query=$this->db->prepare("UPDATE admin SET designation = ?, department = ?, joining_date = ?, termination_date = ?, password=?, user_password=?, user_id = ?, employee_type = ? WHERE admin_id = ?");
		$query->bindvalue(1, $designation);
		$query->bindValue(2, $department);
		$query->bindValue(3, $joingDate);
		$query->bindValue(4, $terminationDate);
		$query->bindValue(5, base64_encode($userPass));
		$query->bindValue(6, $userPass);
		$query->bindValue(7, $empId);
		$query->bindValue(8, $empType);
		$query->bindValue(9, $empRowId);

		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function autogenerate_id($id, $prefix)
	{
		//$prefix=> E-employee, C-client
		$str = 'LiD'.$prefix;
		if(strlen($id) == 1)
		{
			$empId .= $str.'000'.$id;
		}
		else if(strlen($id) == 2)
		{
			$empId .= $str.'00'.$id;
		}
		else if(strlen($id) == 3)
		{
			$empId .= $str.'0'.$id;
		}
		else
		{
			$empId .= $str.$id;
		}
		return $empId;
	}
	
/*	----------------------------------------------Employee Form Baking Detail-----------------------------------------*/	
	public function addEmpBakingDetail($empRowId, $panNum, $accNumber, $accName, $bank, $branch, $ifsc)
	{
		$joingDate = date('Y-m-d', strtotime($joingDate));
		$terminationDate = date('Y-m-d', strtotime($terminationDate));
		//echo "UPDATE admin SET designation = '$designation', department = '$department', joining_date = '$joingDate', termination_date = '$terminationDate'  WHERE admin_id = $empRowId";
		//die;
		$query=$this->db->prepare("UPDATE admin SET pan_number = ?, account_number = ?, account_name = ?, bank = ?, branch = ?, ifsc= ?  WHERE admin_id = ?");
		$query->bindvalue(1, $panNum);
		$query->bindValue(2, $accNumber);
		$query->bindValue(3, $accName);
		$query->bindValue(4, $bank);
		$query->bindValue(5, $branch);
		$query->bindValue(6, $ifsc);
		$query->bindValue(7, $empRowId);

		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	
/*	----------------------------------------------Employee Form Document Detail-----------------------------------------*/	
	/* public function addEmpDocument($empRowId, $bioData, $eduProof, $appoint_letter, $pan_card, $photo, $addProof, $aadharCard, $passprt,,$addmore,$biofileName,$edufileName,$appointfileName,$panfileName,$photofileName,$addrprooffileName,$adhaarfileName,$passportfileName,$addmorefilename)
	{
		$joingDate = date('Y-m-d', strtotime($joingDate));
		$terminationDate = date('Y-m-d', strtotime($terminationDate));
		//echo "UPDATE admin SET designation = '$designation', department = '$department', joining_date = '$joingDate', termination_date = '$terminationDate'  WHERE admin_id = $empRowId";
		//die;
		$query=$this->db->prepare("UPDATE admin SET biodata = ?, education_proof = ?, appontment_letter = ?, pan_card = ?, photo = ?, address_proof= ?, adhar_card=?, passport=?  WHERE admin_id = ?");
		$query->bindvalue(1, $bioData);
		$query->bindValue(2, $eduProof);
		$query->bindValue(3, $appoint_letter);
		$query->bindValue(4, $pan_card);
		$query->bindValue(5, $photo);
		$query->bindValue(6, $addProof);
		$query->bindValue(7, $aadharCard);
		$query->bindValue(8, $passprt);
		$query->bindValue(9, $empRowId);

		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	} */
	public function addEmpDocument($admin_id,$docNam,$doc,$docid)
	{
		//$query=$this->db->prepare("UPDATE admin SET biodata = ?, education_proof = ?, appontment_letter = ?, pan_card = ?, photo = ?, address_proof= ?, adhar_card=?, passport=?  WHERE admin_id = ?");
		if(!empty($docid))
		{
			$query=$this->db->prepare("UPDATE `attached_document` SET `panel_id`=?, `name`=?, `doc`=?, `user_type`=? WHERE `id`=?");
			
			$query->bindValue(1, $admin_id);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Employee');
			$query->bindValue(5, $docid);
		}
		else
		{
			$query=$this->db->prepare("INSERT INTO `attached_document` (`panel_id`,`name`,`doc`,`user_type`) VALUES(?,?,?,?)");
			
			$query->bindValue(1, $admin_id);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Employee');
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function delete_emp_attachment($id)
	{
		
		$query=$this->db->prepare("DELETE from attached_document WHERE id=? AND user_type='Employee'");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function delte_items($id,$itemType) {
		if($itemType == 'contactNumbers' || $itemType == 'hotel_concern_person')
		{
			$table = 'phone_number';
		}
		
		$query = $this->db->prepare("DELETE FROM $table WHERE id = $id LIMIT 1");
		try{
			if($query->execute())
			{
				return true;
			}
				return false;
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getdocumentbyid($admin_id,$type)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND user_type=?");
		$query->bindValue(1, $admin_id);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getQueryById($id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getQueryByNumber($queryNum)
	{
		//echo "SELECT * FROM query WHERE query_no = '".$queryNum."'";
		$query = $this->db->prepare("SELECT * FROM query WHERE query_no = '".$queryNum."'");
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function user_list() {
		$query = $this->db->prepare("SELECT * FROM admin WHERE user_type = 'Employee' order by admin_id DESC");

		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getColName($table, $db)
	{
		$databaseName=$db;
		
		$query = $this->db->prepare("select column_name from information_schema.columns where table_name=? AND table_schema=?");
		
		$query->bindValue(1,$table);
		$query->bindValue(2,$databaseName);
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
			} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteUserById($id)
	{
		
		$query=$this->db->prepare("DELETE from admin WHERE admin_id=? AND user_type='Employee'");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function add_query($queryData)
	{
		extract($queryData);
		date_default_timezone_set('Asia/Kolkata');
		$qDate=date('Y-m-d h:i:s');
		if(!empty($queryId))
		{
			$query=$this->db->prepare("UPDATE query SET person_name=?, email=?, contact_no=?, message = ?, status=?, reason=?, details=?, employeeId=? WHERE id=?");
			
			$query->bindValue(1, $prsnName);
			$query->bindValue(2, $prsnEmail);
			$query->bindValue(3, $contactNum);
			$query->bindValue(4, $message);
			$query->bindValue(5, $status);
			$query->bindValue(6, $reason);
			$query->bindValue(7, $details);
			$query->bindValue(8, $userId);
			$query->bindValue(9, $queryId);
		}
		else
		{
			$queryGet=$this->db->prepare("SELECT id FROM query ORDER BY id DESC LIMIT 1");
			$queryGet->execute();
			$data = $queryGet->fetch(PDO::FETCH_ASSOC);
			$num = $data['id']+1;
			$queryNum = 'lidq00'.$num;
			//$source = $source;
			
			$query=$this->db->prepare("INSERT INTO query(query_no, person_name, email, contact_no, query_date, details,message,status,reason,source,employeeId,query_type) VALUES(?,?,?,?,?,?,?,?,?,?,?,?)");
			
			$query->bindValue(1, $queryNum);
			$query->bindValue(2, $prsnName);
			$query->bindValue(3, $prsnEmail);
			$query->bindValue(4, $contactNum);
			$query->bindValue(5, $qDate);
			$query->bindValue(6, $details);
			$query->bindValue(7, $message);
			$query->bindValue(8, $status);
			$query->bindValue(9, $reason);
			$query->bindValue(10, $source);
			$query->bindValue(11, $userId);
			$query->bindValue(12, $addedBy);
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function pull_query($query_id,$user_id)
	{
		$query1 = $this->db->prepare("SELECT first_name, middle_name , last_name FROM admin WHERE user_id=?");
		$query1->bindValue(1,$user_id);
		try{
				$query1->execute();
				$result = $query1->fetchAll(PDO::FETCH_ASSOC); 
			    } catch(PDOException $e){
				die($e->getMessage());
			}

		$person_name = $result[0]['first_name']." ".$result[0]['middle_name']." ".$result[0]['last_name'];
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET query_handled_by=?, query_pull=?, handler_id=?, status=? WHERE id=?");
			$query->bindValue(1, $person_name);
			$query->bindValue(2, 1);
			$query->bindValue(3, $user_id);
			$query->bindValue(4, 0);
			$query->bindValue(5, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function undoPull_query($query_id)
	{
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET query_handled_by=?, query_pull=?, handler_id=?, status=? WHERE id=?");
			$query->bindValue(1, '');
			$query->bindValue(2, 0);
			$query->bindValue(3, '');
			$query->bindValue(4, 4);
			$query->bindValue(5, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}


	public function undoConfirm_query($query_id)
	{
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET status=? WHERE id=?");
			$query->bindValue(1, 1);
			$query->bindValue(2, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function undoCanel_query($query_id)
	{
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET status=? WHERE id=?");
			$query->bindValue(1, 1);
			$query->bindValue(2, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function addvan($vanId,$vanNumber)
	{
		if($vanId=='')
		{
			$query=$this->db->prepare("INSERT INTO `vans`(van_number) VALUES(?)");
			$query->bindvalue(1, $vanNumber);
		}else{
			$query=$this->db->prepare("UPDATE `vans` SET van_number=? WHERE id=?");
			$query->bindvalue(1, $vanNumber);
			$query->bindvalue(2, $vanId);
		}
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllvan()
	{
		$query = $this->db->prepare("SELECT * FROM vans order by id DESC");

		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getvanbyid($van_id)
	{
		$query = $this->db->prepare("SELECT * FROM vans WHERE id = ?");
		$query->bindValue(1,$van_id);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deletevan($id)
	{
		$query=$this->db->prepare("DELETE from vans WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getUsrById($usrId) {
		$query = $this->db->prepare("SELECT * FROM admin WHERE admin_id = ?");
		$query->bindValue(1, $usrId);
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getaddressById($usrId,$type) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE admin_id = ?  AND address_type =?");
		$query->bindValue(1, $usrId);
		$query->bindValue(2, $type);

		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getAllAddressById($usrId,$type) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE admin_id = ?  AND panel_type =?");
		$query->bindValue(1, $usrId);
		$query->bindValue(2, $type);

		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getphoneById($usrId,$type) {
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE admin_id = ? AND type=?");
		$query->bindValue(1, $usrId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getAllPhoneNumberById($usrId) {
		$type_first  = 'Emergency';
		$type_second = 'personal';
		
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE panel_id = ? AND (type=? OR type=?) AND panel_name = ?");
		$query->bindValue(1, $usrId);
		$query->bindValue(2, $type_first);
		$query->bindValue(3, $type_second);
		$query->bindValue(4, 'employee');
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getPhoneNumbers($usrId, $panelName, $phoneType) {
		
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE panel_id = ? AND panel_name = ? AND type = ?");
		$query->bindValue(1, $usrId);
		$query->bindValue(2, $panelName);
		$query->bindValue(3, $phoneType);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function add_report($data)
	{
		extract($data);
		$var=$visitedDate;
		$visi_date=date('Y-m-d', strtotime($var));
		$datetime=date('Y-m-d')." ".date("h:i:s");
		if($reportId=='')
		{
			$query=$this->db->prepare("INSERT INTO `reporting`(van_number, visited_date, village_name, no_of_patien_register,	no_of_fem_patient, no_of_infant_child, no_of_inf_low_birth_weight, no_of_bpl_sc_st_patient,	patient_avail_digno_service, patien_refer_high_center, women_avail_anc_service, bpl_scstobc_wom_avail_anc_service, wom_anc_chec_avail_digno_service, wom_anc_chec_rec_tt_inje, anc_high_risk, wom_avail_pnc_service, pnc_ref_high_center, prsn_receiv_cond, prsn_receiv_oral_pills, prsn_counsel_for_fp, with_fever, diarrhea, uppr_resp_infection, susp_tuberculo, worm_infest, anemia, eye_cater, eye_infect, ear_discharge, dent_gum_disease, skin_diseas_leprosy, skin_diseas_pyoderma, high_blood_press, diabetes, pelv_infect_cervicit, pelv_infect_salping, sexu_trans_disease, goitre, flurosis, date) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			
		}else{
			$query=$this->db->prepare("UPDATE `reporting` SET van_number=?, visited_date=?, village_name=?, no_of_patien_register=?,	no_of_fem_patient=?, no_of_infant_child=?, no_of_inf_low_birth_weight=?, no_of_bpl_sc_st_patient=?,	patient_avail_digno_service=?, patien_refer_high_center=?, women_avail_anc_service=?, bpl_scstobc_wom_avail_anc_service=?, wom_anc_chec_avail_digno_service=?, wom_anc_chec_rec_tt_inje=?, anc_high_risk=?, wom_avail_pnc_service=?, pnc_ref_high_center=?, prsn_receiv_cond=?, prsn_receiv_oral_pills=?, prsn_counsel_for_fp=?, with_fever=?, diarrhea=?, uppr_resp_infection=?, susp_tuberculo=?, worm_infest=?, anemia=?, eye_cater=?, eye_infect=?, ear_discharge=?, dent_gum_disease=?, skin_diseas_leprosy=?, skin_diseas_pyoderma=?, high_blood_press=?, diabetes=?, pelv_infect_cervicit=?, pelv_infect_salping=?, sexu_trans_disease=?, goitre=?, flurosis=?, date=? WHERE id=?");
		}
			$query->bindvalue(1, $vanNumber);
			$query->bindvalue(2, $visi_date);
			$query->bindvalue(3, $nameOfVillVisited);
			$query->bindvalue(4, $patienRegisterd);
			$query->bindvalue(5, $femPatients);
			$query->bindvalue(6, $infantsChild);
			$query->bindvalue(7, $infWithLowBirWeight);
			$query->bindvalue(8, $bplScStObcPatients);
			$query->bindvalue(9, $patienAvailAnyDignosService);
			$query->bindvalue(10, $PatienReferToHighCenter);
			$query->bindvalue(11, $womenAvailAncService);
			$query->bindvalue(12, $bplScStObcWomAvailAncService);
			$query->bindvalue(13, $womForANCChecAvalDigoSer);
			$query->bindvalue(14, $womANCWhRecTTInjec);
			$query->bindvalue(15, $ANCWiHighRisk);
			$query->bindvalue(16, $womAvalPNCService);
			$query->bindvalue(17, $PNCRefHighCenter);
			$query->bindvalue(18, $prsnReceiveCond);
			$query->bindvalue(19, $prsnReceivOraPills);
			$query->bindvalue(20, $prsnCounselFp);
			$query->bindvalue(21, $withFever);
			$query->bindvalue(22, $diarrhea);
			$query->bindvalue(23, $upRespirInfec);
			$query->bindvalue(24, $suspTubercul);
			$query->bindvalue(25, $wormInfest);
			$query->bindvalue(26, $anemiHb);
			$query->bindvalue(27, $eyeCataract);
			$query->bindvalue(28, $eyeInfecInjury);
			$query->bindvalue(29, $earDischarge);
			$query->bindvalue(30, $dentGumDisease);
			$query->bindvalue(31, $skinDesLeprSuspect);
			$query->bindvalue(32, $skinDesPyodOthers);
			$query->bindvalue(33, $highBloodPres);
			$query->bindvalue(34, $diabetSugPresInUrin);
			$query->bindvalue(35, $pelvInfCervicit);
			$query->bindvalue(36, $pelvInfSalping);
			$query->bindvalue(37, $sexuTransDisease);
			$query->bindvalue(38, $goitre);
			$query->bindvalue(39, $flurosis);
			$query->bindvalue(40, $datetime);
			if($reportId !='')
			{
				$query->bindvalue(41, $reportId);
			}	
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function reporting_list()
	{
		$query = $this->db->prepare("SELECT * FROM reporting order by id DESC");

		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllReportById($id)
	{
		$query = $this->db->prepare("SELECT * FROM reporting WHERE id =?");
		$query->bindValue(1,$id);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteReportById($id)
	{
		$query=$this->db->prepare("DELETE from reporting WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function login($email,$password,$userType) {

		//global $bcrypt;  // Again make get the bcrypt variable, which is defined in init.php, which is included in login.php where this function is called
		if($userType == 'admin')
		{
			$query = $this->db->prepare("SELECT `email`, `password`,admin_id,user_type,employee_type,user_id FROM `admin` WHERE `email` = ? AND password=?");
		}
		else
		{
			$query = $this->db->prepare("SELECT `email`, `password`,admin_id,user_type,employee_type,user_id FROM `admin` WHERE `user_id` = ? AND password=?");
		}
		$query->bindValue(1, $email);
		$query->bindValue(2, base64_encode($password));

		try{
			
			$query->execute();
			$count=$query->rowCount();
			if($count)
			{
				//return true;
				return $query->fetchAll(PDO::FETCH_ASSOC);
			}
			else
			{
				return false;
			}
			
		
		}catch(PDOException $e){
			 
			die($e->getMessage());
		}
	
	}

	public function userdata($lang) {
		$query = $this->db->prepare("SELECT * FROM user_details WHERE lang=? order by id DESC");
		
		$query->bindValue(1, $lang);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getAllusers() {
		$query = $this->db->prepare("SELECT u.id,u.unique_id ,u.candidates_category,u.username,c.city_name_en,c.city_name_hi,
									 u.user_edu,u.user_mon_inc,u.user_curr_addr,u.user_mobile,u.date_of_birth,(select p.psName_en  from parichay_detail as p where p.id=u.psName) as psName_en,(select cd.city_name_en from city_detail as cd where cd.id=u.psCity) as psCityName_en ,
									 u.user_prof,u.lang FROM user_details as u
									 INNER JOIN city_detail as c
									 ON u.user_CITY = c.id
									 ORDER BY u.id 
									 DESC");
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getuserdetails($id,$lang) {
		$query = $this->db->prepare("SELECT * FROM user_details WHERE id=? AND lang=?");
		$query->bindValue(1, $id);
		$query->bindValue(2, $lang);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getuserdetailsbyId($id) {
		$query = $this->db->prepare("SELECT * FROM user_details WHERE id=?");
		$query->bindValue(1, $id);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getAllParichayData() {
		$query = $this->db->prepare("SELECT * FROM parichay_detail order by id DESC");		
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getparichayDetails($id) {
		$query = $this->db->prepare("SELECT * FROM parichay_detail where id =?");
		
		$query->bindValue(1, $id);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function parichay_name($city,$lang)
	{
		if($lang=='hi')
		{
		$query = $this->db->prepare("SELECT id, psName_hi FROM `parichay_detail` WHERE city_id=?");
		}else{
			$query = $this->db->prepare("SELECT id, psName_en FROM `parichay_detail` WHERE city_id=?");
		}
		$query->bindvalue(1, $city);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function editparichayData($city,$cast,$psName,$admin_id) {
	
		$query = $this->db->prepare("UPDATE parichay_detail SET city=?, cast=?, psName=? WHERE admin_id=? AND psName=?");
		$query->bindvalue(1, $city);
		$query->bindValue(2, $cast);
		$query->bindValue(3, $psName);
		$query->bindValue(4, $admin_id);
		$query->bindValue(5, $psName);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function city_exists($cityEnglish, $city_id)
	{
		//echo "select `city_name_en` from `city_detail` where `city_name_en`='$cityEnglish' AND id NOT IN ($city_id)";
		$query = $this->db->prepare("select `city_name_en` from `city_detail` where `city_name_en`=? AND id NOT IN (?) ");
		$query->bindValue(1,trim($cityEnglish));
		$query->bindValue(2,$city_id);
		try{
			$query->execute();
			$count=$query->rowCount();
			if($count)
			{
				return true;
			}
			else
			{
				return false;
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function addcity($cityEnglish,$cityHindi,$city_id)
	{
		if($city_id){
			$query=$this->db->prepare("UPDATE city_detail SET city_name_en=?, city_name_hi=? WHERE id=?");
		
		$query->bindvalue(1, trim($cityEnglish));
		$query->bindValue(2,  trim($cityHindi));
		$query->bindValue(3, $city_id);
		}
		else{
		$query=$this->db->prepare("insert into `city_detail`(city_name_en,city_name_hi) values(?,?)");
		
		$query->bindvalue(1, trim($cityEnglish));
		$query->bindValue(2, trim($cityHindi));
		}
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getcitydetail($id)
	{
		$query = $this->db->prepare("SELECT * FROM city_detail where id =?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllcity()
	{
		$query = $this->db->prepare("SELECT * FROM `city_detail` order by city_name_en ASC");
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getAllCast()
	{
		$query = $this->db->prepare("SELECT * FROM `parichay_casts` order by id DESC");
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deletecity($id)
	{
		$query=$this->db->prepare("DELETE from city_detail WHERE id=?");
		$query->bindValue(1, $id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function deleteparichaydata($id)
	{
		$query = $this->db->prepare("DELETE from parichay_detail WHERE id=?");
		$query->bindvalue(1, $id);
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteuserdata($id)
	{
		$query = $this->db->prepare("DELETE from user_details WHERE id=?");
		$query->bindvalue(1, $id);
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function deleteEventById($id)
	{
		$query=$this->db->prepare("DELETE from star_kid_event WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	
	public function update_user_data($col,$rttype,$p_id) {
		$query = $this->db->prepare("UPDATE user_details SET $col = ? WHERE id = ?");
		$query->bindValue(1, $rttype);
		$query->bindValue(2, $p_id);
		try{
			
			$query->execute();
			
			return true;
			
		}catch(PDOException $e){
			die($e->getMessage());
		}
		
	}
	
	public function getCityNameById($cityId)
	{
		$query = $this->db->prepare("SELECT * FROM `city_detail` WHERE id=? order by id DESC");
		$query->bindValue(1, $cityId);
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getCastNameById($castId)
	{
		$query = $this->db->prepare("SELECT * FROM `parichay_casts` WHERE id=? order by id DESC");
		$query->bindValue(1, $castId);
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function compressImage($ext,$uploadedfile,$path,$actual_image_name,$newwidth)
		{
			if($ext=="jpg" || $ext=="jpeg" )
			{
			$src = imagecreatefromjpeg($uploadedfile);
			}
			else if($ext=="png")
			{
			$src = imagecreatefrompng($uploadedfile);
			}
			else if($ext=="gif")
			{
			$src = imagecreatefromgif($uploadedfile);
			}
			else
			{
			$src = imagecreatefrombmp($uploadedfile);
			}
																			
			list($width,$height)=getimagesize($uploadedfile);
			$newheight=($height/$width)*$newwidth;
			$tmp=imagecreatetruecolor($newwidth,$newheight);
			imagecopyresampled($tmp,$src,0,0,0,0,$newwidth,$newheight,$width,$height);
			$filename = $path.$newwidth.'_'.$actual_image_name;
			imagejpeg($tmp,$filename,100);
			imagedestroy($tmp);
			return $newwidth.'_'.$actual_image_name;
		}
		
		 
		public function van_number($van_number)
		{
			//ECHO "SELECT * FROM `reporting` WHERE van_number LIKE '%$van_number%' order by id DESC";
			$query = $this->db->prepare("SELECT * FROM `reporting` WHERE van_number LIKE '%$van_number%' order by id DESC");
			$query->bindValue(1, $van_number);
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	
	public function filter_date($searchByVan,$fromDate,$toDate)
	{
		$fromdate=date('Y-m-d',strtotime($fromDate));
		$todate=date('Y-m-d',strtotime($toDate));
		
		$query = $this->db->prepare("SELECT * FROM `reporting` WHERE van_number LIKE '%$searchByVan%' AND (DATE_FORMAT(str_to_date(`visited_date`, '%Y-%m-%d'), '%Y-%m-%d')>='$fromdate' AND (DATE_FORMAT(str_to_date(`visited_date`, '%Y-%m-%d'), '%Y-%m-%d')<='$todate'))");
		$query->bindValue(1, $van_number);
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
			} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getItineraryDataByid($id){
		
		$query = $this->db->prepare("SELECT * FROM itinerary_management WHERE id=?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_vehicleitinerary(){
		
		$query = $this->db->prepare("SELECT * FROM itinerary_vehicle_master ORDER BY id");		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function country_exists($countryName) {
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `countrymaster` WHERE UPPER(country_name) = ?");
		$query->bindValue(1, $countryName);
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
	
	public function Add_country($countryName)
	{
		$query = $this->db->prepare("INSERT INTO `countrymaster` (`country_name`, `status`) VALUES (?,?)");	
		$query->bindValue(1, $countryName);
		$query->bindValue(2, 1);
		try{
			$query->execute();
			return $this->db->lastInsertId();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function state_exists($countryId, $stateName) {	
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `statemaster` WHERE countrymasterid = ? AND state_name = ?");
		$query->bindValue(1, $countryId);
		$query->bindValue(2, $stateName);
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
	
	public function Add_state($countryId, $stateName)
	{
		$query = $this->db->prepare("INSERT INTO `statemaster` (`countrymasterid`, `state_name`, `status`) VALUES (?,?,?)");	
		$query->bindValue(1, $countryId);
		$query->bindValue(2, $stateName);
		$query->bindValue(3, 1);
		try{
			$query->execute();
			return $this->db->lastInsertId();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function update_state($sId, $stateName)
	{
		$query = $this->db->prepare("UPDATE statemaster SET state_name = ? WHERE id = ?");	
		$query->bindValue(1, $stateName);
		$query->bindValue(2, $sId);
		try{
			$query->execute();
			return true;
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function update_city($cId, $cityName)
	{
		$query = $this->db->prepare("UPDATE citymaster SET city = ? WHERE id = ?");	
		$query->bindValue(1, $cityName);
		$query->bindValue(2, $cId);
		try{
			$query->execute();
			return true;
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function update_country($cId, $countryName)
	{
		$query = $this->db->prepare("UPDATE countrymaster SET country_name = ? WHERE id = ?");	
		$query->bindValue(1, $countryName);
		$query->bindValue(2, $cId);
		try{
			$query->execute();
			return true;
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_stats_list($cid) {
	
		$query = $this->db->prepare("SELECT * FROM `statemaster` WHERE countrymasterid= ?");
		$query->bindValue(1, $cid);
	
		try{
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function city_exists_add($countryId, $stateId, $cityName) {	
		$query = $this->db->prepare("SELECT COUNT(`id`) FROM `citymaster` WHERE statemasterid = ? AND city = ?");
		$query->bindValue(1, $stateId);
		$query->bindValue(2, $cityName);
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
	
	public function Add_city($countryId, $stateId, $cityName)
	{
		$query = $this->db->prepare("INSERT INTO `citymaster` (`statemasterid`, `city`, `status`) VALUES (?,?,?)");	
		$query->bindValue(1, $stateId);
		$query->bindValue(2, $cityName);
		$query->bindValue(3, 1);
		try{
			$query->execute();
			return $this->db->lastInsertId();
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_state_list_full() {
		
		$query = $this->db->prepare("SELECT * FROM `statemaster` ORDER BY id DESC");
		$query->bindValue(1, $cid);
	
		try{
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_countryBystateId($countryId) {
		
		$query = $this->db->prepare("SELECT country_name FROM `countrymaster` WHERE id = ?");
		$query->bindValue(1, $countryId);
	
		try{
			$query->execute();
			return $query->fetchColumn();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function get_city_list_full() {
	
		$query = $this->db->prepare("SELECT c.id, c.city as city, s.id as stateId, s.state_name as state, cc.id as countryId, cc.country_name as country FROM citymaster c, statemaster s, countrymaster cc where c.statemasterid = s.id AND s.countrymasterid = cc.id");
		//$query = $this->db->prepare("SELECT * FROM citymaster");
		$query->bindValue(1, $cid);
	
		try{
			$query->execute();
			return $query->fetchAll();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function cancel_query($query_id,$reason)
	{
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET cancel_reason=?, status=? WHERE id=?");
			$query->bindValue(1, $reason);
			$query->bindValue(2, 3);
			$query->bindValue(3, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	 
	public function getAllCancelledQuery($user_type, $empType, $queryType,$start_from,$record_per_page,$user_id)
	{
	 	$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND status = 3 ORDER BY id DESC LIMIT $start_from, $record_per_page");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getAllCancelledQueryResult($user_type, $empType, $queryType,$user_id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND status = 3 ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getAllConfirmedQuery($user_type, $empType, $queryType,$start_from,$record_per_page,$user_id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND status = 2 ORDER BY id DESC LIMIT $start_from, $record_per_page");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getAllConfirmedQueryResult($user_type, $empType, $queryType,$user_id)
	{
		$query = $this->db->prepare("SELECT * FROM query WHERE query_type = $queryType AND handler_id = '".$user_id."' AND status = 2 ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function confirm_query($query_id)
	{
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET status=? WHERE id=?");
			$query->bindValue(1, 2);
			$query->bindValue(2, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function record_per_page($record)
	{
		if(!empty($record))
		{
			$query=$this->db->prepare("UPDATE record_per_page SET per_page_record=? WHERE id=?");
			$query->bindValue(1, $record);
			$query->bindValue(2, 1);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function getPerPageRecord()
	{
		$query = $this->db->prepare("SELECT per_page_record FROM record_per_page WHERE id = 1");
		try{
			$query->execute();
			return $query->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}

   public function getALLDskEvent()
   {

   	    $query = $this->db->prepare("SELECT * FROM star_kid_event ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
   }

    public function mailing($id)
	{
		$query = $this->db->prepare("SELECT * FROM star_kid_event WHERE id =?");
		$query->bindValue(1,$id);
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function getEmployee()
	{
		$query = $this->db->prepare("SELECT first_name,middle_name,last_name,user_id FROM admin ORDER BY admin_id DESC");
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function AssignEmployee($user_id,$query_id)
	{
		$query1 = $this->db->prepare("SELECT first_name, middle_name , last_name FROM admin WHERE user_id=?");
		$query1->bindValue(1,$user_id);
		try{
				$query1->execute();
				$result = $query1->fetchAll(PDO::FETCH_ASSOC); 
			    } catch(PDOException $e){
				die($e->getMessage());
			}

		$person_name = $result[0]['first_name']." ".$result[0]['middle_name']." ".$result[0]['last_name'];
		if(!empty($query_id))
		{
			$query=$this->db->prepare("UPDATE query SET query_handled_by=?, query_pull=?, handler_id=?, status=? WHERE id=?");
			$query->bindValue(1, $person_name);
			$query->bindValue(2, 1);
			$query->bindValue(3, $user_id);
			$query->bindValue(4, 0);
			$query->bindValue(5, $query_id);
			try{
				$query->execute();
	            return true;
			    } catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}

	public function getALLDskLeads()
    {

   	    $query = $this->db->prepare("SELECT id,name,email,mobile_no,created_at FROM dsk_leads_detail ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
    }

    public function add_new_dsk_leads_detail($files)
    {
    	# code...
    }
}
?>