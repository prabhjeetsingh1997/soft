<?php  
class Hotel{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


public function hotel_prsnl_detail($data) {
	extract($_POST);	
	$ckeckin_date = date('Y-m-d',strtotime($checkInDate));
	$checkout_date = date('Y-m-d',strtotime($checkOutdate));	
		
	$query = $this->db->prepare("INSERT INTO hotels(`hotel_name`, `hotel_type`, `base_currency`, `star_rating`, `checkin_time`,`checkout_time`, `description`) VALUES (?,?,?,?,?,?,?)");
	$query->bindValue(1, $hotel_name);
	$query->bindValue(2, $hotel_type);
	$query->bindValue(3, $hotel_currency);
	$query->bindValue(4, $hotel_star);
	$query->bindValue(5, $ckeckin_date);
	$query->bindValue(6, $checkout_date);
	$query->bindValue(7, $hotel_description);
	
	try{
		$query->execute();
		return $lastrID = $this->db->lastInsertId();
	} catch (PDOException $e){
		die($e->getMessage());
	}
	}


public function hotel_more_detail($htlId,$data){
	extract($_POST);
		
	$concern_person_allmails = '';
	foreach($userEmail as $mails){
		$concern_person_allmails .= $mails.',';
	}
	$concern_person_allmailss = rtrim($concern_person_allmails,',');
	$concern_person_allmails = $concern_person_allmailss;
		
	$query = $this->db->prepare("UPDATE hotels SET transport_id=?, primary_email=?, additional_email_address=?, hotel_user_id=?, hotel_user_pass=?  WHERE hotel_id=?");
	$query->bindValue(1, $transporter_id);
	$query->bindValue(2, $userEmail[0]);
	$query->bindValue(3, $concern_person_allmails);
	$query->bindValue(4, $hote_user_id);
	$query->bindValue(5, $hotel_pass);
	$query->bindValue(6, $htlId);

	try{
			$query->execute();
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

public function hotel_doc_detail($hId,$data)
	{
		extract($data);

		$query = $this->db->prepare("UPDATE hotels SET pancard_attch=?, photo_attch=? , contract_attch=? WHERE hotel_id=?");
		$query->bindValue(1, $panCardDoc);
		$query->bindValue(2, $photoDoc);
		$query->bindValue(3, $contCopyDoc);
		$query->bindValue(4, $hId);
	
	
		try{
			$query->execute();
			//return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function hotel_address_detail($hotelId,$data,$hotelPermAddr) {
	extract($data);
	$countAddr=count($hotel_address1);
	for($i=0; $i<$countAddr; $i++)
	{
		$sql = "insert into address_details(panel_id, admin_id, address1, address2, city, state, pin_code, address_type, panel_type, status) values(?,?,?,?,?,?,?,?,?,?)";	
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $hotelId);
		$query->bindValue(3, $hotel_address1[$i]);
		$query->bindValue(4, $hotel_address2[$i]);
		$query->bindValue(5, $hotel_city[$i]);
		$query->bindValue(6, $hotel_state[$i]);
		$query->bindValue(7, $hotel_pincode[$i]);
		$query->bindValue(8, $hotelPermAddr);
		$query->bindValue(9, 'Hotel');
		$query->bindValue(10, 1);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e -> getMessage());
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
	for($i=0; $i<$countphoneArr; $i++)
	{
		$sql = "insert into phone_number(admin_id, contact_no, code, type) values(?,?,?,?)";	
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
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e -> getMessage());
		}
	}
	
} 
  public function hotel_services_detail($hotelId,$data) {
	extract($data);
	$countRoom=count($roomstype);
	$countRoomArr=$countRoom-1;
	for($i=0; $i<=$countRoomArr; $i++)
	{
		$query = $this->db->prepare("INSERT INTO `hotel_rooms` (`admin_id`, `room_type`, `room_description`,`aminities_facilites`,`units`, `pics`) VALUES  (?,?,?,?,?,?)");
		$query->bindValue(1, $hotelId);
		$query->bindValue(2, $roomstype[$i]);
		$query->bindValue(3, $RDescription[$i]);
		$query->bindValue(4, $AminitiesF[$i]);
		$query->bindValue(5, $Units[$i]);
		$query->bindValue(6, $Pics[$i]);
		try{
			$query->execute();
		} catch (PDOException $e){
			 die($e->getMessage());
		}
	}
	
}

public function hotel_aminities_facility_detail($hotelId,$data) {
	extract($data);
	$count=count($Aminities);
	for($i=0; $i<$count; $i++)
	{
		$aminity=$Aminities[$i];
		$query = $this->db->prepare("INSERT INTO aminities_facilites (`admin_id`, `aminities_facilites`,`status`) VALUES  (?,?,?)");
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


public function hotel_rate_detail($fromdate,$todate,$description) {
		
		//print_r($abc);
		//extract($abc);
		echo ("INSERT INTO hotel_dates_rate (`from_date`, `to_date`, `description`) VALUES ('$fromdate','$todate','$description')");
		$query = $this->db->prepare("INSERT INTO hotel_dates_rate (`from_date`, `to_date`, `description`) VALUES (?,?,?)");
		$query->bindValue(1, $fromdate);
		$query->bindValue(2, $todate);
		$query->bindValue(3, $description);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	public function hotel_rate_details($roomType,$deluxe,$premium,$metroview) {
		
		//print_r($abc);
		//extract($abc);
		echo ("INSERT INTO hotel_rates (`roomType`, `deluxePrice`, `premiumPrice`, `metroViewPrice`) VALUES ($roomType,$deluxe,$premium,$metroview)");
		$query = $this->db->prepare("INSERT INTO hotel_rates (`roomType`, `deluxePrice`, `premiumPrice`, `metroViewPrice`) VALUES (?,?,?,?)");
		$query->bindValue(1, $roomType);
		$query->bindValue(2, $deluxe);
		$query->bindValue(3, $premium);
		$query->bindValue(4, $metroview);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
	
	public function concern_person_detail($hotlId,$data,$hType) {
	extract($data);
	$countName=count($firstname);
	for($i=0; $i<$countName; $i++)
	{
		$sql = "insert into concern_person_detail(`admin_id`, title, first_name, middlename, lastname, type) values(?,?,?,?,?,?)";	
		$query = $this->db->prepare($sql);
		$query->bindValue(1, $hotlId);
		$query->bindValue(2, 'mr');
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


?>