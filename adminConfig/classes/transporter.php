<?php  
class Transporter{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


public function transporter_client_detail($data) {
		extract($data);
		if($editTransporterId!="")
		{
			$query = $this->db->prepare("UPDATE `transporter` SET `hotal_name`=?, `base_currency`=?, `description`=? WHERE id=?");
			$query->bindValue(1, $transporter_hotel_name);
			$query->bindValue(2, $transporter_base_currency);
			$query->bindValue(3, $transporter_description);
			$query->bindValue(4, $editTransporterId);
			
			try{
				$query->execute();
				return $editTransporterId;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO `transporter`(`hotal_name`, `base_currency`, `description`) VALUES (?,?,?)");
			$query->bindValue(1, $transporter_hotel_name);
			$query->bindValue(2, $transporter_base_currency);
			$query->bindValue(3, $transporter_description);
			
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
	}
	
public function transporter_client_adderess($transId, $data, $client_type){
	@extract($data);
	$trClntAddrId='';
	if($editTransporterId!="")
	{
		
		for($i = 0; $i < sizeof($transporter_address1); $i++)
		{
			if($transClntAddrId[$i]!=0 || $transClntAddrId[$i]!="")
			{
				if($transClntAddrId[$i]!=0 || $transClntAddrId[$i]!="")
				{
					$trClntAddrId=$transClntAddrId[$i];
				}
				
				$sql = "UPDATE address_details SET panel_id=?, admin_id=?, address1=?, address2=?, country=?, city=?, state=?, pin_code=?, address_type=?, panel_type=?, status=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $transId);
				$query->bindValue(2, $transId);
				$query->bindValue(3, $transporter_address1[$i]);
				$query->bindValue(4, $transporter_address2[$i]);
				$query->bindValue(5, $trans_country[$i]);
				$query->bindValue(6, $transp_city[$i]);
				$query->bindValue(7, $trans_state[$i]);
				$query->bindValue(8, $trans_pincode[$i]);
				$query->bindValue(9, $client_type);
				$query->bindValue(10, 'Transporter');
				$query->bindValue(11, 1);
				$query->bindValue(12, $trClntAddrId);	
			}
			else
			{
				$sql = "insert into address_details(panel_id, admin_id, address1, address2, country=?, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $transId);
				$query->bindValue(2, $transId);
				$query->bindValue(3, $transporter_address1[$i]);
				$query->bindValue(4, $transporter_address2[$i]);
				$query->bindValue(5, $trans_country[$i]);
				$query->bindValue(6, $transp_city[$i]);
				$query->bindValue(7, $trans_state[$i]);
				$query->bindValue(8, $trans_pincode[$i]);
				$query->bindValue(9, $client_type);
				$query->bindValue(10, 'Transporter');
				$query->bindValue(11, 1);	
			}
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	else
	{
		for($i = 0; $i < sizeof($transporter_address1); $i++)
		{
			$sql = "insert into address_details(panel_id, admin_id, address1, address2, country, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $transId);
			$query->bindValue(2, $transId);
			$query->bindValue(3, $transporter_address1[$i]);
			$query->bindValue(4, $transporter_address2[$i]);
			$query->bindValue(5, $trans_country[$i]);
			$query->bindValue(6, $transp_city[$i]);
			$query->bindValue(7, $trans_state[$i]);
			$query->bindValue(8, $trans_pincode[$i]);
			$query->bindValue(9, $client_type);
			$query->bindValue(10, 'Transporter');
			$query->bindValue(11, 1);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	
}

public function transporter_client_phone_numbers($transId, $data, $client_type, $panel_name){
	@extract($data);
	//$count=count($clientPerNumId);
	$phoneNumberid='';
	if($editTransporterId!="")
	{
		for($i = 0; $i < sizeof($userPhone); $i++)
		{
			if($transClientNumId[$i]!=0 || $transClientNumId[$i]!="" || $concPrsnQryNumId[$i]!=0 || $concPrsnQryNumId[$i]!="")
			{
				if($transClientNumId[$i]!=0 || $transClientNumId[$i]!="")
				{
					$phoneNumberid=$transClientNumId[$i];
				}
				else
				{
					$phoneNumberid=$concPrsnQryNumId[$i];
				}
				
				$sql = "UPDATE phone_number SET contact_no=?, code=?, type=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $userPhone[$i]);
				$query->bindValue(2, $code[$i]);
				$query->bindValue(3, $client_type);
				$query->bindValue(4, $phoneNumberid);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e -> getMessage());
				}
			}
			else
			{
				$sql = "insert into phone_number(panel_id, contact_no, code, valid_no, type, panel_name) values(?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, (int)$transId);
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
			$sql = "insert into phone_number(panel_id, contact_no, code, valid_no, type,panel_name) values(?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $transId);
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

 public function vehicle_services_detail($transId,$data) {
	extract($data);
	$countVehiArr=count($vehitype);
	$countFleetImg=count($fleetImg);
	if($editTransporterId!="" || $editTransporterId!=0)
	{
		$query2 = $this->db->prepare("DELETE FROM transporter_image WHERE transporter_id=?");
		$query2->bindValue(1, $transId);
		$query2->execute();
		
		for($i=0; $i<$countVehiArr; $i++)
		{
			if($fleetVehicId[$i]!=0 || $fleetVehicId[$i]!="")
			{
				$query = $this->db->prepare("UPDATE `fleet_transporter` SET `trans_id`=?, `vehicle_type`=?, `vehicle_desc`=?,`aminities_facilites`=?,`units`=? WHERE id=?");
				$query->bindValue(1, $transId);
				$query->bindValue(2, $vehitype[$i]);
				$query->bindValue(3, $VDescription[$i]);
				$query->bindValue(4, $AminitiesF[$i]);
				$query->bindValue(5, $Units[$i]);
				$query->bindValue(6, $fleetVehicId[$i]);
				
				try{
				$query->execute();
				$fleetid=$fleetVehicId[$i];
				$arrFleetImg=explode(",",rtrim($fleetImg[$i],','));
				foreach($arrFleetImg as $k=>$value)
				{
					echo "INSERT INTO transporter_image (transporter_id,fleet_id,image) VALUES($transId,$fleetid,'$value')";
					echo "<br/>";
					$query3 = $this->db->prepare("INSERT INTO transporter_image (transporter_id,fleet_id,image) VALUES(?,?,?)");
					$query3->bindValue(1, $transId);
					$query3->bindValue(2, $fleetid);
					$query3->bindValue(3, $value);
					
					$query3->execute();
				}
				
				} catch (PDOException $e){
					 die($e->getMessage());
				}
			}
			else
			{
				$query = $this->db->prepare("INSERT INTO `fleet_transporter` (`trans_id`, `vehicle_type`, `vehicle_desc`,`aminities_facilites`,`units`) VALUES  (?,?,?,?,?)");
				$query->bindValue(1, $transId);
				$query->bindValue(2, $vehitype[$i]);
				$query->bindValue(3, $VDescription[$i]);
				$query->bindValue(4, $AminitiesF[$i]);
				$query->bindValue(5, $Units[$i]);
				
				try{
					$query->execute();
					$fleetID= $this->db->lastInsertId();
					$arrFleetImg=explode(",",rtrim($fleetImg[$i],','));
					foreach($arrFleetImg as $key=>$value)
					{
						//echo "INSERT INTO hotel_image (hotel_id,room_id,image) VALUES('".$hotelId."','".$roomID."','".$value."')";
						
						$query4 = $this->db->prepare("INSERT INTO transporter_image (transporter_id,fleet_id,image) VALUES(?,?,?)");
						$query4->bindValue(1, $transId);
						$query4->bindValue(2, $fleetID);
						$query4->bindValue(3, $value);
						
						$query4->execute();
					}
				} catch (PDOException $e){
					die($e->getMessage());
				}
			}	
		}
	}
	else
	{
		for($i=0; $i<$countVehiArr; $i++)
		{
			$query = $this->db->prepare("INSERT INTO `fleet_transporter` (`trans_id`, `vehicle_type`, `vehicle_desc`,`aminities_facilites`,`units`) VALUES  (?,?,?,?,?)");
			$query->bindValue(1, $transId);
			$query->bindValue(2, $vehitype[$i]);
			$query->bindValue(3, $VDescription[$i]);
			$query->bindValue(4, $AminitiesF[$i]);
			$query->bindValue(5, $Units[$i]);
			try{
				$query->execute();
				$fleetID= $this->db->lastInsertId();
				$arrFleetImg=explode(",",rtrim($fleetImg[$i],','));
				foreach($arrFleetImg as $key=>$value)
				{
					//echo "INSERT INTO hotel_image (hotel_id,room_id,image) VALUES('".$hotelId."','".$roomID."','".$value."')";
					
					$query1 = $this->db->prepare("INSERT INTO transporter_image (transporter_id,fleet_id,image) VALUES(?,?,?)");
					$query1->bindValue(1, $transId);
					$query1->bindValue(2, $fleetID);
					$query1->bindValue(3, $value);
					
					$query1->execute();
				}
				
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	}
	
}
	public function delete_transporter_doc_attachment($id)
	{
		
		$query=$this->db->prepare("DELETE from attached_document WHERE id=? AND user_type='Transporter'");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function transporter_doc_detail($transId,$docNam,$doc,$docid)
	{
		if(!empty($docid))
		{
			$query=$this->db->prepare("UPDATE `attached_document` SET `panel_id`=?, `name`=?, `doc`=?, `user_type`=? WHERE `id`=?");
			
			$query->bindValue(1, $transId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Transporter');
			$query->bindValue(5, $docid);
		}
		else
		{
			$query=$this->db->prepare("INSERT INTO `attached_document` (`panel_id`,`name`,`doc`,`user_type`) VALUES(?,?,?,?)");
			
			$query->bindValue(1, $transId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Transporter');
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
public function transporter_query_detail($transId,$data) {
		extract($_POST);
		
		$transporter_query_emails = '';
		foreach($userEmail as $mails){
			$transporter_query_emails .= $mails.',';
		}
		$transporter_query_allmailss = rtrim($transporter_query_emails,',');
		
	$transporter_query_emails = $transporter_query_allmailss;
		$query = $this->db->prepare("UPDATE transporter SET transporter_id=?, transporter_password=?, primary_email=?, additional_email_address=?  WHERE id=?");
		$query->bindValue(1, $transporter_id);
		$query->bindValue(2, $transporter_pass);
		$query->bindValue(3, $userEmail[0]);
		$query->bindValue(4, $transporter_query_emails);
		$query->bindValue(5, $transId);

	try{
			$query->execute();
			return $transId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
public function getFleetTransportByid($transId) {
	$query = $this->db->prepare("SELECT * FROM fleet_transporter WHERE trans_id = ?");
	$query->bindValue(1, $transId);
	
	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function concern_person_detail($transId,$data,$trType) {
	@extract($data);
	$countName=count($firstname);
	if($editTransporterId!="" || $editTransporterId!=0)
	{
		for($i=0; $i<$countName; $i++)
		{
			if($concernPrsnId[$i]!="")
			{
				
				$sql = "UPDATE concern_person_detail SET `admin_id`=?, title=?, first_name=?, middlename=?, lastname=?, type=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $transId);
				$query->bindValue(2, $title[$i]);
				$query->bindValue(3, $firstname[$i]);
				$query->bindValue(4, $middlename[$i]);
				$query->bindValue(5, $lastname[$i]);
				$query->bindValue(6, $trType);
				$query->bindValue(7, $concernPrsnId[$i]);
			}
			else
			{
				
				$sql = "insert into concern_person_detail(`admin_id`, title, first_name, middlename, lastname, type) values(?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $transId);
				$query->bindValue(2, $title[$i]);
				$query->bindValue(3, $firstname[$i]);
				$query->bindValue(4, $middlename[$i]);
				$query->bindValue(5, $lastname[$i]);
				$query->bindValue(6, $trType);
			}
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	else
	{
		for($i=0; $i<$countName; $i++)
		{
			$sql = "insert into concern_person_detail(`admin_id`, title, first_name, middlename, lastname, type) values(?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $transId);
			$query->bindValue(2, $title[$i]);
			$query->bindValue(3, $firstname[$i]);
			$query->bindValue(4, $middlename[$i]);
			$query->bindValue(5, $lastname[$i]);
			$query->bindValue(6, $trType);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
} 
	
public function transporter_bank_detail($transId,$data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE transporter SET pan_no=?, account_name=? , account_no=?, bank_name=? , branch_name=? , ifsc=?  WHERE id=?");
		$query->bindValue(1, $transporter_pan_no);
		$query->bindValue(2, $transporter_account_name);
		$query->bindValue(3, $transporter_account_no);
		$query->bindValue(4, $transporter_bank);
		$query->bindValue(5, $transporter_branch);
		$query->bindValue(6, $transporter_ifsc);
		$query->bindValue(7, $transId);

	try{
			$query->execute();
			return $transId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}


	public function transporter_date_detail($pan_file_name,$hote_photo_copy,$hotel_Contract_copy) {
		
		
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
	

	public function transporters_date_detail($fromdate,$todate,$description,$transId,$fleetDateid) {
		if(!empty($fleetDateid))
		{
			$query = $this->db->prepare("UPDATE transporter_dates_rate SET `trans_id`=?, `from_date`=?, `to_date`=?, `description`=? WHERE id=?");
			$query->bindValue(1, $transId);
			$query->bindValue(2, $fromdate);
			$query->bindValue(3, $todate);
			$query->bindValue(4, $description);
			$query->bindValue(5, $fleetDateid);
			try{
				$query->execute();
				return $fleetDateid;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO transporter_dates_rate (`trans_id`, `from_date`, `to_date`, `description`) VALUES (?,?,?,?)");
			$query->bindValue(1, $transId);
			$query->bindValue(2, $fromdate);
			$query->bindValue(3, $todate);
			$query->bindValue(4, $description);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}	
	}
	
	public function transporter_rates($transId,$date_Id,$fleetTransNameId,$fleetTransId,$fleetPrice,$fleetRateId) {
		if(!empty($fleetRateId))
		{
			//echo "UPDATE transporter_fleet_rates SET `transporter_id`='".$transId."', `date_id`='".$date_Id."', `fleet_name_id`='".$fleetTransNameId."', `fleet_type_id`='".$fleetTransId."', `price`='".$fleetPrice."' WHERE id='".$fleetRateId."'";
			
			$query = $this->db->prepare("UPDATE transporter_fleet_rates SET `transporter_id`=?, `date_id`=?, `fleet_name_id`=?, `fleet_type_id`=?, `price`=? WHERE id=?");
			$query->bindValue(1, $transId);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $fleetTransNameId);
			$query->bindValue(4, $fleetTransId);
			$query->bindValue(5, $fleetPrice);
			$query->bindValue(6, $fleetRateId);
			try{
				$query->execute();
				return $fleetRateId;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO transporter_fleet_rates (`transporter_id`, `date_id`, `fleet_name_id`, `fleet_type_id`, `price`) VALUES (?,?,?,?,?)");
			$query->bindValue(1, $transId);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $fleetTransNameId);
			$query->bindValue(4, $fleetTransId);
			$query->bindValue(5, $fleetPrice);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function deleteTransporterById($id){
		$query=$this->db->prepare("DELETE from transporter WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllTransporter(){
		$query = $this->db->prepare("SELECT * FROM transporter ORDER BY id DESC");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getTransporterById($id) {
		$query = $this->db->prepare("SELECT * FROM transporter WHERE id = ?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getTransporterClientAddressById($transId,$type) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE admin_id = ?  AND address_type =?");
		$query->bindValue(1, $transId);
		$query->bindValue(2, $type);

		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getTransClntNumByid($transId,$type) {
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE admin_id = ? AND type=?");
		$query->bindValue(1, $transId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getImagesById($fleetId,$transid)
	{
		$query = $this->db->prepare("SELECT * FROM transporter_image WHERE transporter_id=? AND fleet_id=?");
		
		$query->bindValue(1, $transid);
		$query->bindValue(2, $fleetId);

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getFleetVehicleByid($transId) {
		$query = $this->db->prepare("SELECT * FROM fleet_transporter WHERE trans_id = ?");
		$query->bindValue(1, $transId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getConcPrsnByid($transId,$type) {
		$query = $this->db->prepare("SELECT * FROM concern_person_detail WHERE admin_id = ? AND type=?");
		$query->bindValue(1, $transId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getDateRatesByid($transId) {
		$query = $this->db->prepare("SELECT * FROM transporter_dates_rate WHERE trans_id = ?");
		$query->bindValue(1, $transId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getTransporterRatesByid($transId,$dateId,$fleetVehiId) {
		$query = $this->db->prepare("SELECT * FROM transporter_fleet_rates WHERE transporter_id = ? AND date_id=? AND fleet_type_id=?");
		$query->bindValue(1, $transId);
		$query->bindValue(2, $dateId);
		$query->bindValue(3, $fleetVehiId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getdocumentbyid($transid,$type)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND user_type=?");
		$query->bindValue(1, $transid);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAllFleet()
	{
		$query = $this->db->prepare("SELECT * FROM transport_master_fleet_name");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteFleetImgById($id){
		$query=$this->db->prepare("DELETE from transporter_image WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function get_company_name(){
	$query = $this->db->prepare("SELECT tran.id,tran.hotal_name, cm.city FROM transporter as tran inner join address_details as ad inner join citymaster as cm on tran.id=ad.panel_id and ad.city=cm.id and ad.address_type='trans_clnt_prmnt_add'");

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
}


?>