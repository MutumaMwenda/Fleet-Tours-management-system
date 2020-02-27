<?php
session_start();
error_reporting(0);
// error_reporting(E_ALL); ini_set('display_errors', 1);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

	$smt = $dbh->prepare('select id,FullName From tbldrivers');
    $smt->execute();
    $data = $smt->fetchAll();

  /*  $smt1 = $dbh->prepare('select t1.id,t1.RegNo From tblvehicles t1 LEFT JOIN tblbookings t2 ON t2.VehicleBooked=t1.id WHERE t2.VehicleBooked IS NULL');*/
     $smt1 = $dbh->prepare('select id,RegNo From tblvehicles ');
    $smt1->execute();
    $vehicle_data = $smt1->fetchAll();
    

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
if($other_costs==NULL){
	$other_costs=0;
}
$park_entry_fee=$_POST['park_entry_fee'];
$booking_price=$_POST['booking_price'];
date_default_timezone_set('Africa/Nairobi');
$created_on=date('m/d/Y'); 



$availabilitysql="SELECT * FROM tblbookings WHERE VehicleBooked=? AND (DateFrom between ? AND ? ) AND(DateTo between ? AND ?)";
    $availability = $dbh->prepare($availabilitysql);
    $availability->execute([$vehicle,$date_from,$date_to,$date_from,$date_to]);
    $avail= $availability->fetch();

    $driveravailabilitysql="SELECT * FROM tblbookings WHERE DriverBooked=? AND (DateFrom between ? AND ? ) AND(DateTo between ? AND ?)";
    $driveravailability = $dbh->prepare($driveravailabilitysql);
    $driveravailability->execute([$driver,$date_from,$date_to,$date_from,$date_to]);
    $driveravail= $driveravailability->fetch();

 if($avail){
  	
       $error="The vehicle is booked within this period";
  }else if($driveravail){

 $error="The driver is booked within this period";
  }
  else{


$sql="INSERT INTO tblbookings (VehicleBooked,DriverBooked,Destination,DateFrom,DateTo,Duration,Allowances,CarWashExpenses,ParkingExpenses,FuelCosts,CreatedOn,OtherCosts,ParkEntryFee,BookingPrice) VALUES(:vehicle,:driver,:destination,:date_from,:date_to,:duration,:allowance,:car_wash,:parking,:fuel_costs,:created_on,:other_costs,:park_entry_fee,:booking_price)";
$query = $dbh->prepare($sql);
$query->bindParam(':vehicle',$vehicle,PDO::PARAM_STR);
$query->bindParam(':driver',$driver,PDO::PARAM_STR);
$query->bindParam(':destination',$destination,PDO::PARAM_STR);
$query->bindParam(':date_from',$date_from,PDO::PARAM_STR);
$query->bindParam(':date_to',$date_to,PDO::PARAM_STR);
$query->bindParam(':allowance',$allowance,PDO::PARAM_STR);
$query->bindParam(':duration',$duration,PDO::PARAM_STR);
$query->bindParam(':car_wash',$car_wash,PDO::PARAM_STR);
$query->bindParam(':parking',$parking,PDO::PARAM_STR);
$query->bindParam(':fuel_costs',$fuel_costs,PDO::PARAM_STR);
$query->bindParam(':created_on',$created_on,PDO::PARAM_STR);
$query->bindParam(':other_costs',$other_costs,PDO::PARAM_STR);
$query->bindParam(':park_entry_fee',$park_entry_fee,PDO::PARAM_STR);
$query->bindParam(':booking_price',$booking_price,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Booking Created Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}
}
}

	?>
<!DOCTYPE HTML>
<html>
<head>
<title>SAT | Admin Booking Creation</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="keywords" content="tours , travels"/>
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
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Create Booking </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Create Booking</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle </label>
									<div class="col-sm-8">
									<select name="vehicle" id="vehicle" class="form-control1" required>
										<option >Select a Vehicle</option>
                                       <?php foreach ($vehicle_data as $row): ?>
                                           <option value="<?= $row['id']; ?>"><?=$row["RegNo"]?></option>
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
                                           <option value="<?= $row['id']; ?>"><?=$row["FullName"]?></option>
                                       <?php endforeach ?>
                                    </select>
										
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Destination</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="destination" id="destination" placeholder="Tour Destination" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date From</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="date_from" id="date_from" placeholder=" Tour Start Date" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Date To</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="date_to" id="date_to" placeholder="Tour Ending Date" required>
									</div>
								</div>	

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Duration</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1"onmousemove = "getDuration()" name="duration" id="duration" placeholder="Trip Duration" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Allowance</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="allowance" id="allowance" placeholder="Driver allowance" required>
									</div>
								</div>	

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Car Wash</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="car_wash" id="car_wash" placeholder="Car wash Expenses" required>
									</div>
								</div>

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Parking</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="parking" id="parking" placeholder="Parking Expenses" required>
									</div>
								</div>

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Fuel Costs</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="fuel_costs" id="fuel_costs" placeholder="Tour Fuel Costs" required>
									</div>
								</div>
										<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Other Costs</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="other_costs" id="other_costs" placeholder="Other Travel Costs" >
									</div>
								</div>
											<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Park Entry Fee</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="park_entry_fee" id="park_entry_fee" placeholder="e.g KWS" required>
									</div>
								</div>
									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Trip Price</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="booking_price" id="booking_price" placeholder="Tour/Travel Price" required>
									</div>
								</div>			


								<div class="row">
			<div class="col-sm-8 col-sm-offset-2">
				<button type="submit" name="submit" class="btn-primary btn">Create</button>

				<button type="reset" class="btn-inverse btn">Reset</button>
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
		<script type="text/javascript">
    function getDuration() {
        var date1 = new Date(document.getElementById("date_from").value); 
        var date2 = new Date(document.getElementById("date_to").value); 
        var timeDiff = Math.abs(date2.getTime() - date1.getTime()); 
        var timeDiff = Math.ceil(timeDiff /(1000*24*60*60)); 
        document.getElementById("duration").value = timeDiff+1;
    }
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