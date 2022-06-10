$(".rate").append('<div id="rates_'+count+'"><div class="col-md-2"><div class="form-group"><h4  class="box-title"><b style="font-size: 17px;">	Rate </b></h4></div></div><div class="col-md-4"><div class="form-group" ><label for="search">From:Calender</label><input type="text" class="form-control " name="fromdate_'+count+'" placeholder="Name"  name="todate'+count+'" value="Date"/></div></div><div class="col-md-4"><div class="form-group"> <label for="search">To:Calender</label><input type="text" class="form-control" name="searchid" id="searchid" placeholder="Name" value="Date"/></div></div><div class="col-md-1" ></div> <div class= "bs-example col-md-11" ><table class="table" ><thead><tr ><th ></th><th style="width: 40px;" >Deluxe</th><th style="width: 40px;">Premium</th>	<th style="width: 30px;"> Metro View </th></tr>	 </thead><tbody border="1px" ><tr><td>Single<input type="hidden" name="roomType_'+count+'_1_1" value="Single"></td> <td><input type="text" value="3000" name="deluxe_'+count+'_1_2"> </td><td><input type="text"  name="premium_'+count+'_1_3"></td><td><input type="text" name="metroview_'+count+'_1_4"></td><td rowspan="8"><textarea  rows="17" cols="21" name="description_'+count+'"> Description </textarea> </td></tr><tr><td>Double<input type="hidden" name="roomType_'+count+'_2_1" value="Double"></td><td><input type="text" name="deluxe_'+count+'_2_2" value="3500"></td>	<td><input type="text" name="premium_'+count+'_2_3"></td><td><input type="text" name="mertoview_'+count+'_2_4"></td> </tr><tr><td>Extra Adult <input type="hidden" name="roomType_'+count+'_3_1" value="Extra Adult"></td><td><input type="text" name="deluxe_'+count+'_3_2" value="1200"></td><td><input type="text" name="premium_'+count+'_3_3"></td><td><input type="text" name="metroview_'+count+'_3_4"> </td> </tr><tr><td>Extra Child w/o Bed<input type="hidden" name="roomType_'+count+'_4_1" value="Extra Child w/o Bed"></td><td><input type="text" name="deluxe_'+count+'_4_2" value="800"></td>	<td><input type="text" name="premium_'+count+'_4_3"></td><td><input type="text" name="metroview_'+count+'_4_4">	</td></tr><tr><td>Extra Child with Bed <input type="hidden" name="roomType_'+count+'_5_1" value="Extra Child with Bed"></td><td><input type="text" name="deluxe_'+count+'_5_2"     value="1000"></td><td><input type="text" name="premium_'+count+'_5_3"> </td><td><input type="text" name="mertoview_'+count+'_5_4"></td></tr><tr><td>Extra Breakfast <input type="hidden" name="roomType_'+count+'_6_1" value="Extra Breakfast"></td><td><input type="text" name="deluxe_'+count+'_6_2" value="250"></td><td><input type="text" name="premium_'+count+'_6_3"></td><td><input type="text" name="mertoview_'+count+'_6_4"></td></tr><tr><td>Lunch<input type="hidden" name="roomType_'+count+'_3_1" value="Lunch"></td><td><input type="text" name="deluxe_'+count+'_7_2" value="350"></td><td><input type="text" name="premium_'+count+'_7_3"></td><td><input type="text" name="mertoview_'+count+'_7_4"></td></tr><tr><td>Dinner<input type="hidden" name="roomType_'+count+'_8_1" value="Dinner"></td><td><input type="text" name="deluxe_'+count+'_8_2" value="450"></td><td><input type="text" name="premium_'+count+'_8_3"></td><td><input type="text" name="mertoview_'+count+'_8_4"></td></tr> </tbody></table></div><div class="col-md-1"> <div class="form-group"><label for="last">Remove</label>  <a class="delete" rel="'+count+'" href="javascript:void(0)" onclick="remove_rate('+count+')"><i class="fa fa-fw fa-times-circle-o" style="color:red;"></i></a></div></div> </div>');




5


Single3000
Double3500
Extra Adult1200
Extra Child w/o Bed  800
Extra Child with Bed
Extra Breakfast
Lunch350
Dinner450
SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'to_date' cannot be null	


