<?php
include('config/init.php');
error_reporting(0);
@extract($_POST);
if($_GET['action']=='get_meal_plan_date')
{
	$hotel_id=$_GET['id'];
	$meal_id=$_GET['meal_id'];
	$hotel_meal_date = $objhotel->meal_plan_det($hotel_id,$meal_id);
	echo json_encode($hotel_meal_date);
}


if($type == 'add_hotel_prsnl_detail')
{
	echo $prsnl_detail = $objhotel->hotel_prsnl_detail($_POST);
	if($prsnl_detail)
	{
		$_SESSION['hotelId'] =$prsnl_detail;
		$hotelId=$_SESSION['hotelId'];
		/* Add/Update hotel permanent address*/
		if(!empty($editHotelId))
		{
			$hotel_address_detail = $objhotel->hotel_address_detail($editHotelId,$_POST,'hotel_permanent_addr');
			/* Update hotel contact numbers*/
			$hotel_contact_numbers = $objhotel->hotel_contact_detail($editHotelId,$_POST,'hotel_phone');
			/* Update hotel services detail */
			$hotel_room_deatil = $objhotel->hotel_services_detail($editHotelId,$_POST);
			/* Update hotel Aminities and facility details */
			//$hotel_facility=$objhotel->hotel_aminities_facility_detail($editHotelId,$_POST);
		}
		else
		{
			$hotel_address_detail = $objhotel->hotel_address_detail($hotelId,$_POST,'hotel_permanent_addr');
			/* Add hotel contact numbers*/
			$hotel_contact_numbers = $objhotel->hotel_contact_detail($hotelId,$_POST,'hotel_phone');
			/* Add hotel services detail */
			$hotel_room_deatil = $objhotel->hotel_services_detail($hotelId,$_POST);
			/* Add hotel Aminities and facility details */
			//$hotel_facility=$objhotel->hotel_aminities_facility_detail($hotelId,$_POST);
		}
	} 
	die;
}
if($type == 'add_hotel_more_detail')
{
	if(!empty($editHotelId))
	{
		/* Update hotel More details */
		$hotel_more_detail = $objhotel->hotel_more_detail($editHotelId,$_POST);
		/* Update hotel Concern person details */
		$concern_person_detail=$objhotel->concern_person_detail($editHotelId,$_POST,'hotel');
		/* Update hotel contact numbers */
		$concern_person_numbers = $objhotel->hotel_contact_detail($editHotelId,$_POST,'hotel_concern_person');
	}
	else
	{
		/* Add hotel More details */
		$hotel_more_detail = $objhotel->hotel_more_detail($_SESSION['hotelId'],$_POST);
		/* Add hotel Concern person details */
		$concern_person_detail=$objhotel->concern_person_detail($_SESSION['hotelId'],$_POST,'hotel');
		/* Add hotel contact numbers */
		$concern_person_numbers = $objhotel->hotel_contact_detail($_SESSION['hotelId'],$_POST,'hotel_concern_person');
	}
}

if($type == 'add_hotel_bank_detail')
{
	//print_r($_POST);
	$hotel_bank_detail = $objhotel->hotel_bank_detail($_SESSION['hotelId'],$_POST);
}

