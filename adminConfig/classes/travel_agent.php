<?php  
class Travel{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


public function travel_client_detail($data) {
		extract($data);
		if($editTravelid!=''){
			$query = $this->db->prepare("UPDATE travel_agent SET `hotal_name`=?, `base_currency`=?, `description`=? WHERE id=?");
			$query->bindValue(1, $travel_hotel_name);
			$query->bindValue(2, $travel_base_currency);
			$query->bindValue(3, $travel_description);
			$query->bindValue(4, $editTravelid);
			
			try{
				$query->execute();
				return $editTravelid;
			} catch (PDOException $e){
				die($e->getMessage());
			}
			
		}else{
			$query = $this->db->prepare("INSERT INTO travel_agent(`hotal_name`, `base_currency`, `description`, `partner_url`) VALUES (?,?,?,?)");
			$query->bindValue(1, $travel_hotel_name);
			$query->bindValue(2, $travel_base_currency);
			$query->bindValue(3, $travel_description);
			$query->bindValue(4, $domain);
			
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
	}


public function travel_query_detail($travelAgentId,$data) {
		extract($data);
		
		$travel_query_emails = '';
		foreach($userEmail as $mails){
			$travel_query_emails .= $mails.',';
		}
		$travel_query_allmailss = rtrim($travel_query_emails,',');
		
		$travel_query_emails = $travel_query_allmailss;
		
		$query = $this->db->prepare("UPDATE travel_agent SET travel_agentr_id=?, travel_agent_password=?, primary_email=?, additional_email_address=? WHERE id=?");
		$query->bindValue(1, $travel_id);
		$query->bindValue(2, $travel_pass);
		$query->bindValue(3, $userEmail[0]);
		$query->bindValue(4, $travel_query_emails);
		$query->bindValue(5, $travelAgentId);

	try{
			$query->execute();
			return $travelAgentId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function travel_agent_address_detail($address_id,$address,$address_line,$country,$city,$state,$pin_code,$travelAgentId,$addr_type) {
		
		if(!empty($address_id)){
			$query = $this->db->prepare("UPDATE address_details SET `address1`=?, `address2`=?, `country`=?, `city`=?, `state`=?,`pin_code`=?,`address_type`=?,`panel_type`=?,`admin_id`=?,`panel_id`=? WHERE id=?");
			$query->bindValue(1, $address);
			$query->bindValue(2, $address_line);
			$query->bindValue(3, $country);
			$query->bindValue(4, $city);
			$query->bindValue(5, $state);
			$query->bindValue(6, $pin_code);
			$query->bindValue(7, $addr_type);
			$query->bindValue(8, 'travel');
			$query->bindValue(9, $travelAgentId);
			$query->bindValue(10, $travelAgentId);
			$query->bindValue(11, $address_id);
			try{
				$query->execute();
				return $travelAgentId;
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}else{
			$query = $this->db->prepare("INSERT INTO address_details (`address1`, `address2`, `country`, `city`, `state`,`pin_code`,`address_type`,`panel_type`,`admin_id`,`panel_id`) VALUES (?,?,?,?,?,?,?,?,?,?)");
			$query->bindValue(1, $address);
			$query->bindValue(2, $address_line);
			$query->bindValue(3, $country);
			$query->bindValue(4, $city);
			$query->bindValue(5, $state);
			$query->bindValue(6, $pin_code);
			$query->bindValue(7, $addr_type);
			$query->bindValue(8, 'travel');
			$query->bindValue(9, $travelAgentId);
			$query->bindValue(10, $travelAgentId);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	} 
	public function addTravelServicePic($travelId,$serviceId,$imageName)
	{
		$query = $this->db->prepare("INSERT INTO travel_service_image (travel_id,service_id,image) VALUES(?,?,?)");
		$query->bindValue(1, $travelId);
		$query->bindValue(2, $serviceId);
		$query->bindValue(3, $imageName);
		
		try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			 die($e->getMessage());
		}
	}
	public function deleteTravelImgByTravelId($travelId){
		$query=$this->db->prepare("DELETE from travel_service_image WHERE travel_id=?");
		$query->bindValue(1,$travelId);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
 public function travel_agent_contact_detail($numberId,$userPhone,$code,$travelAgentId,$num_type) {
		
		if(!empty($numberId)){
			
			$query = $this->db->prepare("UPDATE phone_number SET `admin_id`=?,`contact_no`=?, `code`=?, `type`=? WHERE id=?");
			$query->bindValue(1, $travelAgentId);
			$query->bindValue(2, $userPhone);
			$query->bindValue(3, $code);
			$query->bindValue(4, $num_type);
			$query->bindValue(5, $numberId);
			try{
				$query->execute();
				return $travelAgentId;
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}else{
			$query = $this->db->prepare("INSERT INTO phone_number (`admin_id`,`contact_no`, `code`, `type`) VALUES  (?,?,?,?)");
			$query->bindValue(1, $travelAgentId);
			$query->bindValue(2, $userPhone);
			$query->bindValue(3, $code);
			$query->bindValue(4, $num_type);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	
} 
  public function agent_contact_detail($userPhone,$code,$number) {
		echo "INSERT INTO query_contact_details (`mobile`, `code`,`number`,`type`) VALUES  ($userPhone,$code,$number)";
		 $query = $this->db->prepare("INSERT INTO query_contact_details (`mobile`, `code`,`number`, `type`) VALUES  (?,?,?,?)");
		$query->bindValue(1, $userPhone);
		$query->bindValue(2, $code);
		$query->bindValue(3, $number);
		$query->bindValue(4, travel);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			 die($e->getMessage());
		}
		
	
}  
public function agent_email_detail($email) {
		echo "INSERT INTO personal_email (`email`,`type`) VALUES  ($email)";
		 $query = $this->db->prepare("INSERT INTO personal_email (`email`, `type`) VALUES  (?,?)");
		$query->bindValue(1, $email);
		$query->bindValue(2, travel);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			 die($e->getMessage());
		}
		}
  public function travel_agent_services_detail($srvDetailId,$stype,$sDescription,$AminitiesF,$Units,$Pics,$travelAgentId) {
		
		if(!empty($srvDetailId)){
			$query = $this->db->prepare("UPDATE service_details SET `stype`=?, `description`=?, `aminities`=?,`units`=?, `type`=?,`travel_id`=? WHERE id=?");
			$query->bindValue(1, $stype);
			$query->bindValue(2, $sDescription);
			$query->bindValue(3, $AminitiesF);
			$query->bindValue(4, $Units);
			$query->bindValue(5, 'travel');
			$query->bindValue(6, $travelAgentId);
			$query->bindValue(7, $srvDetailId);
			try{
				$query->execute();
				return $srvDetailId;
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}else{
			$query = $this->db->prepare("INSERT INTO service_details (`stype`, `description`, `aminities`,`units`, `type`,`travel_id`) VALUES  (?,?,?,?,?,?)");
			$query->bindValue(1, $stype);
			$query->bindValue(2, $sDescription);
			$query->bindValue(3, $AminitiesF);
			$query->bindValue(4, $Units);
			$query->bindValue(5, 'travel');
			$query->bindValue(6, $travelAgentId);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
}   
  public function travel_agent_detail($concPrsnId,$title,$firstname,$middle,$lastname,$travelAgentId) {
		
		if(!empty($concPrsnId)){
			$query = $this->db->prepare("UPDATE concern_person_detail SET `title`=?, `first_name`=?, `middlename`=?,`lastname`=?,`type`=?,`admin_id`=? WHERE id=?");
			$query->bindValue(1, $title);
			$query->bindValue(2, $firstname);
			$query->bindValue(3, $middle);
			$query->bindValue(4, $lastname);
			$query->bindValue(5, 'travel');
			$query->bindValue(6, $travelAgentId);
			$query->bindValue(7, $concPrsnId);
			
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}else{
			$query = $this->db->prepare("INSERT INTO concern_person_detail (`title`, `first_name`, `middlename`,`lastname`,`type`,`admin_id`) VALUES  (?,?,?,?,?,?)");
			$query->bindValue(1, $title);
			$query->bindValue(2, $firstname);
			$query->bindValue(3, $middle);
			$query->bindValue(4, $lastname);
			$query->bindValue(5, 'travel');
			$query->bindValue(6, $travelAgentId);
			
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	
}
	public function getTravelServiceByid($travelId) {
		$query = $this->db->prepare("SELECT * FROM service_details WHERE travel_id = ?");
		$query->bindValue(1, $travelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
public function travel_bank_detail($travelAgentId,$data) {
		extract($data);
		
		$query = $this->db->prepare("UPDATE travel_agent SET pan_no=?, account_name=? , account_no=?, bank_name=? , branch_name=? , ifsc=?  WHERE id=?");
		$query->bindValue(1, $travel_pan_no);
		$query->bindValue(2, $travel_account_name);
		$query->bindValue(3, $travel_account_no);
		$query->bindValue(4, $travel_bank);
		$query->bindValue(5, $travel_branch);
		$query->bindValue(6, $travel_ifsc);
		$query->bindValue(7, $travelAgentId);

	try{
			$query->execute();
			return $travelAgentId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function travel_doc_detail($travelid,$documentName,$document,$docId){
		if(!empty($docId))
		{
			//echo "UPDATE `attached_document` SET `panel_id`='".$travelid."', `name`='".$documentName."', `doc`='".$document."', `user_type`='Travel' WHERE `id`='".$docId."'";
			
			$query=$this->db->prepare("UPDATE `attached_document` SET `panel_id`=?, `name`=?, `doc`=?, `user_type`=? WHERE `id`=?");
			
			$query->bindValue(1, $travelid);
			$query->bindValue(2, $documentName);
			$query->bindValue(3, $document);
			$query->bindValue(4, 'Travel');
			$query->bindValue(5, $docId);
		}
		else
		{
			$query=$this->db->prepare("INSERT INTO `attached_document` (`panel_id`,`name`,`doc`,`user_type`) VALUES(?,?,?,?)");
			
			$query->bindValue(1, $travelid);
			$query->bindValue(2, $documentName);
			$query->bindValue(3, $document);
			$query->bindValue(4, 'Travel');
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getdocumentbyid($travelid,$type)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND user_type=?");
		$query->bindValue(1, $travelid);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
public function transporter_rate_detail($pan_file_name,$hote_photo_copy,$hotel_Contract_copy) {
		
		
		$query = $this->db->prepare("UPDATE hotel SET pan_card_copy=?, photo=? , cotract=? WHERE id='".$hotel_id."'");
		$query->bindValue(1, $pan_file_name);
		$query->bindValue(2, $hote_photo_copy);
		$query->bindValue(3, $hotel_Contract_copy);
	
	
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	
	public function travel_agent_date_detail($fromdate,$todate,$description,$travelAgentId,$editDateId) {
		
		if(!empty($editDateId)){
			//echo "UPDATE travler_dates_rate SET `from_date`='".$fromdate."', `to_date`='".$todate."', `description`='".$description."',`travel_id`='".$travelAgentId."' WHERE id='".$editDateId."'";
			
			$query = $this->db->prepare("UPDATE travler_dates_rate SET `from_date`=?, `to_date`=?, `description`=?,`travel_id`=? WHERE id=?");
			$query->bindValue(1, $fromdate);
			$query->bindValue(2, $todate);
			$query->bindValue(3, $description);
			$query->bindValue(4, $travelAgentId);
			$query->bindValue(5, $editDateId);
			try{
				$query->execute();
				return $editDateId;
			} catch (PDOException $e){
				die($e->getMessage());
			}
			
		}else{
			//echo "INSERT INTO travler_dates_rate (`from_date`, `to_date`, `description`,`travel_id`) VALUES ('".$fromdate."','".$todate."','".$description."','".$travelAgentId."')";
			
			$query = $this->db->prepare("INSERT INTO travler_dates_rate (`from_date`, `to_date`, `description`,`travel_id`) VALUES (?,?,?,?)");
			$query->bindValue(1, $fromdate);
			$query->bindValue(2, $todate);
			$query->bindValue(3, $description);
			$query->bindValue(4, $travelAgentId);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
			
		}
	}
	
	public function travler_date_rates($travelid,$date_Id,$serviceNameId,$serviceTypeId,$servicePrice,$serviceRateId) {
		
		if(!empty($serviceRateId))
		{
			//echo "UPDATE travel_service_rates SET `travel_id`='".$travelid."', `date_id`='".$date_Id."', `service_name_id`='".$serviceNameId."', `service_type_id`='".$serviceTypeId."', `price`='".$servicePrice."' WHERE id='".$serviceRateId."'";
			
			$query = $this->db->prepare("UPDATE travel_service_rates SET `travel_id`=?, `date_id`=?, `service_name_id`=?, `service_type_id`=?, `price`=? WHERE id=?");
			$query->bindValue(1, $travelid);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $serviceNameId);
			$query->bindValue(4, $serviceTypeId);
			$query->bindValue(5, $servicePrice);
			$query->bindValue(6, $serviceRateId);
			try{
				$query->execute();
				return $serviceRateId;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO travel_service_rates (`travel_id`, `date_id`, `service_name_id`, `service_type_id`, `price`) VALUES (?,?,?,?,?)");
			$query->bindValue(1, $travelid);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $serviceNameId);
			$query->bindValue(4, $serviceTypeId);
			$query->bindValue(5, $servicePrice);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function deleteTravelAgentById($id){
		$query=$this->db->prepare("DELETE from travel_agent WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function delte_travel_items($id) {
		
		$query = $this->db->prepare("DELETE FROM phone_number WHERE id = $id LIMIT 1");
		try{
			$query->execute();
			return true;
				
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function delte_travel_items1($id) {
		
		$query = $this->db->prepare("DELETE FROM concern_person_detail WHERE id = $id LIMIT 1");
		try{
			$query->execute();
			return true;
				
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}

    public function delte_travel_items2($id) {
		
		$query = $this->db->prepare("DELETE FROM phone_number WHERE id = $id LIMIT 1");
		try{
			$query->execute();
			return true;
				
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}



	

    public function getAllTravelAgent($domain){
		$query = $this->db->prepare("SELECT * FROM travel_agent WHERE partner_url='$domain' ORDER BY id DESC");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getTravelAgentById($id) {
		$query = $this->db->prepare("SELECT * FROM travel_agent WHERE id = ?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getTravelAgentClientAddressById($travelId,$type) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE admin_id = ?  AND address_type =?");
		$query->bindValue(1, $travelId);
		$query->bindValue(2, $type);
		

		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getTravelClntNumByid($travelId,$type) {
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE admin_id = ? AND type=?");
		$query->bindValue(1, $travelId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getServiceDetailByid($travelId) {
		$query = $this->db->prepare("SELECT * FROM service_details WHERE travel_id = ?");
		$query->bindValue(1, $travelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getConcPrsnByid($travelId,$type) {
		$query = $this->db->prepare("SELECT * FROM concern_person_detail WHERE admin_id = ? AND type=?");
		$query->bindValue(1, $travelId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getDateRatesByid($travelId) {
		$query = $this->db->prepare("SELECT * FROM travler_dates_rate WHERE travel_id = ?");
		$query->bindValue(1, $travelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getServiceImagesById($serviceId,$travelid)
	{
		$query = $this->db->prepare("SELECT * FROM travel_service_image WHERE travel_id=? AND service_id=?");
		
		$query->bindValue(1, $travelid);
		$query->bindValue(2, $serviceId);

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getTravelRatesByid($travelId,$dateId,$travelServiceId) {
		$query = $this->db->prepare("SELECT * FROM travel_service_rates WHERE travel_id = ? AND date_id=? AND service_type_id=?");
		$query->bindValue(1, $travelId);
		$query->bindValue(2, $dateId);
		$query->bindValue(3, $travelServiceId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getAllServiceName()
	{
		$query = $this->db->prepare("SELECT * FROM travel_master_service_name");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteServiceImgById($id){
		$query=$this->db->prepare("DELETE from travel_service_image WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function delete_travel_doc_attachment($id)
	{
		
		$query=$this->db->prepare("DELETE from attached_document WHERE id=? AND user_type='Travel'");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_company_name(){
		$query = $this->db->prepare("SELECT tr.id,tr.hotal_name, cm.city FROM travel_agent as tr inner join address_details as ad inner join citymaster as cm on tr.id=ad.panel_id and ad.city=cm.id and ad.address_type='travel_agent_client_address'");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
}

?>