Array
(
    [item_count] => 1
    [item_count1] => 1
    [item_count2] => 1
    [item_count3] => 1
    [item_count4] => 1
    [item_count9] => 3
    [total__rates_itmes] => 8
    [userId] => 
    [type] => add_hotel_rates_detail
    [hotel_id] => 
    [fromdate_1] => Date
    [todate_1] => Date
    [roomType_1_1_1] => Single
    [deluxe_1_1_2] => 3000
    [premium_1_1_3] => 
    [metroview_1_1_4] => 
    [description_1] =>  Description  
    [roomType_1_2_1] => Double
    [deluxe_1_2_2] => 3500
    [premium_1_2_3] => 
    [mertoview_1_2_4] => 
    [roomType_1_3_1] => Extra Adult
    [deluxe_1_3_2] => 1200
    [premium_1_3_3] => 
    [metroview_1_3_4] => 
    [roomType_1_4_1] => Extra Child w/o Bed  
    [deluxe_1_4_2] => 800
    [premium_1_4_4] => 
    [metroview_1_4_5] => 
    [roomType_1_5_1] => Extra Child with Bed
    [withbed_deluxe_1_5_2] => 1000
    [child_withbed_premium_1_5_3] => 
    [child_withbed_mertoview_1_5_4] => 
    [roomType_1_6_1] => Extra Breakfast
    [brkfst_deluxe_1_6_2] => 250
    [brkfst_premium_1_6_3] => 
    [brkfst_mertoview_1_6_4] => 
    [roomType_1_7_1] => Lunch
    [deluxe_1_7_2] => 350
    [premium_1_7_3] => 
    [mertoview_1_7_4] => 
    [roomType_1_8_1] => Dinner
    [deluxe_1_8_2] => 450
    [premium_1_8_3] => 
    [mertoview_1_8_4] => 
    [fromdate_2] => Date
    [searchid] => Date
    [roomType_2_1_1] => Single
    [deluxe_2_1_2] => 3000
    [premium_2_1_3] => 
    [metroview_2_1_4] => 
    [description_2] =>  Description 
    [roomType_2_2_1] => Double
    [deluxe_2_2_2] => 3500
    [premium_2_2_3] => 
    [mertoview_2_2_4] => 
    [roomType_2_3_1] => Lunch
    [deluxe_2_3_2] => 1200
    [premium_2_3_3] => 
    [metroview_2_3_4] => 
    [roomType_2_4_1] => Extra Child w/o Bed
    [deluxe_2_4_2] => 800
    [premium_2_4_3] => 
    [metroview_2_4_4] => 
    [roomType_2_5_1] => Extra Child with Bed
    [deluxe_2_5_2] => 1000
    [premium_2_5_3] => 
    [mertoview_2_5_4] => 
    [roomType_2_6_1] => Extra Breakfast
    [deluxe_2_6_2] => 250
    [premium_2_6_3] => 
    [mertoview_2_6_4] => 
    [deluxe_2_7_2] => 350
    [premium_2_7_3] => 
    [mertoview_2_7_4] => 
    [roomType_2_8_1] => Dinner
    [deluxe_2_8_2] => 450
    [premium_2_8_3] => 
    [mertoview_2_8_4] => 
    [fromdate_3] => Date
    [roomType_3_1_1] => Single
    [deluxe_3_1_2] => 3000
    [premium_3_1_3] => 
    [metroview_3_1_4] => 
    [description_3] =>  Description 
    [roomType_3_2_1] => Double
    [deluxe_3_2_2] => 3500
    [premium_3_2_3] => 
    [mertoview_3_2_4] => 
    [roomType_3_3_1] => Lunch
    [deluxe_3_3_2] => 1200
    [premium_3_3_3] => 
    [metroview_3_3_4] => 
    [roomType_3_4_1] => Extra Child w/o Bed
    [deluxe_3_4_2] => 800
    [premium_3_4_3] => 
    [metroview_3_4_4] => 
    [roomType_3_5_1] => Extra Child with Bed
    [deluxe_3_5_2] => 1000
    [premium_3_5_3] => 
    [mertoview_3_5_4] => 
    [roomType_3_6_1] => Extra Breakfast
    [deluxe_3_6_2] => 250
    [premium_3_6_3] => 
    [mertoview_3_6_4] => 
    [deluxe_3_7_2] => 350
    [premium_3_7_3] => 
    [mertoview_3_7_4] => 
    [roomType_3_8_1] => Dinner
    [deluxe_3_8_2] => 450
    [premium_3_8_3] => 
    [mertoview_3_8_4] => 
    [hotel_rate_1] => 
)
6
Single3000
Double3500
Extra Adult1200
Extra Child w/o Bed  800
Extra Child with Bed
Extra Breakfast
Lunch350
Dinner450
SQLSTATE[23000]: Integrity constraint violation: 1048 Column 'to_date' cannot be null







			