<?php  
class Travel{
 	
	private $db;

	public function __construct($database) {
	    $this->db = $database;
	}


public function travel_client_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("INSERT INTO travel_agent(`hotal_name`, `base_currency`, `description`) VALUES (?,?,?)");
		$query->bindValue(1, $travel_hotel_name);
		$query->bindValue(2, $travel_base_currency);
		$query->bindValue(3, $travel_description);
		
		try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}


public function travel_query_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE travel_agent SET travel_agentr_id=?, travel_agent_user_id=?, travel_agent_password=?  WHERE id='".$travelId."'");
		$query->bindValue(1, $travel_id);
		$query->bindValue(2, $travel_userId);
		$query->bindValue(3, $travel_pass);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
public function travel_agent_address_detail($address,$address_line,$city,$state,$pin_code) {
		
		//print_r($abc);
		//extract($abc);
		echo ("INSERT INTO travler_address_details (`address`, `address_line`, `city`, `state`,`pin_code`) VALUES ($address,$address_line,$city,$state,$pin_code)");
		 $query = $this->db->prepare("INSERT INTO travler_address_details (`address`, `address_line`, `city`, `state`,`pin_code`) VALUES (?,?,?,?,?)");
		$query->bindValue(1, $address);
		$query->bindValue(2, $address_line);
		$query->bindValue(3, $city);
		$query->bindValue(4, $state);
		$query->bindValue(5, $pin_code);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			 die($e->getMessage());
		}
	
}

public function travel_bank_detail($data) {
		extract($_POST);
		$query = $this->db->prepare("UPDATE travel_agent SET pan_no=?, account_name=? , account_no=?, bank_name=? , branch_name=? , ifsc=?  WHERE id='".$travelId."'");
		$query->bindValue(1, $travel_pan_no);
		$query->bindValue(2, $travel_account_name);
		$query->bindValue(3, $travel_account_no);
		$query->bindValue(4, $travel_bank);
		$query->bindValue(5, $travel_branch);
		$query->bindValue(6, $travel_ifsc);

	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}

public function travel_doc_detail($pan_file_name,$hote_photo_copy,$hotel_Contract_copy , $transporterId)
	{
		extract($_POST);
		$query = $this->db->prepare("UPDATE travel_agent SET pan_card_copy=?, photo=? , Contract=? WHERE id='".$transporterId."'");
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

	
	public function travel_agent_date_detail($fromdate,$todate,$description) {
	
		echo ("INSERT INTO travler_dates_rate (`from_date`, `to_date`, `description`) VALUES ('$fromdate','$todate','$description')");
		//print_r($abc);
		//extract($abc);
		$query = $this->db->prepare("INSERT INTO travler_dates_rate (`from_date`, `to_date`, `description`) VALUES (?,?,?)");
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
	
	public function travler_date_rates($LidID,$Service1,$Service2,$Service3,$hotelId) {
		
		//print_r($abc);
		//extract($abc);
		//echo ("INSERT INTO transporter_rates (`lidId`, `innova`, `indigo`, `tempoTraveller`) VALUES ($LidID,$Innova,$Indigo,$Traveller)");
		$query = $this->db->prepare("INSERT INTO travler_rates (`lidId`, `service`, `service2`, `service3`,`date_id`) VALUES (?,?,?,?,?)");
		$query->bindValue(1, $LidID);
		$query->bindValue(2, $Service1);
		$query->bindValue(3, $Service2);
		$query->bindValue(4, $Service3);
		$query->bindValue(5, $hotelId);
	try{
			$query->execute();
			return $lastrID = $this->db->lastInsertId();
		} catch (PDOException $e){
			die($e->getMessage());
		}
	}
}

?>