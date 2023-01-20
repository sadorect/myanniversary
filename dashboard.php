<?php
session_start();
error_reporting(0);
include('includes/error-reporting.php');
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
  { 
header('location:index.php');
}
else{
  $stdid = $_SESSION['stdid'];  ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anniversary Records Management System | User DashBoard</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />

</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">User DASHBOARD</h4>
                
                            </div>

        </div>
             
             <div class="row">


<a href="show-birthdays.php">
<div class="col-md-4 col-sm-4 col-xs-6">
 <div class="alert alert-success back-widget-set text-center">
 <i class="fa fa-book fa-5x"></i>
<?php 
$annicat = 1;
$sql ="SELECT * from tblbooks where StudentId=:stdid and CatID = :annicat";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->bindParam(':annicat',$annicat,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listdbooks=$query->rowCount();
?>
<h3><?php echo htmlentities($listdbooks);?></h3>
Birthday Celebrants
</div></div></a>
<a href="show-weddings.php">
               <div class="col-md-4 col-sm-4 col-xs-6">
                      <div class="alert alert-warning back-widget-set text-center">
                            <i class="fa fa-recycle fa-5x"></i>
<?php 
$annicat = 2;
$sql ="SELECT * from tblbooks where StudentId=:stdid and CatID = :annicat";
$query = $dbh -> prepare($sql);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->bindParam(':annicat',$annicat,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$listdbooks=$query->rowCount();
?>

                            <h3><?php echo htmlentities($listdbooks);?></h3>
                          Wedding Celebrants
                        </div>
                    </div></a>

<!--a href="#">
<div class="col-md-4 col-sm-4 col-xs-6">
 <div class="alert alert-success back-widget-set text-center">
 <i class="fa fa-book fa-5x"></i>
      <h3>&nbsp;</h3>
Issued Books
</div></div></a-->





        </div>    
    </div>
    </div>
     <!-- CONTENT-WRAPPER SECTION END-->
<?php include('includes/footer.php');?>
      <!-- FOOTER SECTION END-->
    <!-- JAVASCRIPT FILES PLACED AT THE BOTTOM TO REDUCE THE LOADING TIME  -->
    <!-- CORE JQUERY  -->
    <script src="assets/js/jquery-1.10.2.js"></script>
    <!-- BOOTSTRAP SCRIPTS  -->
    <script src="assets/js/bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
</body>
</html>
<?php } ?>
