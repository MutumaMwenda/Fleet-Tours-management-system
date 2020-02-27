<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{

	$smt = $dbh->prepare('select id,FullName From tbldrivers');
    $smt->execute();
    $data = $smt->fetchAll();
	

if(isset($_POST['submit']))
{
$reg_no=$_POST['reg_no'];
$make=$_POST['make'];
$model=$_POST['model'];
$description=$_POST['description'];
$mileage=$_POST['mileage'];		
$assigned_driver=$_POST['assigned_driver'];
$insurance_expiry_date=$_POST['insurance_expiry_date'];
$licence_expiry_date=$_POST['licence_expiry_date'];
$next_inspection_date=$_POST['next_inspection_date'];
$next_service_date=$_POST['next_service_date'];
$created_on = date("Y/m/d") ;
$sql="INSERT INTO tblVehicles(RegNo,Make,Model,Description,Mileage,AssignedDriver,InsuranceExpiry,InpectionDate,RSLRenewalDate,Service_Date,CreatedOn) VALUES(:reg_no,:make,:model,:description,:mileage,:assigned_driver,:insurance_expiry_date,:next_inspection_date,:licence_expiry_date,:next_service_date,:created_on)";
$query = $dbh->prepare($sql);
$query->bindParam(':reg_no',$reg_no,PDO::PARAM_STR);
$query->bindParam(':make',$make,PDO::PARAM_STR);
$query->bindParam(':model',$model,PDO::PARAM_STR);
$query->bindParam(':mileage',$mileage,PDO::PARAM_STR);
$query->bindParam(':description',$description,PDO::PARAM_STR);
$query->bindParam(':assigned_driver',$assigned_driver,PDO::PARAM_STR);
$query->bindParam(':insurance_expiry_date',$insurance_expiry_date,PDO::PARAM_STR);
$query->bindParam(':next_inspection_date',$next_inspection_date,PDO::PARAM_STR);
$query->bindParam(':licence_expiry_date',$licence_expiry_date,PDO::PARAM_STR);
$query->bindParam(':next_service_date',$next_service_date,PDO::PARAM_STR);
$query->bindParam(':created_on',$created_on,PDO::PARAM_STR);
$query->execute();
$lastInsertId = $dbh->lastInsertId();
if($lastInsertId)
{
$msg="Vehicle Created Successfully";
}
else 
{
$error="Something went wrong. Please try again";
}

}



	?>
<!DOCTYPE HTML>
<html>
<head>
<title>SAT | Admin Vehicle Creation</title>
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
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Create Vehicle </li>
            </ol>
		<!--grid-->
 	<div class="grid-form">
 
<!---->
  <div class="grid-form1">
  	       <h3>Create Vehicle</h3>
  	        	  <?php if($error){?><div class="errorWrap"><strong>ERROR</strong>:<?php echo htmlentities($error); ?> </div><?php } 
				else if($msg){?><div class="succWrap"><strong>SUCCESS</strong>:<?php echo htmlentities($msg); ?> </div><?php }?>
  	         <div class="tab-content">
						<div class="tab-pane active" id="horizontal-form">
							<form class="form-horizontal" name="package" method="post" enctype="multipart/form-data">
								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Registration Number</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="reg_no" id="reg_no" placeholder="e.g. KAX 001L" required>
									</div>
								</div>
<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle Make</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="make" id="make" placeholder="e.g.  Toyota" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle Model</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="model" id="model" placeholder="e.g. Prado" required>
									</div>
								</div>

<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle Description</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="description" id="description" placeholder=" e.g. 7 seater" required>
									</div>
								</div>

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Vehicle Mileage</label>
									<div class="col-sm-8">
										<input type="text" class="form-control1" name="mileage" id="mileage" placeholder="40,000" required>
									</div>
								</div>


                               <div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Assigned Driver</label>
									<div class="col-sm-8" >
									<select name="assigned_driver" id="assigned_driver" class="form-control1">
										<option >Select a driver</option>
                                       <?php foreach ($data as $row): ?>
                                           <option value="<?= $row['id']; ?>"><?=$row["FullName"]?></option>
                                       <?php endforeach ?>
                                    </select>
									</div>
								</div>	
	

								<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Insurance Expiry Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="insurance_expiry_date" id="insurance_expiry_date" placeholder="e.g. 20/05/2021" required>
									</div>
								</div>	
									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">RSL Expiry Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="licence_expiry_date" id="licence_expiry_date" placeholder="e.g. 20/05/2021" required>
									</div>
								</div>	

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Next Inspection Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="next_inspection_date" id="next_inspection_date" placeholder="e.g. 20/05/2021" required>
									</div>
								</div>	

									<div class="form-group">
									<label for="focusedinput" class="col-sm-2 control-label">Next Service Date</label>
									<div class="col-sm-8">
										<input type="date" class="form-control1" name="next_service_date" id="next_service_date" placeholder="e.g. 20/05/2021" required>
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