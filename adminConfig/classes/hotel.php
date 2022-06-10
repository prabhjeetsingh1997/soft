<?php  
class Hotel{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


public function hotel_prsnl_detail($data) {
	extract($_POST);	
	/* $ckeckin_date = date('Y-m-d',strtotime($checkInDate));
	$checkout_date = date('Y-m-d',strtotime($checkOutdate)); */
	
	$ckeckin_date = $checkInTime;
	$checkout_date = $checkOutTime;
	
	if($editHotelId!="" || $editHotelId!=0)
	{
		$query = $this->db->prepare("UPDATE hotels SET `hotel_name`=?, `hotel_type`=?, `base_currency`=?, `star_rating`=?, `checkin_time`=?,`checkout_time`=?, `description`=?, hotel_amenity=? WHERE `hotel_id`=?");
		$query->bindValue(1, $hotel_name);
		$query->bindValue(2, $hotel_type);
		$query->bindValue(3, $hotel_currency);
		$query->bindValue(4, $hotel_star);
		$query->bindValue(5, $ckeckin_date);
		$query->bindValue(6, $checkout_date);
		$query->bindValue(7, $hotel_description);
		$query->bindValue(8, $Aminities);
		$query->bindValue(9, $editHotelId);
		
		try{
			$query->execute();
			return $editHotelId;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	else
	{
		$query = $this->db->prepare("INSERT INTO hotels(`hotel_name`, `hotel_type`, `base_currency`, `star_rating`, `checkin_time`,`checkout_time`, `description`,`hotel_amenity`) VALUES (?,?,?,?,?,?,?,?)");
		$query->bindValue(1, $hotel_name);
		$query->bindValue(2, $hotel_type);
		$query->bindValue(3, $hotel_currency);
		$query->bindValue(4, $hotel_star);
		$query->bindValue(5, $ckeckin_date);
		$query->bindValue(6, $checkout_date);
		$query->bindValue(7, $hotel_description);
		$query->bindValue(8, $Aminities);
		
		try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	}


public function hotel_more_detail($htlId,$data){
	global $objAdmin;
	extract($_POST);
	
	$hotelId = $objAdmin->autogenerate_id($htlId, 'H');
		
	$concern_person_allmails = '';
	foreach($userEmail as $mails){
		$concern_person_allmails .= $mails.',';
	}
	$concern_person_allmailss = rtrim($concern_person_allmails,',');
	$concern_person_allmails = $concern_person_allmailss;
		
	$query = $this->db->prepare("UPDATE hotels SET transport_id=?, primary_email=?, additional_email_address=?, hotel_user_pass=?, hotel_user_id =?  WHERE hotel_id=?");
	$query->bindValue(1, $transporter_id);
	$query->bindValue(2, $userEmail[0]);
	$query->bindValue(3, $concern_person_allmails);
	$query->bindValue(4, $hotel_pass);
	$query->bindValue(5, $hotelId);
	$query->bindValue(6, $htlId);

	try{
			$query->execute();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function hotel_photos($data){
		extract($data);
		$parr = array();
		for($i=0; $i< count($hPhotos); $i++)
		{
			$caption = $hImage[$i];
			if($hImage[$i] == '')
			{
				$caption = 'not_'.$i;
			}
			$parr[$caption] = $hPhotos[$i];
		}
		
		$photos = json_encode($parr);
		
		$query = $this->db->prepare("UPDATE hotels SET hotel_photos=? WHERE hotel_id=?");
		$query->bindValue(1, $photos);
		$query->bindValue(2, $hotel_id);

		try{
			$query->execute();
			return true;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}


public function hotel_bank_detail($hId,$data) {
	extract($data);

	$query = $this->db->prepare("UPDATE hotels SET pancard_no=?, account_no=? , account_name=?, bank_name=? , branch_name=? , ifsc_code=?  WHERE hotel_id=?");
	$query->bindValue(1, $hotel_pan_no);
	$query->bindValue(2, $hotel_account_no);
	$query->bindValue(3, $hotel_account_name);
	$query->bindValue(4, $hotel_bank);
	$query->bindValue(5, $hotel_branch);
	$query->bindValue(6, $hotel_ifsc);
	$query->bindValue(7, $hId);

	try{
		$query->execute();
		return true;
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

	public function hotel_doc_detail($hotelId,$docNam,$doc,$docid)
	{
		//$doc = str_replace(',,',',',$doc);
		$doc = ltrim(str_replace(',,',',',$doc), ',');
		if(!empty($docid))
		{
			$query=$this->db->prepare("UPDATE `attached_document` SET `panel_id`=?, `name`=?, `doc`=?, `user_type`=? WHERE `id`=?");
			
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Hotel');
			$query->bindValue(5, $docid);
		}
		else
		{
			$query=$this->db->prepare("INSERT INTO `attached_document` (`panel_id`,`name`,`doc`,`user_type`) VALUES(?,?,?,?)");
			
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $docNam);
			$query->bindValue(3, $doc);
			$query->bindValue(4, 'Hotel');
		}
		
		try{
			$query->execute();
            return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getdocumentbyid($hotel_id,$type)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND user_type=?");
		$query->bindValue(1, $hotel_id);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
		public function getdocumentbyid1($hotel_id,$type,$doc_name)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND name=? AND user_type=?");
		$query->bindValue(1, $hotel_id);
		$query->bindValue(2, $doc_name);
		$query->bindValue(3, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getdocumentbyid2($hotel_id,$type,$doc_name)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND name=? AND user_type=?");
		$query->bindValue(1, $hotel_id);
		$query->bindValue(2, $doc_name);
		$query->bindValue(3, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getdocumentbyid3($hotel_id,$type,$doc_name)
	{
		$query = $this->db->prepare("SELECT * FROM attached_document WHERE panel_id=? AND name=? AND user_type=?");
		$query->bindValue(1, $hotel_id);
		$query->bindValue(2, $doc_name);
		$query->bindValue(3, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function meal_plan_det($hotel_id,$meal_id)
	{
		$query = $this->db->prepare("SELECT from_date,to_date FROM hotel_dates_rate WHERE hotel_id=? AND meal_plan=?");
		$query->bindValue(1, $hotel_id);
		$query->bindValue(2, $meal_id);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function delete_hotel_doc_attachment($id)
	{
		
		$query=$this->db->prepare("DELETE from attached_document WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
public function hotel_address_detail($hotelId,$data,$hotelPermAddr) {
	extract($data);
	//print_r($data);
	$countAddr=count($hotel_address1);
	if($editHotelId!="" || $editHotelId!=0)
	{
		for($i=0; $i<$countAddr; $i++)
		{
			if($hotelPerAddrId[$i]!=0)
			{
				$sql = "UPDATE address_details SET panel_id=?, admin_id=?, address1=?, address2=?, country=?, city=?, state=?, pin_code=?, address_type=?, panel_type=?, status=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $hotelId);
				$query->bindValue(3, $hotel_address1[$i]);
				$query->bindValue(4, $hotel_address2[$i]);
				$query->bindValue(5, $hotel_country[$i]);
				$query->bindValue(6, $hotel_city[$i]);
				$query->bindValue(7, $hotel_state[$i]);
				$query->bindValue(8, $hotel_pincode[$i]);
				$query->bindValue(9, $hotelPermAddr);
				$query->bindValue(10, 'Hotel');
				$query->bindValue(11, 1);
				$query->bindValue(12, $hotelPerAddrId[$i]);
				
			}
			else
			{
				$sql = "insert into address_details(panel_id, admin_id, address1, address2, country, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $hotelId);
				$query->bindValue(3, $hotel_address1[$i]);
				$query->bindValue(4, $hotel_address2[$i]);
				$query->bindValue(5, $hotel_country[$i]);
				$query->bindValue(6, $hotel_city[$i]);
				$query->bindValue(7, $hotel_state[$i]);
				$query->bindValue(8, $hotel_pincode[$i]);
				$query->bindValue(9, $hotelPermAddr);
				$query->bindValue(10, 'Hotel');
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
		for($i=0; $i<$countAddr; $i++)
		{
			$sql = "insert into address_details(panel_id, admin_id, address1, address2, country, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $hotelId);
			$query->bindValue(3, $hotel_address1[$i]);
			$query->bindValue(4, $hotel_address2[$i]);
			$query->bindValue(5, $hotel_country[$i]);
			$query->bindValue(6, $hotel_city[$i]);
			$query->bindValue(7, $hotel_state[$i]);
			$query->bindValue(8, $hotel_pincode[$i]);
			$query->bindValue(9, $hotelPermAddr);
			$query->bindValue(10, 'Hotel');
			$query->bindValue(11, 1);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
} 
 public function hotel_contact_detail($hotelId,$data,$hotelPhoneType) {
	extract($data);
	if($type == 'add_hotel_more_detail')
	{
		$countPhone=count($userPhone);
		$countphoneArr=$countPhone;
	}
	else
	{
		$countPhone=count($hotelPhone);
		$countphoneArr=$countPhone;
	}
	
	if($editHotelId!="" || $editHotelId!=0)
	{
		for($i=0; $i<$countphoneArr; $i++)
		{
			if($hotelPerNumId[$i]!=0 || $concPrsnNumId[$i]!=0)
			{
				$sql = "UPDATE phone_number SET panel_id=?, contact_no=?, code=?, type=?, panel_name=? WHERE id=?";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $hotelId);
				if($type == 'add_hotel_more_detail')
				{
					$query->bindValue(2, $userPhone[$i]);
					$query->bindValue(3, $code[$i]);
				}
				else
				{
					$query->bindValue(2, $hotelPhone[$i]);
					$query->bindValue(3, $hotelCode[$i]);
				}
				$query->bindValue(4, $hotelPhoneType);
				$query->bindValue(5, 'hotel');
				if($concPrsnNumId[$i]!=0)
				{
					$query->bindValue(6, $concPrsnNumId[$i]);
				}else
				{
					$query->bindValue(6, $hotelPerNumId[$i]);
				}	
			}
			else
			{
				$sql = "insert into phone_number(panel_id, contact_no, code, type,panel_name) values(?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $hotelId);
				if($type == 'add_hotel_more_detail')
				{
					$query->bindValue(2, $userPhone[$i]);
					$query->bindValue(3, $code[$i]);
				}
				else
				{
					$query->bindValue(2, $hotelPhone[$i]);
					$query->bindValue(3, $hotelCode[$i]);
				}
				
				$query->bindValue(4, $hotelPhoneType);
				$query->bindValue(5, 'hotel');
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
		for($i=0; $i<$countphoneArr; $i++)
		{
			$sql = "insert into phone_number(panel_id, contact_no, code, type,panel_name) values(?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $hotelId);
			if($type == 'add_hotel_more_detail')
			{
				$query->bindValue(2, $userPhone[$i]);
				$query->bindValue(3, $code[$i]);
			}
			else
			{
				$query->bindValue(2, $hotelPhone[$i]);
				$query->bindValue(3, $hotelCode[$i]);
			}
			
			$query->bindValue(4, $hotelPhoneType);
			$query->bindValue(5, 'hotel');
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	
} 
  public function hotel_services_detail($hotelId,$data) {
	@extract($data);
	$countRoom=count($roomstype);
	$countRoomArr=$countRoom;
	$countRoomImg=count($roomImg);
	if($editHotelId!="" || $editHotelId!=0)
	{
		$query2 = $this->db->prepare("DELETE FROM hotel_image WHERE hotel_id=?");
		$query2->bindValue(1, $hotelId);
		$query2->execute();
						
		for($i=0; $i<$countRoomArr; $i++)
		{
			if($hotelRoomSerDetail[$i]!=0)
			{
				$query = $this->db->prepare("UPDATE `hotel_rooms` SET `hotel_id`=?, `room_type`=?, `room_description`=?,`aminities_facilites`=?,`units`=? WHERE id=?");
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $roomstype[$i]);
				$query->bindValue(3, $RDescription[$i]);
				$query->bindValue(4, $AminitiesF[$i]);
				$query->bindValue(5, $Units[$i]);
				$query->bindValue(6, $hotelRoomSerDetail[$i]);
				
				try{
					$query->execute();
					$roomid=$hotelRoomSerDetail[$i];
					$arrRoomImg=explode(",",rtrim($roomImg[$i],','));
					$arrImgId=explode(",",rtrim($roomPicId[$i],','));
					$countImgId=count($arrImgId);
					
					foreach($arrRoomImg as $k=>$value)
					{
						/* echo "INSERT INTO hotel_image (hotel_id,room_id,image) VALUES($hotelId,$roomid,'$value')";
						echo "<br/>"; */
						$query3 = $this->db->prepare("INSERT INTO hotel_image (hotel_id,room_id,image) VALUES(?,?,?)");
						$query3->bindValue(1, $hotelId);
						$query3->bindValue(2, $roomid);
						$query3->bindValue(3, $value);
						
						$query3->execute();
					}
					
				}catch (PDOException $e){
					 die($e->getMessage());
				}
			}
			else
			{
				$query = $this->db->prepare("INSERT INTO `hotel_rooms` (`hotel_id`, `room_type`, `room_description`,`aminities_facilites`,`units`) VALUES  (?,?,?,?,?)");
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $roomstype[$i]);
				$query->bindValue(3, $RDescription[$i]);
				$query->bindValue(4, $AminitiesF[$i]);
				$query->bindValue(5, $Units[$i]);
				
				try{
						$query->execute();
						$roomID = $this->db->lastInsertId();
						$arrRoomImg=explode(",",rtrim($roomImg[$i],','));
						foreach($arrRoomImg as $key=>$value)
						{
							$query4 = $this->db->prepare("INSERT INTO hotel_image (hotel_id,room_id,image) VALUES(?,?,?)");
							$query4->bindValue(1, $hotelId);
							$query4->bindValue(2, $roomID);
							$query4->bindValue(3, $value);
							
							$query4->execute();
						}
				}catch (PDOException $e){
					 die($e->getMessage());
				}
			}
		}
	}
	else
	{
		for($i=0; $i<$countRoomArr; $i++)
		{
			//echo "INSERT INTO `hotel_rooms` (`hotel_id`, `room_type`, `room_description`,`aminities_facilites`,`units`) VALUES  ('".$hotelId."','".$roomstype[$i]."','".$RDescription[$i]."','".$AminitiesF[$i]."','".$Units[$i]."')";
			
			$query = $this->db->prepare("INSERT INTO `hotel_rooms` (`hotel_id`, `room_type`, `room_description`,`aminities_facilites`,`units`) VALUES  (?,?,?,?,?)");
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $roomstype[$i]);
			$query->bindValue(3, $RDescription[$i]);
			$query->bindValue(4, $AminitiesF[$i]);
			$query->bindValue(5, $Units[$i]);
			
			try{
				$query->execute();
				$roomID= $this->db->lastInsertId();
				$arrRoomImg=explode(",",rtrim($roomImg[$i],','));
				foreach($arrRoomImg as $key=>$value)
				{
					//echo "INSERT INTO hotel_image (hotel_id,room_id,image) VALUES('".$hotelId."','".$roomID."','".$value."')";
					
					$query1 = $this->db->prepare("INSERT INTO hotel_image (hotel_id,room_id,image) VALUES(?,?,?)");
					$query1->bindValue(1, $hotelId);
					$query1->bindValue(2, $roomID);
					$query1->bindValue(3, $value);
					
					$query1->execute();
				}
				
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	}
	
}
public function get_hotel_name(){
	$query = $this->db->prepare("SELECT h.hotel_id,h.hotel_name, cm.city FROM hotels as h inner join address_details as ad inner join citymaster as cm on h.hotel_id=ad.panel_id and ad.city=cm.id and ad.address_type='hotel_permanent_addr'");

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}

public function hotel_aminities_facility_detail($hotelId,$data) {
	extract($data);
	$count=count($Aminities);
	if($editHotelId!="" || $editHotelId!=0)
	{
		for($i=0; $i<$count; $i++)
		{
			$aminity=$Aminities[$i];
			if($amiFacility[$i]!=0)
			{
				$query = $this->db->prepare("UPDATE aminities_facilites SET `hotel_id`=?, `aminities_facilites`=?,`status`=? WHERE id=?");
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $aminity);
				$query->bindValue(3, 1);
				$query->bindValue(4, $amiFacility[$i]);
			}
			else
			{
				$query = $this->db->prepare("INSERT INTO aminities_facilites (`hotel_id`, `aminities_facilites`,`status`) VALUES  (?,?,?)");
				$query->bindValue(1, $hotelId);
				$query->bindValue(2, $aminity);
				$query->bindValue(3, 1);
			}
			try{
				$query->execute();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	}
	else
	{
		for($i=0; $i<$count; $i++)
		{
			$aminity=$Aminities[$i];
			$query = $this->db->prepare("INSERT INTO aminities_facilites (`hotel_id`, `aminities_facilites`,`status`) VALUES  (?,?,?)");
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $aminity);
			$query->bindValue(3, 1);
			try{
				$query->execute();
			} catch (PDOException $e){
				 die($e->getMessage());
			}
		}
	}
	
}

public function getAllHotelRoom()
{
	$query = $this->db->prepare("SELECT * FROM hotel_master_room_name");

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function getAllHotelRoom_edit($hotelId,$dateId)
{
	$query = $this->db->prepare("SELECT distinct(room_name),room_name_id FROM hotel_room_rates WHERE hotel_id = ? AND date_id=? ORDER BY id ASC");
	$query->bindValue(1, $hotelId);
	$query->bindValue(2, $dateId);
	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function getImagesById($roomId,$hotelid)
{
	$query = $this->db->prepare("SELECT * FROM hotel_image WHERE hotel_id=? AND room_id=?");
	
	$query->bindValue(1, $hotelid);
	$query->bindValue(2, $roomId);

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function getHotelImages($hotelid)
{
	$query = $this->db->prepare("SELECT * FROM hotel_image WHERE hotel_id=?");
	
	$query->bindValue(1, $hotelid);

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function getRoomPrice($roomNameId,$roomTypeId)
{
	$query = $this->db->prepare("SELECT * FROM hotel_room_rates WHERE room_name_id=? AND room_type_id=?");
	
	$query->bindValue(1, $roomNameId);
	$query->bindValue(2, $roomTypeId);

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
public function getHotelRoomTypeByid($hotelId)
{
	//echo "SELECT * FROM hotel_rooms WHERE hotel_id=$hotelId";
	$query = $this->db->prepare("SELECT * FROM hotel_rooms WHERE hotel_id=?");
	
	$query->bindValue(1, $hotelId);

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
    public function hotel_date_detail_check($fromdate,$todate,$mealType,$editHotelId)
	{
		//$query = $this->db->prepare("SELECT * FROM hotel_dates_rate WHERE hotel_id=? and from_date=? and to_date=? and meal_plan=?");
	
	   $query = $this->db->prepare("SELECT from_date,to_date,meal_plan FROM hotel_dates_rate WHERE  hotel_id ='$editHotelId' and meal_plan='$mealType'");
	   
	   
	  
	   
		// $query = $this->db->prepare("SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$fromdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$fromdate')) && ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$todate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$todate')) and  hotel_id = '$editHotelId' and meal_plan='$mealType'");

		
	try{
			
			$query->execute();
			
				//return true;
			return $query->fetchAll(PDO::FETCH_ASSOC);
				
			
			
		
		}catch(PDOException $e){
			 
			die($e->getMessage());
		}
	}
   

	public function hotel_date_detail($fromdate,$todate,$description,$hId,$hotelDateid,$mealType) {
		
		if(!empty($hotelDateid))
		{
			$query = $this->db->prepare("UPDATE hotel_dates_rate SET `hotel_id`=?, `from_date`=?, `to_date`=?, `description`=?,meal_plan=? WHERE id=?");
			$query->bindValue(1, $hId);
			$query->bindValue(2, $fromdate);
			$query->bindValue(3, $todate);
			$query->bindValue(4, $description);
			$query->bindValue(5, $mealType);
			$query->bindValue(6, $hotelDateid);
			try{
				$query->execute();
				return $hotelDateid;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO hotel_dates_rate (`hotel_id`, `from_date`, `to_date`, `description`,`meal_plan`) VALUES (?,?,?,?,?)");
			$query->bindValue(1, $hId);
			$query->bindValue(2, $fromdate);
			$query->bindValue(3, $todate);
			$query->bindValue(4, $description);
			$query->bindValue(5, $mealType);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function hotel_rate_detail($hotelId,$date_Id,$hotelRoomNameId,$hotelRoomId,$roomPrice,$hotelRateId,$hotenRoomName) {
		
		if(!empty($hotelRateId))
		{
			
			$query = $this->db->prepare("UPDATE hotel_room_rates SET `hotel_id`=?, `date_id`=?, `room_name_id`=?, `room_type_id`=?, `price`=?, `room_name`=? WHERE id=?");
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $hotelRoomNameId);
			$query->bindValue(4, $hotelRoomId);
			$query->bindValue(5, $roomPrice);
			$query->bindValue(6, $hotenRoomName);
			$query->bindValue(7, $hotelRateId);
			try{
				$query->execute();
				return $hotelRateId;
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
		else
		{
			$query = $this->db->prepare("INSERT INTO hotel_room_rates (`hotel_id`, `date_id`, `room_name_id`, `room_type_id`, `price`,`room_name`) VALUES (?,?,?,?,?,?)");
			$query->bindValue(1, $hotelId);
			$query->bindValue(2, $date_Id);
			$query->bindValue(3, $hotelRoomNameId);
			$query->bindValue(4, $hotelRoomId);
			$query->bindValue(5, $roomPrice);
			$query->bindValue(6, $hotenRoomName);
			try{
				$query->execute();
				return $lastrID = $this->db->lastInsertId();
			} catch (PDOException $e){
				die($e->getMessage());
			}
		}
			
	}
	
	public function concern_person_detail($hotlId,$data,$hType){
	extract($data);
	$countName=count($firstname);
	if($editHotelId!="" || $editHotelId!=0)
	{
		for($i=0; $i<$countName; $i++)
		{
			if($concPrsnid[$i]!=0)
			{
				
				$query = $this->db->prepare("UPDATE concern_person_detail SET `admin_id`=?, title=?, first_name=?, middlename=?, lastname=?, type=? WHERE id=?");
				
				$query->bindValue(1, $hotlId);
				$query->bindValue(2, $title[$i]);
				$query->bindValue(3, $firstname[$i]);
				$query->bindValue(4, $middlename[$i]);
				$query->bindValue(5, $lastname[$i]);
				$query->bindValue(6, $hType);
				$query->bindValue(7, $concPrsnid[$i]);
			}
			else
			{
				$sql = "insert into concern_person_detail(`admin_id`, title, first_name, middlename, lastname, type) values(?,?,?,?,?,?)";	
				$query = $this->db->prepare($sql);
				$query->bindValue(1, $hotlId);
				$query->bindValue(2, $title[$i]);
				$query->bindValue(3, $firstname[$i]);
				$query->bindValue(4, $middlename[$i]);
				$query->bindValue(5, $lastname[$i]);
				$query->bindValue(6, $hType);
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
			$query->bindValue(1, $hotlId);
			$query->bindValue(2, $title[$i]);
			$query->bindValue(3, $firstname[$i]);
			$query->bindValue(4, $middlename[$i]);
			$query->bindValue(5, $lastname[$i]);
			$query->bindValue(6, $hType);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
} 
	public function getAllHotel(){
		$query = $this->db->prepare("SELECT * FROM hotels ORDER BY hotel_id DESC");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteHotelById($id){
		$query=$this->db->prepare("DELETE from hotels WHERE hotel_id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function deleteRoomImgById($id){
		$query=$this->db->prepare("DELETE from hotel_image WHERE id=?");
		$query->bindValue(1,$id);
		try{
			$query->execute(); 
			return true;
		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getHotelById($id) {
		$query = $this->db->prepare("SELECT * FROM hotels WHERE hotel_id = ?");
		$query->bindValue(1, $id);
		
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
}
	public function getHotelAddressById($hotelId,$type) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE admin_id = ?  AND address_type =?");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $type);

		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getNumberByid($hotelId,$type) {
		$query = $this->db->prepare("SELECT * FROM phone_number WHERE panel_id = ? AND type=?");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $type);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getHotelAddress($hotelId) {
		$query = $this->db->prepare("SELECT * FROM address_details WHERE panel_id = $hotelId AND panel_type='Hotel' AND address_type = 'hotel_permanent_addr' LIMIT 1");
		try{
			$query->execute();
            return $query->fetch(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	
	public function getHotelRoomServicesByid($hotelId) {
		$query = $this->db->prepare("SELECT * FROM hotel_rooms WHERE hotel_id = ?");
		$query->bindValue(1, $hotelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getAminitFacilityByid($hotelId) {
		$query = $this->db->prepare("SELECT * FROM aminities_facilites WHERE hotel_id = ?");
		$query->bindValue(1, $hotelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getConcPrsnByid($hotelId) {
		$query = $this->db->prepare("SELECT * FROM concern_person_detail WHERE admin_id = ?");
		$query->bindValue(1, $hotelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function getDateRatesByid($hotelId) {
		$query = $this->db->prepare("SELECT * FROM hotel_dates_rate WHERE hotel_id = ?");
		$query->bindValue(1, $hotelId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function delte_date_rates($dateId) {
		$query = $this->db->prepare("DELETE FROM hotel_dates_rate WHERE id = ? LIMIT 1");
		$query->bindValue(1, $dateId);
		
		try{
			if($query->execute())
			{
				$query1 = $this->db->prepare("DELETE FROM hotel_room_rates WHERE date_id = ?");
				$query1->bindValue(1, $dateId);
				$query1->execute();
			}
			return true;
		    } catch(PDOException $e){
			die($e->getMessage());
		}

	}
	public function delte_rates_items($rateId) {
		
		$temp = explode(',',$rateId);
		$postedIds = "'" . implode ( "', '", $temp ) . "'";
		$ids = "(" . $postedIds . ")";
		
		$query = $this->db->prepare("DELETE FROM hotel_room_rates WHERE id IN $ids");
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
	public function delte_hotel_items($id,$itemType) {
		if($itemType == 'hotelPhone' || $itemType == 'hotel_concern_person')
		{
			$table = 'phone_number';
		}
		else if($itemType == 'hotelRoom')
		{
			$table = 'hotel_rooms';
		}
		else if($itemType == 'hConcernedPerson')
		{
			$table = 'concern_person_detail';
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
	public function getDateRatesByid_calculate($hotelId, $startdate, $enddate) {
		
		
		//echo $hotelId.'<br/><br/>';
		if($hotelId != '0')
		{
			$startdate = date('Y-m-d',strtotime($startdate));
			$enddate = date('Y-m-d',strtotime($enddate));
			
			//echo "SELECT * FROM hotel_dates_rate WHERE hotel_id = $hotelId AND ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startdate')) && ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$enddate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))";
			
			//$query = $this->db->prepare("SELECT * FROM hotel_dates_rate WHERE hotel_id = $hotelId AND ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startdate')) || ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$enddate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))");
			
			//echo "select * from (SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate')) || ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId";
			// echo $query = "select * from (SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(from_date, '%m-%d')<='$startdate') && (DATE_FORMAT(to_date,'%m-%d')>='$enddate')) || ((DATE_FORMAT(from_date,'%m-%d')<='$startdate') && (DATE_FORMAT(to_date,'%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId";exit;
			$query = $this->db->prepare("select * from (SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(to_date,'%Y-%m-%d')>='$enddate')) || ((DATE_FORMAT(from_date,'%Y-%m-%d')<='$startdate') && (DATE_FORMAT(to_date,'%Y-%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId");
			
			//$query->bindValue(1, $hotelId);
			
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function calculate_price_dateData($hotelId, $startdate, $enddate) {
		
		//echo $hotelId.'<br/><br/>';
		if($hotelId != '0')
		{
		
			$startdate1 = date('Y-m-d',strtotime($startdate));
			$enddate1 = date('Y-m-d',strtotime($enddate));
			// echo $startdate1;	
			//echo "SELECT * FROM hotel_dates_rate WHERE hotel_id = $hotelId AND ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startdate')) OR ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$enddate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))";
			
			//$queryDate = " AND ('$startdate' between from_date and to_date) AND ('$enddate' between from_date and to_date)";
			//echo "select * from (SELECT * FROM hotel_dates_rate WHERE ('$startdate' between from_date and to_date) OR ('$enddate' between from_date and to_date)) as d where d.hotel_id = $hotelId";
			$queryDate = " OR ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$startdate1') && (DATE_FORMAT(to_date, '%Y-%m-%d')<='$enddate1'))";
			// echo $query = "SELECT * FROM hotel_dates_rate as d where d.hotel_id = $hotelId $queryDate";exit;
			$query = $this->db->prepare("SELECT * FROM hotel_dates_rate as d where d.hotel_id = $hotelId $queryDate");
			
			// $query = $this->db->prepare("select * from (SELECT * FROM hotel_dates_rate WHERE ('$startdate' between from_date and to_date) OR ('$enddate' between from_date and to_date)) as d where d.hotel_id = $hotelId");
			
			//$query = $this->db->prepare("select * from (SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate')) || ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId");
			
			//$query->bindValue(1, $hotelId);
			
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	public function getDateRatesByDatenid_calculate($hotelId, $startdate, $enddate, $selDate) {
		//echo $selDate;exit;
		//echo $hotelId.'<br/><br/>';
		$sel_date1=explode('-',$selDate);
		$start_date=$sel_date1['0'].'-'.$sel_date1['1'].'-'.$sel_date1['2'];
		//echo $start_date;exit;
		if($hotelId != '0')
		{
			
			$startdate = date('Y-m-d',strtotime($startdate));
			$enddate = date('Y-m-d',strtotime($enddate));
			
			//$queryDate = " AND '$searchDate' between hdr.from_date and hdr.to_date";
			$queryDate = " AND ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$start_date') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$start_date')) && ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$start_date') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$start_date'))";
			//echo "select * from (SELECT * FROM hotel_dates_rate WHERE '$selDate' between from_date and to_date) as d where d.hotel_id = $hotelId";
			
			
			//$query = "select * from (SELECT * FROM hotel_dates_rate as d where d.hotel_id = $hotelId $queryDate";
			//echo $query = "SELECT * FROM hotel_dates_rate as d where d.hotel_id = $hotelId $queryDate";exit;
			$query = $this->db->prepare("SELECT * FROM hotel_dates_rate as d where d.hotel_id = $hotelId $queryDate");
			//$query = $this->db->prepare("select * from (SELECT * FROM hotel_dates_rate WHERE '".$selDate."' between from_date and to_date) as d where d.hotel_id = $hotelId");
			
			//$query->bindValue(1, $hotelId);
			
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	
	public function getDateRatesDesc($hotelId, $startdate, $enddate, $userSelectMealType) {
		
		//echo $hotelId.'<br/><br/>';
		if($hotelId != '0')
		{
			$startdate = date('Y-m-d',strtotime($startdate));
			$enddate = date('Y-m-d',strtotime($enddate));
			
			if($userSelectMealType == '' || $userSelectMealType == 'null')
			{
			}
			else
			{
				$mealPalanCond = " AND d.meal_plan IN ($userSelectMealType)";
			}				
			//echo "select * from (SELECT description, hotel_id, meal_plan FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate')) || ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId $mealPalanCond";
			
			$query = $this->db->prepare("select * from (SELECT description, hotel_id, meal_plan FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate')) || ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))) as d where d.hotel_id = $hotelId $mealPalanCond");
			//$query->bindValue(1, $hotelId);
			
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	
	public function getMealPlanByhotelId($hotelId, $startdate, $enddate, $searchType, $selectedDate) {
		
		if($hotelId != '')
		{
			if($searchType == 'Package')
			{
				$selectedDate1=explode('-',$selectedDate);
				$startDate=$selectedDate1[0].'-'.$selectedDate1[1].'-'.$selectedDate1[2];
				//$queryDate=" AND ((DATE_FORMAT(from_date, '%m-%d')<=$startDate) && (DATE_FORMAT(to_date, '%m-%d')>=$startDate)) && ((DATE_FORMAT(from_date, '%m-%d')<=$startDate) && (DATE_FORMAT(to_date, '%m-%d')>=$startDate))";
				// $queryDate = " AND ((DATE_FORMAT(hdr.from_date, '%m-%d')<='$startDate') && (DATE_FORMAT(hdr.to_date, '%m-%d')>='$startDate')) && ((DATE_FORMAT(hdr.from_date, '%m-%d')<='$startDate') && (DATE_FORMAT(hdr.to_date, '%m-%d')>='$startDate'))";
				//$queryDate = "'$selectedDate' between from_date and to_date";
				//echo "SELECT * FROM(SELECT * FROM hotel_dates_rate WHERE '$selectedDate' between from_date and to_date) as d WHERE d.hotel_id = $hotelId" real query;
				
				// echo $query = "SELECT * FROM hotel_dates_rate as d where d.hotel_id = '$hotelId' AND ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$selectedDate') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$selectedDate')) && ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$selectedDate') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$selectedDate'))";exit;
				$query = $this->db->prepare("SELECT * FROM hotel_dates_rate as d where d.hotel_id = '$hotelId' AND ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$selectedDate') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$selectedDate')) && ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$selectedDate') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$selectedDate'))");
				// $query = $this->db->prepare("SELECT * FROM(SELECT * FROM hotel_dates_rate as d ON d.hotel_id = $hotelId $queryDate");
				// $query="SELECT * FROM hotel_dates_rate as d where d.hotel_id = 230 AND ((DATE_FORMAT(from_date, '%m-%d')<='09-22') && (DATE_FORMAT(to_date, '%m-%d')>='09-22')) && ((DATE_FORMAT(from_date, '%m-%d')<='09-22') && (DATE_FORMAT(to_date, '%m-%d')>='09-22'))";
			}
			else
			{
				$startdate = date('Y-m-d',strtotime($startdate));
				$enddate = date('Y-m-d',strtotime($enddate));
					
				$query = $this->db->prepare("SELECT * FROM(SELECT * FROM hotel_dates_rate WHERE ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startdate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startdate')) && ((DATE_FORMAT(str_to_date(from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$enddate') && (DATE_FORMAT(str_to_date(to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$enddate'))) as d WHERE d.hotel_id = $hotelId");
				//$query->bindValue(1, $hotelId);
			}
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}

	}
	
	public function getHotelRatesByid($hotelId,$dateId,$hotelRoomid) {
		$query = $this->db->prepare("SELECT * FROM hotel_room_rates WHERE hotel_id = ? AND date_id=? AND room_type_id=?");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $dateId);
		$query->bindValue(3, $hotelRoomid);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getHotelRoomRatesFilter($hotelId,$dateIds) {
		//echo "SELECT * FROM hotel_room_rates WHERE hotel_id = $hotelId AND date_id=$dateId AND room_name_id=$hotelRoomid AND room_type_id = $roomTypeId";
		//echo "SELECT * FROM hotel_room_rates WHERE hotel_id = $hotelId AND date_id IN ($dateIds) ";
		//echo $hotelId;exit;
		if($hotelId != '0')
		{
		//echo $query = "SELECT * FROM hotel_room_rates WHERE hotel_id = '$hotelId' AND date_id IN ($dateIds) ";exit;
			$query = $this->db->prepare("SELECT * FROM hotel_room_rates WHERE hotel_id = ? AND date_id IN ($dateIds) ");
			$query->bindValue(1, $hotelId);
			//$query->bindValue(2, $dateId);
			
			try{
				$query->execute();
				return $query->fetchAll(PDO::FETCH_ASSOC);
				} catch(PDOException $e){
				die($e->getMessage());
			}
		}
	}
	
	
	public function getHotelRoomTypeRatesFilter($hotelId,$dateId,$roomTypeId) {
		//echo "SELECT * FROM hotel_room_rates WHERE hotel_id = $hotelId AND date_id=$dateId AND room_name_id=$hotelRoomid AND room_type_id = $roomTypeId";
		$query = $this->db->prepare("SELECT hr.*, h.hotel_name, hh.room_type FROM hotel_room_rates hr INNER JOIN hotels h ON hr.hotel_id = h.hotel_id INNER JOIN hotel_rooms hh ON hr.room_type_id = hh.id WHERE hr.hotel_id = ? AND hr.date_id=? AND hr.room_type_id = ? AND (hr.room_name = 'Extra Breakfast' || hr.room_name = 'Lunch' || hr.room_name = 'Dinner')");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $dateId);
		$query->bindValue(3, $roomTypeId);
		
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getMasterRoomNames() {
		$query = $this->db->prepare("SELECT * FROM hotel_master_room_name");
		try{
			$query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
		    } catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	
public function search_hotel($data){
		extract($data);
		$startDate='';
		$endDate ='';
		
		$sDate = explode('/',$startdate);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$enddate);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		//$startdate.'--------------'.$enddate;
		
		$startDate=date('Y-m-d',strtotime($startdate));
		$endDate=date('Y-m-d',strtotime($enddate));
		$queryType=strtolower($queryType);
		$Origin=strtolower($Origin);
		$destination=strtolower($destination);
		$hotelCategory=strtolower($hotelCategory);
		$hotelName=strtolower($hotelName);
		
		if($startDate == '1970-01-01' || $startDate == '' || $endDate == '1970-01-01' || $endDate == ''){
			$startDate='';
			$endDate ='';
		}
		else
		{
			$queryDate = " AND ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startDate')) && ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$endDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$endDate'))";
		}
		
		if($destination != '')
		{
			$destinationsql = " d.city LIKE '%$destination%'";
		}
		
		if($queryType != '')
		{
			$queryTypesql = " AND lower(ad.panel_type) LIKE '%$queryType%'";
		}
		
		
		$query = $this->db->prepare("SELECT * FROM (SELECT hotels.*,ad.city,hdr.from_date,hdr.to_date,ad.panel_type FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $queryTypesql $queryDate) as d WHERE $destinationsql");
		
		
		try{
			$query->execute();
			$dataArr = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$hotelwithImgAll = array();
			/* echo '<pre>';
			print_r($dataArr);
			die; */
			foreach($dataArr as $data)
			{
				$hotelwithImg = array();
				$hotelwithImg['hotel_id'] = $data['hotel_id'];
				$hotelwithImg['hotel_name'] = $data['hotel_name'];
				$hotelwithImg['hotel_type'] = $data['hotel_type'];
				$hotelwithImg['star_rating'] = $data['star_rating'];
				$hotelwithImg['from_date'] = $data['from_date'];
				$hotelwithImg['to_date'] = $data['to_date'];
				$hotelwithImg['city'] = $data['city'];
				$hotelwithImg['hotel_photos'] = $data['hotel_photos'];
				$hotelId = $data['hotel_id'];
				$seleQuery = $this->db->prepare("SELECT image FROM hotel_image WHERE hotel_id = $hotelId LIMIT 1");
				$seleQuery->execute();
				$dataImgArr = $seleQuery->fetch(PDO::FETCH_ASSOC);
				$hotelwithImg['image'] = $dataImgArr['image'];
				
				$hotelwithImgAll[] = $hotelwithImg;
			}
			
			return $hotelwithImgAll;
			
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getHotelCities(){
		//echo "SELECT DISTINCT(city) FROM address_details ad INNER JOIN hotels h ON ad.panel_id = h.hotel_id WHERE ad.panel_type = 'Hotel' AND ad.city != ''";
		//die;
		$query = $this->db->prepare("SELECT DISTINCT(city) FROM address_details ad INNER JOIN hotels h ON ad.panel_id = h.hotel_id WHERE ad.panel_type = 'Hotel' AND ad.city != ''");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getAllRoomType(){
		$query = $this->db->prepare("SELECT DISTINCT room_type FROM hotel_rooms ORDER BY hotel_id DESC");

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getPriceByroomCategory($hotelId,$roomNameId,$roomTypeId){
		$query = $this->db->prepare("SELECT * FROM hotel_room_rates WHERE hotel_id=? AND room_name_id=? AND room_type_id=?");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $roomNameId);
		$query->bindValue(3, $roomTypeId);
		
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getRoomTypeById($id)
	{
		$query = $this->db->prepare("SELECT * FROM hotel_master_room_name WHERE id=?");
		
		$query->bindValue(1, $id);

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function search_package($data){
		extract($data);
		$startDate='';
		$endDate ='';
		//print_r($data);
		//die;
		//Array ( [searchrooms] => 3 [queryType] => Package [country] => Array ( [0] => 119 ) [state] => Array ( [0] => 187 ) [city] => Array ( [0] => 1993 ) [destination] => [startdate] => 24/03/2017 [enddate] => 27/03/2017 [stayDuration] => 3 [adults] => Array ( [0] => 2 [1] => 2 [2] => 1 ) [child] => Array ( [0] => 2 [1] => 2 [2] => 0 ) [child_age] => Array ( [0] => 5,9 [1] => 9,11 [2] => ) )
		
		$duration = $stayDuration+1;
		
		$sDate = explode('/',$startdate);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$enddate);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		//$startdate.'--------------'.$enddate;
		
		$startDate=date('Y-m-d',strtotime($startdate));
		$endDate=date('Y-m-d',strtotime($enddate));
		$country = implode(',',$country);
		//$state = implode(',',$state);
		//$city = implode(',',$city);
		$countCity = count($city);
		$iteneryIdArr = array();
		if($countCity == '0')
		{
			foreach($state as $stateIds)
			{
				$query = $this->db->prepare("SELECT * FROM itinerary_management WHERE state like '%$stateIds%'");
				$query->execute();
				$dataArr = $query->fetchAll(PDO::FETCH_ASSOC);
				foreach($dataArr as $iten)
				{
					$iteneryIdArr[] = $iten['id'];
				}
			}
		}
		else
		{
			//$itenArr = array();
			foreach($city as $cityIds)
			{
				$cityQuery = "SELECT id FROM itinerary_management WHERE city like '%$cityIds%'";
				$query = $this->db->prepare($cityQuery);
				$query->execute();
				$itdataArr = $query->fetchAll(PDO::FETCH_ASSOC);
				//print_r($itdataArr);
				foreach($itdataArr as $cityData)
				{
					$iteneryIdArr[] = $cityData['id'];
				}
			}
			//print_r($iteneryIdArr);
		}
		//print_r($iteneryIdArr);
		$iteneryIdArr = array_unique($iteneryIdArr);
		//print_r($iteneryIdArr);
		$d = array();
		if(count($iteneryIdArr) < 1)
		{
			return $d;
		}
		$iteneryIds = implode(',',$iteneryIdArr);
		$queryA = "SELECT * FROM itinerary_management WHERE id IN($iteneryIds) AND duration = $duration";
		$query1 = $this->db->prepare($queryA); 
		
		try{
			$query1->execute();
			return $dataArr = $query1->fetchAll(PDO::FETCH_ASSOC);
			
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getCitiesById($ids)
	{
		$query = $this->db->prepare("SELECT * FROM citymaster WHERE id IN ($ids)");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getCitiesById1()
	{
		$query = $this->db->prepare("SELECT * FROM citymaster");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getSatesById($ids)
	{
		$query = $this->db->prepare("SELECT * FROM statemaster WHERE id IN ($ids)");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getCountryById($ids)
	{
		$query = $this->db->prepare("SELECT * FROM countrymaster WHERE id IN ($ids)");
		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getIteneraryById($id)
	{
		$query = $this->db->prepare("SELECT * FROM itinerary_management WHERE id = ?");
		
		$query->bindValue(1, $id);

		try{
			$query->execute();
			return $query->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getIteneraryVehicleCost($iteneraryId)
	{
		$query = $this->db->prepare("SELECT vc.*, vm.vehicle_name FROM itinerary_vehicle_cost vc INNER JOIN itinerary_vehicle_master vm ON vc.vehicle_id = vm.id WHERE vc.itenary_id = ?");
		
		$query->bindValue(1, $iteneraryId);

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function getIteneraryInterestCost($iteneraryId)
	{
		$query = $this->db->prepare("SELECT * FROM itinerary_interest_cost WHERE itenary_id = ?");
		
		$query->bindValue(1, $iteneraryId);

		try{
			$query->execute();
			return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
	/* public function getPackageHotels($data){
		extract($data);
		$startDate='';
		$endDate ='';
		//print_r($data);
		//die;
		//Array ( [searchrooms] => 1 [queryType] => Package [country] => 119 [state] => 202 [city] => 3174 [destination] => [startdate] => 18/08/2016 [enddate] => 19/08/2016 [stayDuration] => 1 [adults] => 1 [child] => 0 [child_age] => [] => )
		$cityStr = '';
		if(count($data['city'])>0)
		{
			$cityStr = ' AND (';
			
			if(is_array($city))
			{
				$cities = implode(',',$city);
				
				foreach($cities as $cityVal)
				{
					//print_r($city);
					//echo '<br/>';
					//$cityName = $cityVal['city'];
					$cityStr .= "ad.city LIKE '%$cityVal%' OR ";
				}
				
				$cityStr = rtrim($cityStr,' OR ');
			}
			else
			{
				//$cities = $city;
				$cityStr .= "ad.city LIKE '%$city%'";
			}
			
			$cityStr .= ')';
		}
		
		$sDate = explode('/',$startdate);
		$startdate = $sDate[2].'-'.$sDate[1].'-'.$sDate[0];
		
		$eDate = explode('/',$enddate);
		$enddate = $eDate[2].'-'.$eDate[1].'-'.$eDate[0];
		//$startdate.'--------------'.$enddate;
		
		$startDate=date('Y-m-d',strtotime($startdate));
		$endDate=date('Y-m-d',strtotime($enddate));
		$queryType=strtolower($queryType);
		$Origin=strtolower($Origin);
		$destination=strtolower($destination);
		$hotelCategory=strtolower($hotelCategory);
		$hotelName=strtolower($hotelName);
		
		if($startDate == '1970-01-01' || $startDate == '' || $endDate == '1970-01-01' || $endDate == ''){
			$startDate='';
			$endDate ='';
		}
		else
		{
			$queryDate = " AND ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startDate')) && ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$endDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$endDate'))";
		}
		
	
		
		//echo "SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate";
		
		$query = $this->db->prepare("SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate");
		
		try{
			$query->execute();
			$dataArr = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$hotelwithImgAll = array();
			
			foreach($dataArr as $data)
			{
				$hotelwithImg = array();
				$hotelwithImg['hotel_id'] = $data['hotel_id'];
				$hotelwithImg['hotel_name'] = $data['hotel_name'];
				$hotelwithImg['hotel_type'] = $data['hotel_type'];
				$hotelwithImg['star_rating'] = $data['star_rating'];
				$hotelwithImg['from_date'] = $data['from_date'];
				$hotelwithImg['to_date'] = $data['to_date'];
				$hotelwithImg['city'] = $data['city'];
				$hotelId = $data['hotel_id'];
				$seleQuery = $this->db->prepare("SELECT image FROM hotel_image WHERE hotel_id = $hotelId LIMIT 1");
				$seleQuery->execute();
				$dataImgArr = $seleQuery->fetch(PDO::FETCH_ASSOC);
				$hotelwithImg['image'] = $dataImgArr['image'];
				
				$hotelwithImgAll[] = $hotelwithImg;
			}
			
			return $hotelwithImgAll;
			
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	} */
	
	public function getHotelsByCity($cityId, $startdate, $enddate){
		
		$cityStr = '';
		if($cityId != '')
		{
			$cityStr = " AND ad.city = '$cityId'";
		}
		
		$startDate=date('Y-m-d',strtotime($startdate));
		$endDate=date('Y-m-d',strtotime($enddate));
		
		if($startDate == '1970-01-01' || $startDate == '' || $endDate == '1970-01-01' || $endDate == ''){
			$startDate='';
			$endDate ='';
		}
		else
		{
			$queryDate = " AND ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$startDate')) && ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')<='$endDate') && (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')>='$endDate'))";
		}
	
		//echo "SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type, hdr.meal_plan FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate";
		
		$query = $this->db->prepare("SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type, hdr.meal_plan FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate");
		
		try{
			$query->execute();
			$dataArr = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$hotelwithImgAll = array();
			// echo '<pre>';
			// print_r($dataArr);
			// die; 
			foreach($dataArr as $data)
			{
				$hotelwithImg = array();
				$hotelwithImg['hotel_id'] = $data['hotel_id'];
				$hotelwithImg['hotel_name'] = $data['hotel_name'];
				$hotelwithImg['hotel_type'] = $data['hotel_type'];
				$hotelwithImg['star_rating'] = $data['star_rating'];
				$hotelwithImg['from_date'] = $data['from_date'];
				$hotelwithImg['to_date'] = $data['to_date'];
				$hotelwithImg['city'] = $data['city'];
				$hotelwithImg['meal_plan'] = $data['meal_plan'];
				$hotelId = $data['hotel_id'];
				$seleQuery = $this->db->prepare("SELECT image FROM hotel_image WHERE hotel_id = $hotelId LIMIT 1");
				$seleQuery->execute();
				$dataImgArr = $seleQuery->fetch(PDO::FETCH_ASSOC);
				$hotelwithImg['image'] = $dataImgArr['image'];
				
				$hotelwithImgAll[] = $hotelwithImg;
			}
			
			return $hotelwithImgAll;
			
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getAlldate_id_room_rates($hotel_id,$frm_dt,$to_dt,$breakfast)
	{
		$queryDate = " AND '$frm_dt' between from_date and to_date";
		// $queryDate = " AND ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$frm_dt') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$to_dt')) && ((DATE_FORMAT(from_date, '%Y-%m-%d')<='$frm_dt') && (DATE_FORMAT(to_date, '%Y-%m-%d')>='$to_dt'))";
		//echo $query = "SELECT * FROM hotel_dates_rate WHERE hotel_id IN('$hotel_id') and meal_plan='$breakfast' $queryDate";exit;
		$query = $this->db->prepare("SELECT id FROM hotel_dates_rate WHERE hotel_id IN('$hotel_id') and meal_plan='$breakfast' $queryDate");
		try{
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
		
	}
	
	public function get1Allhotel_room_rates($id,$room_id)
	{
		//$query = "SELECT * FROM hotel_room_rates WHERE date_id IN('$id') and room_type_id='$room_id'";exit;
	  $query = $this->db->prepare("SELECT * FROM hotel_room_rates WHERE date_id IN('$id') and room_type_id='$room_id'");
		try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	 } catch(PDOException $e){
		die($e->getMessage());
	 }  	
	}	
	public function getHotelsByCityDate($cityId, $searchDate){
		
		//print_r($cityId);
		//print_r($searchDate);exit;
		
		$cityStr = '';
		if($cityId != '')
		{
			$cityStr = " AND ad.city = '$cityId'";
		}
		
		$searchDate=date('Y-m-d',strtotime($searchDate));
		//echo $searchDate;exit;
		//$endDate=date('Y-m-d',strtotime($enddate));
		
		if($searchDate == '1970-01-01' || $searchDate == ''){
			$searchDate='';
			//$endDate ='';
		}
		else
		{
			//$queryDate = " AND ((DATE_FORMAT(str_to_date(hdr.from_date, '%Y-%m-%d'), '%Y-%m-%d')>='$searchDate') AND (DATE_FORMAT(str_to_date(hdr.to_date, '%Y-%m-%d'), '%Y-%m-%d')<='$startDate'))";
			$queryDate = " AND ((DATE_FORMAT(hdr.from_date, '%Y-%m-%d')<='$searchDate') && (DATE_FORMAT(hdr.to_date, '%Y-%m-%d')>='$searchDate')) && ((DATE_FORMAT(hdr.from_date, '%Y-%m-%d')<='$searchDate') && (DATE_FORMAT(hdr.to_date, '%Y-%m-%d')>='$searchDate'))";
			// $queryDate = " AND '$searchDate' between hdr.from_date and hdr.to_date";
			
			//DATE(NOW()) between date1 and date2
		}
	
		// echo $query ="SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type, hdr.meal_plan FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate";exit;
		
		$query = $this->db->prepare("SELECT hotels.hotel_id,hotels.hotel_name,hotels.star_rating,ad.city,hdr.from_date,hdr.to_date,ad.panel_type, hdr.meal_plan FROM hotels INNER JOIN address_details AS ad ON ad.admin_id = hotels.hotel_id INNER JOIN hotel_dates_rate AS hdr ON hdr.hotel_id = hotels.hotel_id WHERE 1=1 $cityStr $queryDate");
		
		try{
			$query->execute();
			$dataArr = $query->fetchAll(PDO::FETCH_ASSOC);
			
			$hotelwithImgAll = array();
			// echo '<pre>';
			// print_r($dataArr);
			// die; 
			foreach($dataArr as $data)
			{
				$hotelwithImg = array();
				$hotelwithImg['hotel_id'] = $data['hotel_id'];
				$hotelwithImg['hotel_name'] = $data['hotel_name'];
				$hotelwithImg['hotel_type'] = $data['hotel_type'];
				$hotelwithImg['star_rating'] = $data['star_rating'];
				$hotelwithImg['from_date'] = $data['from_date'];
				$hotelwithImg['to_date'] = $data['to_date'];
				$hotelwithImg['city'] = $data['city'];
				$hotelwithImg['meal_plan'] = $data['meal_plan'];
				$hotelId = $data['hotel_id'];
				$seleQuery = $this->db->prepare("SELECT image FROM hotel_image WHERE hotel_id = $hotelId LIMIT 1");
				$seleQuery->execute();
				$dataImgArr = $seleQuery->fetch(PDO::FETCH_ASSOC);
				$hotelwithImg['image'] = $dataImgArr['image'];
				
				$hotelwithImgAll[] = $hotelwithImg;
			}
			
			return $hotelwithImgAll;
			
		    }catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function getHotelsRoomname($hotel_id)
{
	//echo "SELECT * FROM hotel_rooms WHERE hotel_id=$hotelId";
	$id1=explode(",",$id);
	$id2=implode("','",$id1);
	$id3=substr($id2,0,-3);
	$hotel_id1=explode(",",$hotel_id);
	$hotel_id2=implode("','",$hotel_id1);
	//echo $query = "SELECT * FROM hotel_rooms WHERE hotel_id IN('$hotel_id2') ";exit;
	$query = $this->db->prepare("SELECT * FROM hotel_rooms WHERE hotel_id IN('$hotel_id2') ");
	
	//$query->bindValue(1, $id3);

	try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
	} catch(PDOException $e){
		die($e->getMessage());
	}
}
	public function getAll_hotel_name($hotel_name)
	{
		//$query = "SELECT * FROM hotel WHERE hotel_id IN('$hotel_name')"exit;
		$query = $this->db->prepare("SELECT hotel_id,hotel_name FROM hotels WHERE hotel_id IN('$hotel_name')");
		
	//$query->bindValue(1, $id3);

		try{
		$query->execute();
		return $query->fetchAll(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
		die($e->getMessage());
		}
	}
	public function getAll_hotel_rooms($room_name)
	{
		//$query = "SELECT * FROM hotel WHERE hotel_id IN('$hotel_name')"exit;
		$query = $this->db->prepare("SELECT id,room_type FROM hotel_rooms WHERE id IN('$room_name')");
		
	//$query->bindValue(1, $id3);

		try{
		$query->execute();
		return $query->fetch(PDO::FETCH_ASSOC);
		} catch(PDOException $e){
		die($e->getMessage());
		}
	}
	public function hotel_confrm_add($data)
	{
		extract($data);
		$sql1="select * from hotel_confrm_details where tour_card_id ='$tour_id' and checkin_date='$bkg_date1'";
		$query1 = $this->db->prepare($sql1);
		$query1->bindValue(1, $tour_id);
		$query1->bindValue(2, $bkg_date1);
		$query1->execute();
		$num_rows = $query1->rowCount();
		//echo $num_rows;exit;
		if($num_rows < 1)
		{
			
		
		//echo $sql = "Insert into hotel_confrm_details(tour_card_id,tour_card_no,checkin_date,checkout_date,nights,pax_name, country, hotel, city, room_type,meal_plan, costing,room_type_price) values('$tour_id','$tc_no1','$bkg_date1','$bkg_date2','$nights','$pax_name1','$country1','$hotel1','$city1','$room_type1','$meal_plan1','$costing','$price_rate')";exit;
		$sql = "Insert into hotel_confrm_details(tour_card_id, tour_card_no, checkin_date, checkout_date,nights,pax_name, country, hotel, city, room_type,meal_plan, costing,room_type_price,room_ratee_price,hotel_id) values(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";	
			$query = $this->db->prepare($sql);
			$query->bindValue(1, $tour_id);
			$query->bindValue(2, $tc_no1);
			$query->bindValue(3, $bkg_date1);
			$query->bindValue(4, $bkg_date2);
			$query->bindValue(5, $nights);
			$query->bindValue(6, $pax_name1);
			$query->bindValue(7, $country1);
			$query->bindValue(8, $hotel1);
			$query->bindValue(9, $city1);
			$query->bindValue(10, $room_type1);
			$query->bindValue(11, $meal_plan1);
			$query->bindValue(12, $costing);
			$query->bindValue(13, $price_rate);
			$query->bindValue(14, $room_rate_price2);
			$query->bindValue(15, $hotel_id);
			try{
				$query->execute();
				return 1;
			}catch(PDOException $e){
				die($e -> getMessage());
			}
		}
	}
	
	public function hotel_update_pack_add($bkg_date1,$tour_id)
	{
		$query = $this->db->prepare("UPDATE tour_card_package_dt SET `hotel_conf_status`=?  WHERE tour_card_id=? and pck_date=?");
			$query->bindValue(1, 1);
			$query->bindValue(2, $tour_id);
			$query->bindValue(3, $bkg_date1);
			try{
				$query->execute();
				return 1;
			} catch (PDOException $e){
				die($e->getMessage());
			}
	}
	
}
?>