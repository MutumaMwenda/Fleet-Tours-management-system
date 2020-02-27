<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{
$bid=intval($_GET['bid']);	

//Getting vehicles from database
    $smt1 = $dbh->prepare('select id,RegNo From tblvehicles ');
    $smt1->execute();
    $vehicle_data = $smt1->fetchAll();

//Getting drivers from database
    $smt = $dbh->prepare('select id,FullName From tbldrivers');
    $smt->execute();
    $data = $smt->fetchAll();

if(isset($_POST['submit']))
{
$destination=$_POST['destination'];
$date_from=$_POST['date_from'];
$date_to=$_POST['date_to'];	
$driver=$_POST['driver'];
$vehicle=$_POST['vehicle'];
$duration=$_POST['duration'];
$allowance=$_POST['allowance'];
$car_wash=$_POST['car_wash'];
$parking=$_POST['parking'];
$fuel_costs=$_POST['fuel_costs'];
$other_costs=$_POST['other_costs'];
if($other_costs==NULL ){
	$other_costs=0;
}
$park_entry_fee=$_POST['park_entry_fee'];
$booking_price=$_POST['booking_price'];
date_default_timezone_set('Africa/Nairobi');
$updated_on=date('Y/m/d'); 
$sql="update tblbookings set VehicleBooked=?,DriverBooked=?,Destination=?,DateFrom=?,DateTo=?,Duration=?,Allowances=?,CarWashExpenses=?,ParkingExpenses=?,FuelCosts=?,UpdatedOn=?,ParkEntryFee=?,BookingPrice=?,OtherCosts=? where id=?";
$query = $dbh->prepare($sql);
$query->execute([$vehicle,$driver,$destination,$date_from,$date_to,$duration,$allowance,$car_wash,$parking,$fuel_costs,$updated_on,$park_entry_fee,$booking_price,$other_costs,$bid]);
if ($query->execute()){
$msg="Booking Updated Successfully";
}else{
	$error="Something went wrong. Please try again";
}

}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>SAT | Admin Booking Update</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="tours,travels" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>
<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />
<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>
<link href="css/font-awesome.css" rel="stylesheet"> 
<script src="js/jquery-2.1.4.min.js"></script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />
  <style>
		.errorWrap {
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #dd3d36;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
.succWrap{
    padding: 10px;
    margin: 0 0 20px 0;
    background: #fff;
    border-left: 4px solid #5cb85c;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
}
		</style>

</head> 
<body>
   <div class="page-container">
   <!--/content-inner-->
<div class="left-content">
	   <div class="mother-grid-inner">
              <!--header start here-->
<?php include('includes/header.php');?>
							
				     <div class="clearfix"> </div>	
				</div>
<!--heder end here-->
	<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Update Booking </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Update Booking</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
						
<?php 
$bid=intval($_GET['bid']);
$sql = "SELECT * from tblbookings where id=:bid";
$query = $dbh -> prepare($sql);
$query -> bindParam(':bid', $bid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{	?>

							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle </label>
									<div class="col-sm-8">
										
										<select name="vehicle" id="vehicle" class="form-control1" required>
										<option >Select a Vehicle</option>
                                       <?php foreach ($vehicle_data as $row): ?>
                                           <option selected="<?php echo htmlentities($result->VehicleBooked);?>" value="<?= $row['id']; ?>"><?=$row["RegNo"]?></option>
                                       <?php endforeach ?>
                                    </select>
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Driver</label>
									<div class="col-sm-8">
										
											<select name="driver" id="driver" class="form-control1" required>
									   <option >Select a driver</option>
                                       <?php foreach ($data as $row): ?>
                                           <option selected="selected" value="<?= $row['id']; ?>"><?=$row["FullName"]?></option>
                                       <?php endforeach ?>
                                    </select>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Destination</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="destination" id="destination" placeholder="Tour Destination" value="<?php echo htmlentities($result->Destination);?>" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date From</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="date_from" id="date_from" placeholder=" Tour Start Date" value="<?php echo htmlentities($result->DateFrom);?>" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date To</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="date_to" id="date_to" placeholder="Tour Ending Date" value="<?php echo htmlentities($result->DateTo);?>" required>
									</div>
								</div>	

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Duration</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="duration" id="duration" placeholder="Trip Duration" value="<?php echo htmlentities($result->Duration);?>" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Allowance</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="allowance" id="allowance" placeholder="Driver allowance" value="<?php echo htmlentities($result->Allowances);?>" required>
									</div>
								</div>	

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Car Wash</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="car_wash" id="car_wash" placeholder="national Id Number" value="<?php echo htmlentities($result->CarWashExpenses);?>" required>
									</div>
								</div>

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Parking</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="parking" id="parking" placeholder="Parking Expenses" value="<?php echo htmlentities($result->ParkingExpenses);?>" required>
									</div>
								</div>

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Fuel Costs</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="fuel_costs" id="fuel_costs" placeholder="Tour Fuel Costs" value="<?php echo htmlentities($result->FuelCosts);?>" required>
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Other Costs</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="other_costs" id="other_costs" placeholder="Other Tour Costs" value="<?php echo htmlentities($result->OtherCosts);?>" >
									</div>
								</div>
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Park Entry Fee</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="park_entry_fee" id="park_entry_fee" placeholder="e.g KWS" value="<?php echo htmlentities($result->ParkEntryFee);?>" required>
									</div>
								</div>
											
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Tour Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="booking_price" id="booking_price" placeholder="Travel/Tour Price" value="<?php echo htmlentities($result->FuelCosts);?>" required>
									</div>
								</div>
													

		
								<?php }} ?>

								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submit" class="btn-primary btn">Update</button>
			</div>
		</div>
						
					
						
						
						
					</div>
					
					</form>

     
      

      
      <div class="panel-footer">
		
	 </div>
    </form>
  </div>
 	</div>
 	<!--//grid-->

<!-- script-for sticky-nav -->
		<script>
		$(document).ready(function() {
			 var navoffeset=$(".header-main").offset().top;
			 $(window).scroll(function(){
				var scrollpos=$(window).scrollTop(); 
				if(scrollpos >=navoffeset){
					$(".header-main").addClass("fixed");
				}else{
					$(".header-main").removeClass("fixed");
				}
			 });
			 
		});
		</script>
		<!-- /script-for sticky-nav -->
<!--inner block start here-->
<div class="inner-block">

</div>
<!--inner block end here-->
<!--copy rights start here-->
<?php include('includes/footer.php');?>
<!--COPY rights end here-->
</div>
</div>
  <!--//content-inner-->
		<!--/sidebar-menu-->
					<?php include('includes/sidebarmenu.php');?>
							  <div class="clearfix"></div>		
							</div>
							<script>
							var toggle = true;
										
							$(".sidebar-icon").click(function() {                
							  if (toggle)
							  {
								$(".page-container").addClass("sidebar-collapsed").removeClass("sidebar-collapsed-back");
								$("#menu span").css({"position":"absolute"});
							  }
							  else
							  {
								$(".page-container").removeClass("sidebar-collapsed").addClass("sidebar-collapsed-back");
								setTimeout(function() {
								  $("#menu span").css({"position":"relative"});
								}, 400);
							  }
											
											toggle = !toggle;
										});
							</script>
<!--js -->
<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<!-- Bootstrap Core JavaScript -->
   <script src="js/bootstrap.min.js"></script>
   <!-- /Bootstrap Core JavaScript -->	   

</body>
</html>
<?php } ?>