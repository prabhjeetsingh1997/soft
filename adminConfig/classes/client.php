<?php  
class Client{
 	
	private $db;
	public function __construct($database) {
	    $this->db = $database;
	}


public function client_prsnl_detail($data) {
	extract($data);
	if(trim($dob_date) == '')
	{
		$dob_date = '0000-00-00';
	}	
	else
	{
		$dob_date = date('Y-m-d',strtotime($dob_date));
	}
	
	if(trim($anvsryData) == '')
	{
		$anvsryData = '0000-00-00';
	}	
	else
	{
		$anvsryData = date('Y-m-d',strtotime($anvsryData));	
	}
	
	$userType = 'Client';
	
	$ip='';
	if (!empty($_SERVER['HTTP_CLIENT_IP'])){
	  $ip=$_SERVER['HTTP_CLIENT_IP'];
	}elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
	  $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	}else{
	  $ip=$_SERVER['REMOTE_ADDR'];
	}
	
	
	$client_allmails = '';
	foreach($client_prsnl_email as $mails){
		$client_allmails .= $mails.',';
	}
	$client_allmailss = rtrim($client_allmails,',');
	$client_allmails = $client_allmailss;
	
	if($editId!="")
	{
		$query = "UPDATE clients SET name_perfix=?, first_name=?, middle_name=?, last_name=?, primary_email=?, additional_email_address=?, data_of_birth=?, anniversary_date=?, ip_address=? WHERE client_id=?";	
		$query = $this->db->prepare($query);
	
		$query->bindValue(1, $client_title);
		$query->bindValue(2, $f_name);
		$query->bindValue(3, $m_name);
		$query->bindValue(4, $l_name);
		$query->bindValue(5, $client_prsnl_email[0]);
		$query->bindValue(6, $client_allmails);
		$query->bindValue(7, $dob_date);
		$query->bindValue(8, $anvsryData);
		$query->bindValue(9, $ip);
		$query->bindValue(10, $editId);
	}
	else
	{
		//echo "insert into clients(name_perfix, first_name, middle_name, last_name, primary_email, additional_email_address, data_of_birth, anniversary_date, ip_address) values(?,?,?,?,?,?,?,?,?)";
		
		
		$query = "insert into clients(name_perfix, first_name, middle_name, last_name, primary_email, additional_email_address, data_of_birth, anniversary_date, ip_address) values(?,?,?,?,?,?,?,?,?)";	
		$query = $this->db->prepare($query);
	
		$query->bindValue(1, $client_title);
		$query->bindValue(2, $f_name);
		$query->bindValue(3, $m_name);
		$query->bindValue(4, $l_name);
		$query->bindValue(5, $client_prsnl_email[0]);
		$query->bindValue(6, $client_allmails);
		$query->bindValue(7, $dob_date);
		$query->bindValue(8, $anvsryData);
		$query->bindValue(9, $ip);	
	}
	try{
		$query->execute();
		 
		//die;
		if($editId!="")
		{
			return $editId;
		}
		else
		{
			return $lastId = $this->db->lastInsertId();
		}
	} catch (PDOException $e){
		die($e->getMessage());
	}
}

