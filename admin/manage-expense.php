<?php
session_start();
error_reporting(0);
include('includes/config.php');
if(strlen($_SESSION['alogin'])==0)
	{	
header('location:index.php');
}
else{ 
	?>
<!DOCTYPE HTML>
<html>
<head>
<title>SAT | admin manage vehicle expenses</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script type="application/x-javascript"> addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false); function hideURLbar(){ window.scrollTo(0,1); } </script>

<link href="css/bootstrap.min.css" rel='stylesheet' type='text/css' />

<link href="css/style.css" rel='stylesheet' type='text/css' />
<link rel="stylesheet" href="css/morris.css" type="text/css"/>

<link href="css/font-awesome.css" rel="stylesheet"> 

<script src="js/jquery-2.1.4.min.js"></script>

<link rel="stylesheet" type="text/css" href="css/table-style.css" />
<link rel="stylesheet" type="text/css" href="css/basictable.css" />
<script type="text/javascript" src="js/jquery.basictable.min.js"></script>
<script type="text/javascript">
    $(document).ready(function() {
      $('#table').basictable();

      $('#table-breakpoint').basictable({
        breakpoint: 768
      });

      $('#table-swap-axis').basictable({
        swapAxis: true
      });

      $('#table-force-off').basictable({
        forceResponsive: false
      });

      $('#table-no-resize').basictable({
        noResize: true
      });

      $('#table-two-axis').basictable();

      $('#table-max-height').basictable({
        tableWrapper: true
      });
    });
</script>
<link href='//fonts.googleapis.com/css?family=Roboto:700,500,300,100italic,100,400' rel='stylesheet' type='text/css'/>
<link href='//fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

<link rel="stylesheet" href="css/icon-font.min.css" type='text/css' />

</head> 
<body>
   <div class="page-container">

<div class="left-content">
	   <div class="mother-grid-inner">
          
				<?php include('includes/header.php');?>
				     <div class="clearfix"> </div>	
		</div>

<ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a><i class="fa fa-angle-right"></i>Manage Expenses</li>
          </ol>
<div class="agile-grids">	
				
				<div class="agile-tables">
					<div class="w3l-table-info">
					  <h2>Manage Expenses</h2>
					  
					    <table id="table">
						<thead>
						  <tr>
						  <th>#</th>
							<th>Expense</th>
							<th>Vehicle</th>
							<th>Amount</th>
							<th>Created On</th>
						  </tr>
						</thead>
						<tbody>
<?php $sql = "SELECT tblVehiclesExpense.id,tblvehicles.RegNo,tblVehiclesExpense.Expense ,tblVehiclesExpense.Amount,tblVehiclesExpense.CreatedOn
   from tblVehiclesExpense 
   join  tblvehicles on  tblvehicles.id=tblVehiclesExpense.VehicleId";
$query = $dbh -> prepare($sql);
//$query -> bindParam(':city', $city, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{			
	?>		
						  <tr>
							<td><?php echo htmlentities($cnt);?></td>
							<td><?php echo htmlentities($result->Expense);?></td>
							<td><?php echo htmlentities($result->RegNo);?></td>
							<td><?php echo htmlentities($result->Amount);?></td>
							<td><?php echo htmlentities($result->CreatedOn);?></td>
							>
							<td><a href="update-expense.php?vid=<?php echo htmlentities($result->id);?>"><button type="button" class="btn btn-primary btn-block">View Details</button></a></td>
						  </tr>
						 <?php $cnt=$cnt+1;} }?>
						</tbody>
					  </table>
					</div>
				  </table>

				
			</div>
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
<div class="inner-block">

</div>

<?php include('includes/footer.php');?>

</div>
</div>
 
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

<script src="js/jquery.nicescroll.js"></script>
<script src="js/scripts.js"></script>
<script src="js/bootstrap.min.js"></script>
     

</body>
</html>
<?php } ?>