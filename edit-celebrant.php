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

if(isset($_POST['update']))
{
$fname=$_POST['fname'];
$annidate=$_POST['annidate'];
$phone=$_POST['phone'];
$id=intval($_GET['id']);
$stdid =$_GET['stdid'];
$sql="update tblbooks set CelebrantName=:fname,MobileNumber=:phone,AnniversaryDate=:annidate where id=:id and StudentId=:stdid";
$query = $dbh->prepare($sql);
$query->bindParam(':fname',$fname,PDO::PARAM_STR);
$query->bindParam(':annidate',$annidate,PDO::PARAM_STR);
$query->bindParam(':phone',$phone,PDO::PARAM_STR);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->execute();
echo "<script>alert('Celebrant record updated successfully');</script>";
echo "<script>window.location.href='show-records.php'</script>";


}
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anniversary Records Management System | Edit Celebrant</title>
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
                <h4 class="header-line">Edit Celebrant</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md12 col-sm-12 col-xs-12">
<div class="panel panel-info">
<div class="panel-heading">
Celebrant Info
</div>
<div class="panel-body">
<form role="form" method="post">
<?php 
$id=intval($_GET['id']);
$stdid =$_GET['stdid'];
$sql = "SELECT * FROM tblbooks where id=:id and StudentId=:stdid";
$query = $dbh -> prepare($sql);
$query->bindParam(':id',$id,PDO::PARAM_STR);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  



<div class="col-md-6">
<div class="form-group">
<label>Celebrant Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="fname" value="<?php echo htmlentities($result->CelebrantName);?>" required />
</div></div>

<div class="col-md-6">
<div class="form-group">
<label>Anniversary Date<span style="color:red;">*</span></label>
<input class="form-control" type="date" name="annidate" value="<?php echo htmlentities($result->AnniversaryDate);?>" required />
</div></div>

<div class="col-md-6">
<div class="form-group">
<label>Celebrant Phone<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="phone" value="<?php echo htmlentities($result->MobileNumber);?>" required />
</div></div>

<div class="col-md-6">
<div class="form-group">
<label> Anniversary Type:<span style="color:red;">*</span></label>
<label><?php echo htmlentities($catname=$result->CatId);?></label>

 <?php }}} ?> 
</select>
</div></div>

</div></div>
 <?php  ?><div class="col-md-12">
<button type="submit" name="update" class="btn btn-info">Update </button></div>

                                    </form>
                            </div>
                        </div>
                            </div>

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
<?php  ?>