public function client_phone_numbers($cltid, $data, $client_type, $panel_name){
	@extract($data);
	//$count=count($clientPerNumId);
	//print_r($data);
	$phoneNumberid='';
	if($editId!="")
	{
		for($i = 0; $i < sizeof($userPhone); $i++)
		{
			if($clientPerNumId[$i]!=0 || $clientCompNumId[$i]!=0)
			{
				if($clientPerNumId[$i]!=0)
				{
					$phoneNumberid=$clientPerNumId[$i];
				}
				
				if($clientCompNumId[$i]!=0)
				{
					$phoneNumberid=$clientCompNumId[$i];
				}
				$sql = "UPDATE phone_number SET contact_no=?, code=?, type=?, panel_name=?, panel_id = ? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $userPhone[$i]);
				$query->bindValue(2, $code[$i]);
				$query->bindValue(3, $client_type);
				$query->bindValue(4, $panel_name);
				$query->bindValue(5, $cltid);
				$query->bindValue(6, $phoneNumberid);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e -> getMessage());
				}
			}
			else
			{
				echo $sql = "insert into phone_number(panel_id, contact_no, code, valid_no, type, panel_name) values(?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, (int)$cltid);
				$query->bindValue(2, $userPhone[$i]);
				$query->bindValue(3, $code[$i]);
				$query->bindValue(4, $last[$i]);
				$query->bindValue(5, $client_type);
				$query->bindValue(6, $panel_name);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e -> getMessage());
				}
			}
			
		}
	}
	else
	{
		for($i = 0; $i < sizeof($userPhone); $i++)
		{
			$sql = "insert into phone_number(panel_id, contact_no, code, valid_no, type, panel_name) values(?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, (int)$cltid);
			$query->bindValue(2, $userPhone[$i]);
			$query->bindValue(3, $code[$i]);
			$query->bindValue(4, $last[$i]);
			$query->bindValue(5, $client_type);
			$query->bindValue(6, $panel_name);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	
	
}

public function client_adderess_numbers($cltid, $data, $client_type){
	@extract($data);
	$clntAddrId='';
	if($editId!="")
	{
		
		for($i = 0; $i < sizeof($userAddline1); $i++)
		{
			if($clntPrsnlAddrId[$i]!=0 || $clntCompAddrId[$i]!=0 )
			{
				if($clntPrsnlAddrId[$i]!=0)
				{
					$clntAddrId=$clntPrsnlAddrId[$i];
				}
				
				if($clntCompAddrId[$i]!=0)
				{
					$clntAddrId=$clntCompAddrId[$i];
				}
				$sql = "UPDATE address_details SET panel_id=?, admin_id=?, address1=?, address2=?, country=?, city=?, state=?, pin_code=?, address_type=?, panel_type=?, status=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, (int)$cltid);
				$query->bindValue(2, (int)$cltid);
				$query->bindValue(3, $userAddline1[$i]);
				$query->bindValue(4, $userAddline2[$i]);
				$query->bindValue(5, $userCountry[$i]);
				$query->bindValue(6, $usercity[$i]);
				$query->bindValue(7, $userState[$i]);
				$query->bindValue(8, $userPinCode[$i]);
				$query->bindValue(9, $client_type);
				$query->bindValue(10, 'Client');
				$query->bindValue(11, 1);
				$query->bindValue(12, $clntAddrId);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e -> getMessage());
				}
			}
			else
			{
				$sql = "insert into address_details(panel_id, admin_id, address1, address2, country, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, (int)$cltid);
				$query->bindValue(2, (int)$cltid);
				$query->bindValue(3, $userAddline1[$i]);
				$query->bindValue(4, $userAddline2[$i]);
				$query->bindValue(5, $userCountry[$i]);
				$query->bindValue(6, $usercity[$i]);
				$query->bindValue(7, $userState[$i]);
				$query->bindValue(8, $userPinCode[$i]);
				$query->bindValue(9, $client_type);
				$query->bindValue(10, 'Client');
				$query->bindValue(11, 1);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e -> getMessage());
				}
			}
			
		}
	}
	else
	{
		for($i = 0; $i < sizeof($userAddline1); $i++)
		{
			$sql = "insert into address_details(panel_id, admin_id, address1, address2, country, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, (int)$cltid);
			$query->bindValue(2, (int)$cltid);
			$query->bindValue(3, $userAddline1[$i]);
			$query->bindValue(4, $userAddline2[$i]);
			$query->bindValue(5, $userCountry[$i]);
			$query->bindValue(6, $usercity[$i]);
			$query->bindValue(7, $userState[$i]);
			$query->bindValue(8, $userPinCode[$i]);
			$query->bindValue(9, $client_type);
			$query->bindValue(10, 'Client');
			$query->bindValue(11, 1);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	
}

public function client_company_detail($cltId, $data) {
		@extract($data);
		
		$client_allmails = '';
		foreach($client_company_email as $mails){
			$client_allmails .= $mails.',';
		}
		$client_allmailss = rtrim($client_allmails,',');
		$client_allmails = $client_allmailss;
		
		//echo "UPDATE clients SET organization=$Organization, job_title=$job_title, company_email_address=$client_allmails WHERE client_id=$cltId";
		
		$query = $this->db->prepare("UPDATE clients SET organization=?, job_title =?, company_email_address=? WHERE client_id =?");
		$query->bindValue(1, $Organization);
		$query->bindValue(2, $job_title);
		$query->bindValue(3, $client_allmails);
		$query->bindValue(4, $cltId);
	try{
			$query->execute();
			return $cltId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function client_offical_detail($cltid, $data) {
		global $objAdmin;
		extract($data);
		
		$clientId = $objAdmin->autogenerate_id($cltid, 'C');
		
		$query = $this->db->prepare("UPDATE clients SET refrence=? , salse_reprenstive=?, client_login_password=?, client_login_id=? WHERE client_id=?");
		$query->bindValue(1, $client_refrence);
		$query->bindValue(2, $sale_representative);
		$query->bindValue(3, $Client_user_pass);
		$query->bindValue(4, $clientId);
		$query->bindValue(5, $cltid);
	try{
			$query->execute();
			return $cltid;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function client_bank_detail($cltid, $data) {
		extract($data);
		//echo $sqlquery = "UPDATE clients SET pan_number=?, account_number=?, account_name=? , bank=? , branch=? , ifsc=? WHERE client_id='".$cltid."'";
		$query = $this->db->prepare("UPDATE clients SET pan_number=?, account_number=?, account_name=?, bank=?, branch=?, ifsc=? WHERE client_id=?");
		$query->bindValue(1, $client_panNo);
		$query->bindValue(2, $client_acc_no);
		$query->bindValue(3, $client_acc_name);
		$query->bindValue(4, $client_bank);
		$query->bindValue(5, $client_branch);
		$query->bindValue(6, $client_ifsc);
		$query->bindValue(7, $cltid);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function client_doc_detail($adminId,$docNam,$doc,$docid){
		
		if(!empty($docid))
		{
			$query=$this->db->prepare("UPDATE `attached_document` SET `panel_id`=?, `name`=?, `doc`=?, `user_type`=? WHERE `id`=?");
			
			$query->bindValue(1, $adminId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Client');
			$query->bindValue(5, $docid);
		}
		else
		{
			$query=$this->db->prepare("INSERT INTO `attached_document` (`panel_id`,`name`,`doc`,`user_type`) VALUES(?,?,?,?)");
			
			$query->bindValue(1, $adminId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Client');
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
		
	}
	public function delete_clnt_attachment($id)
	{
		
		$query=$this->db->prepare("DELETE from attached_document WHERE id=? AND user_type='Client'");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function client_list(){
		$query = $this->db->prepare("SELECT * FROM clients where partner_url is NULL  ORDER BY client_id  DESC");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getClientById($usrId) {
		$query = $this->db->prepare("SELECT * FROM clients WHERE client_id = ?");
		$query->bindValue(1, $usrId);
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getClientNumberByid($usrId,$type) {
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
	public function getClientAddressById($usrId,$type) {
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
	
	public function deleteClientById($id)
	{
		$query=$this->db->prepare("DELETE from clients WHERE client_id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
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
	
}


?>