if($type == 'add_hotel_doc_detail')
{
	extract($_POST);
	$recordId = $editHotelId;
	if($editHotelId == '')
	{
		$recordId = $_SESSION['hotelId'];
	}
	
	$docname=array();
	for($i=0;$i<count($docFileName);$i++){
		
		$fileName = $docFileName[$i];
		$uploadedDoc = $upldFileName[$i];
		$docId = $attachEdId[$i];
		if($uploadedDoc != '')
		{
			$saveDoc=$objhotel->hotel_doc_detail($recordId,$fileName,$uploadedDoc,$docId);
		}	
	}
	
	/* $docname=array();
	for($i=0;$i<$totalFld;$i++){
		$documentName=$docFileName[$i];
		$document=$upldFileName[$i];
		$docId=$attachEdId[$i];
		if(!empty($editHotelId))
		{
			$saveDoc=$objhotel->hotel_doc_detail($editHotelId,$documentName,$document,$docId);
		}
		else
		{
			$saveDoc=$objhotel->hotel_doc_detail($_SESSION['hotelId'],$documentName,$document,$docId);
		}
	} */
	if($saveDoc){
		//unlink($fileName);
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='2';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die;
}
if($type == 'add_hotel_photos')
{
	//print_r($_POST);
	extract($_POST);
	$hPhotos='';
	$photos = json_encode($hPhotos);
	
	$saveDoc=$objhotel->hotel_photos($_POST);
	if($saveDoc){
		//unlink($fileName);
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='2';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die;
}
if($type == 'add_hotel_rates_detail')
{
	//print_r($_POST);
	
   
   $editHotelId=$_POST['editHotelId'];
   if($editHotelId!=''){
	 $_SESSION['hotelId']= $editHotelId; 
   }elseif($_POST['hotel_id']!=''){
	 $_SESSION['hotelId']=$_POST['hotel_id'];  
   }else{
	   $_SESSION['hotelId']=$_POST['hotelId'];
   }
   $editid=$_POST['editid'];
       if($editid!='')
	   {
		$editid ; 
	   }else{
		   $editid=1;
	   }
	   
	   $r = $editid;
 
	 $fromdate= date("Y-m-d", strtotime($_POST['fromdate_'.$r]));
	 $todate=date("Y-m-d", strtotime($_POST['todate_'.$r]));
	 $hotelDateid=$_POST['date_id_'.$r];	 
	 $description=$_POST['description_'.$r];
	 $tblWiseItem=$_POST['tbl_'.$r.'_item_count10'];
	 $mealType=$_POST['mealPlan_'.$r];
	 
	if(!empty($editHotelId))
	{
		$date_detail1=$objhotel->hotel_date_detail_check($fromdate,$todate,$mealType,$editHotelId);
		$data_array=array();
		
		if(!empty($date_detail1))
		{
			$update=$_POST['update'];
			if($update==1)
			{
				
				foreach($date_detail1 as $data)
				{
					if($fromdate == $data['from_date'] && $todate == $data['to_date'] && $mealType==$data['meal_plan'])
					{
						
						$update_array[]=1;	
					}
					
					else
					{
						$update_array[]=0;	
					}			
				}
				
				if(in_array(1,$update_array))
				{			
					$date_detail=$objhotel->hotel_date_detail($fromdate,$todate,$description,$editHotelId,$hotelDateid,$mealType);
					echo "1";
				}
			}
			else
			{
				foreach($date_detail1 as $data)
				{
					if($fromdate == $data['from_date'] || $todate == $data['to_date']){
						
						echo "0";
						exit;
					}else if($fromdate >= $data['from_date'] && $todate <= $data['to_date']){
						echo "0";
						exit;
					}
					else if($fromdate <= $data['from_date'] && $todate >= $data['to_date']){
						echo "0";
						exit;
					}
					else if($fromdate <= $data['from_date'] && $todate <= $data['to_date'] && $todate <=$data['from_date']){
						$data_array[]=1;
						
					}
					else if($fromdate <= $data['from_date'] && $todate <= $data['to_date'] && $todate >=$data['from_date']){
						echo "0";
						exit;
						
					}
					else if($fromdate >= $data['from_date'] && $fromdate <= $data['to_date'] && $todate >= $data['to_date'])
					{
						echo "0";
						exit;
					}
					else
					{
						$data_array[]=1;
					}
				}
				if(in_array(1,$data_array))
				{			
					$date_detail=$objhotel->hotel_date_detail($fromdate,$todate,$description,$editHotelId,$hotelDateid,$mealType);
					echo "1";
				}
			 
			}
		}
		else
		{
			$date_detail=$objhotel->hotel_date_detail($fromdate,$todate,$description,$editHotelId,$hotelDateid,$mealType);
			echo "1";
		}
	    
	}
	else
	{	
		//$date_detail1=$objhotel->hotel_date_detail_check($fromdate,$todate,$mealType,$_SESSION['hotelId']);
		
			
		$date_detail=$objhotel->hotel_date_detail($fromdate,$todate,$description,$_SESSION['hotelId'],$hotelDateid,$mealType);
		
	}
	
	$date_Id=$date_detail;
	$tblWiseItem=15;
	for($i=1; $i<=$tblWiseItem; $i++)
	{
	
		$k=2;
		for($j=1;$j<=$total__rates_itmes;$j++)
		{
			//echo 'room_name_'.$r.'_'.$i.'_1';
			//echo '<br/>'.$total__rates_itmes.'::::'.$_POST['room_name_'.$r.'_'.$i.'_1'];
	
	
			$hotelRoomId=$_POST['roomTypeId_'.$r.'_'.$i.'_'.$k];				
			$roomPrice=$_POST['roomType_'.$r.'_'.$i.'_'.$k];				
			$hotelRateId=$_POST['hotelRateId_'.$r.'_'.$i.'_'.$k];
			$hotelRoomNameId=$_POST['roomName_'.$r.'_'.$i.'_1'];
			
			$hotelRoomName=$_POST['room_name_'.$r.'_'.$i.'_1'];
			
			//echo "<br/>";
			if($roomPrice != '')
			{
				
				if(!empty($editHotelId))
				{
					
					$addHotelRates=$objhotel->hotel_rate_detail($editHotelId,$date_Id,$hotelRoomNameId,$hotelRoomId,$roomPrice,$hotelRateId,$hotelRoomName);
				}
				else
				{
					
					$addHotelRates=$objhotel->hotel_rate_detail($_SESSION['hotelId'],$date_Id,$hotelRoomNameId,$hotelRoomId,$roomPrice,$hotelRateId,$hotelRoomName);
				}
			}
			
			$k++;
		}
	}	
	
	
	/* for($r=$editid; $r<=1; $r++)
	{      
		
	} */	
	exit;
}
if($_GET['action'] == 'delAttach'){
	//print_r($_POST);
	extract($_POST);
	//print_r($_POST);exit;
	$deleteAttach=$objhotel->delete_hotel_doc_attachment($attachId);
	if($deleteAttach){
		//unlink($fileName);
		$html['status'] ='1';
	}else{
		//$html['msg'] = "<div class='alert alert-danger' style='text-align:center;'>Problem in Removing Image.</div>";	
		$html['status'] ='2';
	}
	header('Content-Type: application/x-json; charset=utf-8');
	echo(json_encode($html));
	die; 
}
if($type == 'add_more_rates')
{
	//$arrRooms=$objhotel->getHotelRoomServicesByid($_SESSION['hotelId']);
	//print_r($_POST);
	
	$hId = $hId;
	$getallRoom=$objhotel->getAllHotelRoom();
	//print_r($getallRoom);
	$countRoomNameId=count($getallRoom);
	//print_r($getallRoom);
	$singleRoomId=$getallRoom[0]['id'];
	$doubRoomId=$getallRoom[1]['id'];
	$extAdltRoomId=$getallRoom[2]['id'];
	$extChldWoBedRoomId=$getallRoom[3]['id'];
	$extChldWBedRoomId=$getallRoom[4]['id'];
	$extBrkFastRoomId=$getallRoom[5]['id'];
	$lunchRoomId=$getallRoom[6]['id'];
	$dinnRoomId=$getallRoom[7]['id'];
	
	$count = $count;
    $arrRooms=$objhotel->getHotelRoomServicesByid($hId);
	$countRooms=count($arrRooms);
	//print_r($arrRooms);
	
	//Array ( [type] => add_more_rates )
	//$hotel_bank_detail = $objhotel->hotel_bank_detail($_SESSION['hotelId'],$_POST);
	?>
       <form role="form" method="POST" name="hotel_rate" id="hotel_rate_<?php echo $count; ?>">
		<input type="hidden" id="item_count10" name="item_count10" value="<?php if(isset($countTtlRoom)&& !empty($countTtlRoom)){echo $countTtlRoom;}else{echo 8;}?>"> 	
	<div id="rates_<?php echo $count; ?>" class="rateRow">
		<input type="hidden" id="tbl_<?php echo $count; ?>_item_count10" name="tbl_<?php echo $count; ?>_item_count10" value="8">
	
		<input type="hidden" name="editid" value="<?php echo $count; ?>" />
		<input type="hidden" name="type" value="add_hotel_rates_detail" />
		<input type="hidden" name="hotelId" value="<?php echo $hId; ?>">
		<input type="hidden" id="total__rates_itmes" name="total__rates_itmes" value="<?php if($_GET['action'] == 'edit'){echo $countEditRooms;}else{echo $countRooms;}?>">
		<div class="col-sm-8">
		<div class="">
			<div class="form-group">
				<h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4>
			</div>
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="search">From:Calender</label>
				<input type="text" class="form-control fromdate" name="fromdate_<?php echo $count; ?>" id="fromdate" placeholder="Name" value="<?php echo date('d F Y');?>"/>
			</div>						
		</div>
		<input type="hidden" name="date_id_<?php echo $count; ?>" value=""/>
		<div class="col-md-3">
			<div class="form-group">
				<label for="search">To:Calender</label>
				<input type="text" class="form-control todate" name="todate_<?php echo $count; ?>" id="todate" placeholder="Name" value="<?php echo date('d F Y');?>"/>
			</div>						
		</div>
		<div class="col-md-3">
			<div class="form-group">
				<label for="search">Meal Plan</label>
				<select class="form-control" name="mealPlan_<?php echo $count; ?>">
					<option value="1">CP (Breakfast)</option>
					<option value="2">MAP (Breakfast + Dinner)</option>
					<option value="3">AP (Breakfast + Lunch + Dinner)</option>
					<option value="4">EP (Room Only)</option>
					<option value="5">CP Package</option>
					<option value="6">MAP Package</option>
					<option value="7">AP Package</option>
					<option value="8">EP Package</option>
				</select>
			</div>						
		</div>
		<div class="col-md-2">
			<div class="form-group">
				<label for="search">&nbsp;</label><br/>
				<button type="button" class="btn btn-md btn-warning showRtable" rel="<?php echo $count;?>">Show & Hide Table</button>
			</div>
		</div>

		<div class="bs-example col-md-11" >
			<div class="table-responsive rateTables" id="tblR_<?php echo $count;?>" style="display:none;">
			<table class="table">
				<thead>											
					<tr>
					<?php
						if($countRooms>0)
						{
					?>
					<th></th>
					<?php
							foreach($arrRooms as $key=>$val)
							{
					?>
						
						<th style="width: 40px;"><?php echo $val['room_type'];?></th>
					<?php
							}
						
						
					?>
					</tr>
				</thead>
				<tbody border="1px">
				
					<tr>
					<?php
							$roomCount1=1;
					?>
						<td>Single <input type="hidden" name="roomName_<?php echo $count; ?>_1_<?php echo $roomCount1;?>" value="<?php echo $singleRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_1_<?php echo $roomCount1;?>" value="Single"/></td>
					<?php
							
							foreach($arrRooms as $key1=>$val1)
							{
							$roomCount1++;	
					?>
						<td>
						<input type="text" name="roomType_<?php echo $count; ?>_1_<?php echo $roomCount1;?>" value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_1_<?php echo $roomCount1;?>" value="<?php echo $val1['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_1_<?php echo $roomCount1;?>" value=""/>
						</td>
						
					<?php
							}
						?>
						<td rowspan="8"> <textarea name="description_<?php echo $count; ?>" rows="17" cols="21"> Description  </textarea>  </td>
					</tr>
					<tr>
						<?php
							$roomCount2=1;
						?>
							<td>Double <input type="hidden" name="roomName_<?php echo $count; ?>_2_<?php echo $roomCount2;?>" value="<?php echo $doubRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_2_<?php echo $roomCount2;?>" value="Double"/></td>
						<?php
							
							foreach($arrRooms as $key2=>$val2)
							{
								$roomCount2++;
						?>
						<td>
						<input type="text"  name ="roomType_<?php echo $count; ?>_2_<?php echo $roomCount2;?>" value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_2_<?php echo $roomCount2;?>" value="<?php echo $val2['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_2_<?php echo $roomCount2;?>" value=""/>
						</td>		
						<?php
							}
						?>
					</tr>
					<tr>
					<?php
						
							$roomCount3=1;
					?>
						<td>Extra Adult  <input type="hidden" name="roomName_<?php echo $count; ?>_3_<?php echo $roomCount3;?>" value="<?php echo $extAdltRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_3_<?php echo $roomCount3;?>" value="Extra Adult"/></td>
					<?php
							
							foreach($arrRooms as $key3=>$val3)
							{
								$roomCount3++;
						?>
						
						<td>
						<input type="text" name ="roomType_<?php echo $count; ?>_3_<?php echo $roomCount3;?>" value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_3_<?php echo $roomCount3;?>" value="<?php echo $val3['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_3_<?php echo $roomCount3;?>" value=""/>
						</td>
					<?php
							}
					?>
					</tr>
					<tr>
					<?php
					
						$roomCount4=1;
					?>
						<td>Extra Child w/o Bed  <input type="hidden" name="roomName_<?php echo $count; ?>_4_<?php echo $roomCount4;?>" value="<?php echo $extChldWoBedRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_4_<?php echo $roomCount4;?>" value="Extra Child w/o Bed"/></td>
					<?php
						
						foreach($arrRooms as $key4=>$val4)
						{
							$roomCount4++;
					?>
						
						<td>
						<input type="text" name="roomType_<?php echo $count; ?>_4_<?php echo $roomCount4;?>" value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_4_<?php echo $roomCount4;?>" value="<?php echo $val4['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_4_<?php echo $roomCount4;?>" value=""/>
						</td>
					<?php
						}
					
					
					?>
					</tr>
					<tr>
					<?php
					
						$roomCount5=1;
					?>
						<td>Extra Child with Bed <input type="hidden" name="roomName_<?php echo $count; ?>_5_<?php echo $roomCount5;?>" value="<?php echo $extChldWBedRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_5_<?php echo $roomCount5;?>" value="Extra Child with Bed"/></td>
					<?php
						
						foreach($arrRooms as $key5=>$val5)
						{
							$roomCount5++;
					?>
						
						<td>
						<input type="text" name="roomType_<?php echo $count; ?>_5_<?php echo $roomCount5;?>"  value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_5_<?php echo $roomCount5;?>" value="<?php echo $val5['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_5_<?php echo $roomCount5;?>" value=""/>
						</td>
					<?php
						}
					?>
					</tr>
					<tr>
					<?php
					
						$roomCount6=1;
					?>
						<td>Extra Breakfast <input type="hidden" name="roomName_<?php echo $count; ?>_6_<?php echo $roomCount6;?>" value="<?php echo $extBrkFastRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_6_<?php echo $roomCount6;?>" value="Extra Breakfast"/></td>
					<?php
						
						foreach($arrRooms as $key6=>$val6)
						{
							$roomCount6++;
					?>
						
						<td>
						<input type="text" name="roomType_<?php echo $count; ?>_6_<?php echo $roomCount6;?>"  value="" >
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_6_<?php echo $roomCount6;?>" value="<?php echo $val6['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_6_<?php echo $roomCount6;?>" value=""/>
						</td>
					<?php
						}
					?>
					</tr>
					<tr>
					<?php
						$roomCount7=1;
					?>
						<td>Lunch <input type="hidden" name="roomName_<?php echo $count; ?>_7_<?php echo $roomCount7;?>" value="<?php echo $lunchRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_7_<?php echo $roomCount7;?>" value="Lunch"/></td>
					<?php
						
						foreach($arrRooms as $key7=>$val7)
						{
							$roomCount7++;
					?>
						
						<td>
						<input type="text" name="roomType_<?php echo $count; ?>_7_<?php echo $roomCount7;?>" value="">
						<input type="hidden" name="roomTypeId_<?php echo $count; ?>_7_<?php echo $roomCount7;?>" value="<?php echo $val7['id'];?>">
						<input type="hidden" name="hotelRateId_<?php echo $count; ?>_7_<?php echo $roomCount7;?>" value=""/>
						</td>
					<?php
						}
					
					?>
					
					</tr>
					<tr>
					<?php
					
						$roomCount8=1;
					?>
						<td class="dinnerCol">Dinner <input type="hidden" name="roomName_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" value="<?php echo $dinnRoomId;?>"><input type="hidden" name="room_name_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" id="room_name_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" value="Dinner"/></td>
					<?php
						
						foreach($arrRooms as $key8=>$val8)
						{
							$roomCount8++;
					?>
						
						<td>
						<input type="text" class="roomType_<?php echo $count; ?>_<?php echo $roomCount8;?>" name="roomType_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" value="">
						<input type="hidden" class="roomTypeId_<?php echo $count; ?>_<?php echo $roomCount8;?>" name="roomTypeId_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" value="<?php echo $val8['id'];?>">
						<input type="hidden" class="hotelRateId_<?php echo $count; ?>_<?php echo $roomCount8;?>" name="hotelRateId_<?php echo $count; ?>_8_<?php echo $roomCount8;?>" value=""/>
						</td>
					<?php
						}
					}
					
					?>
					</tr>
					<tr>
						<td><label for="last">Add More Row</label>
						<a href="javascript:void(0);" class="add_more_row" relTbl="<?php echo $count; ?>" rel="<?=$count?>" title="Add field" style="width:98px;" ><img src="add-icon.png" style="width:28px;"/></a></td>
						<td></td>
					</tr>
					<tr>
					<td colspan="15" >
					<input type="hidden" id="item_count9" name="item_count9" value="<?php echo $count;?>">
					<input type="hidden" id="tbl_<?php echo $count;?>_item_count10" name="tbl_<?php echo $count;?>_item_count10" value="<?php if($totalRows>8){echo $totalRows;}else{echo 8;}?>">
							<div class="form-group" style="margin: 28px 0 10px;"><button type="submit" class="btn btn-md btn-warning submit_rate_form" name="hotel_rate_<?=$count?>" id="submit" rel="<?php echo $count;?>">Save</button></div>
						</td>
						<td colspan="15" >
							 <div class="form-group" style="margin: 28px 0 10px;"><label for="last">Remove Table</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_rate(<?php echo $count; ?>,0)"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div>
						</td>
						
					</tr>
				
					
				</tbody>
			</table>
			</div>
		</div>
	</div>
</div>
	</form> 
	<?php	
}
if($type == 'delete_rates')
{
	//print_r($_POST);
	//die;
//Array ( [type] => delete_rates [dateId] => 67 )
	echo $delete = $objhotel->delte_date_rates($dateId);
}
if($type == 'delete_rate_items')
{
	//print_r($_POST);
	echo $delete = $objhotel->delte_rates_items($rateId);
}
if($type == 'delete_hotel_items')
{
	/* print_r($_POST);
	Array ( [type] => delete_hotel_items [id] => 882 [itemType] => hotelPhone )
	 */
	echo $delete = $objhotel->delte_hotel_items($id,$itemType);
}
if($_REQUEST['action'] == 'deleteRoomImg')
{
	//print_r($_POST);
	//echo $imageId;
	$deleteImg=$objhotel->deleteRoomImgById($imageId);
	if($deleteImg)
	{
		echo 1;
	}
	else
	{
		echo 0;
	}
}

?>