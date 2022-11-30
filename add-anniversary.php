<?php
session_start();
include('includes/error-reporting.php');
include('includes/config.php');
if(strlen($_SESSION['login'])==0)
    {   
header('location:index.php');
}
else{ 
$stdid = $_SESSION['stdid'];
if(isset($_POST['add']))
{
$celebrantName=$_POST['celebrantName'];
$category=$_POST['category'];
$anniversaryDate=$_POST['anniversaryDate'];
if(!isset($_POST['phone'])){
$phone = 12345678;} else {
$phone=$_POST['phone'];}
//$price=$_POST['price'];
/*if(isset($_FILES["bookpic"]["name"]) && !empty($_FILES["bookpic"]["name"]))
{
    $bookimg=$_FILES["bookpic"]["name"];
// get the image extension
$extension = substr($bookimg,strlen($bookimg)-4,strlen($bookimg));
// allowed extensions
$allowed_extensions = array(".jpg","jpeg",".png",".gif");
// Validation for allowed extensions .in_array() function searches an array for a specific value.
//rename the image file
$imgnewname=md5($bookimg.time()).$extension;
// Code for move image into directory

if(!in_array($extension,$allowed_extensions))
{
echo "<script>alert('Invalid format. Only jpg / jpeg/ png /gif format allowed');</script>";
}
else
{
move_uploaded_file($_FILES["bookpic"]["tmp_name"],"bookimg/".$imgnewname);
}
} else{
    $imgnewname="";
}
*/
#$sql="INSERT INTO  tblbooks(CelebrantName,CatId,AuthorId,MobileNumber,bookImage) VALUES(:bookname,:category,:author,:isbn,:imgnewname)";
$sql="INSERT INTO  tblbooks(StudentId,CelebrantName,CatId,AnniversaryDate,MobileNumber) VALUES(:stdid,:celebrantName,:category,:anniversaryDate,:phone)";
$query = $dbh->prepare($sql);
$query->bindParam(':celebrantName',$celebrantName,PDO::PARAM_STR);
$query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
$query->bindParam(':category',$category,PDO::PARAM_STR);
$query->bindParam(':anniversaryDate',$anniversaryDate,PDO::PARAM_STR);
$query->bindParam(':phone',$phone,PDO::PARAM_INT);
//$query->bindParam(':price',$price,PDO::PARAM_STR);
//$query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
//$query->execute();
//$lastInsertId = $dbh->lastInsertId();
    if($query->execute())
    {
echo "<script>alert('Anniversary Record added successfully');</script>";
//echo "<script>window.location.href='manage-books.php'</script>";

    }
else 
        {
echo "<script>alert('Something went wrong. Please try again');</script>";    
die(print_r($query->errorInfo(), true));
//echo "<script>window.location.href='manage-records.php'</script>";  
        }
    }
}

///CSV PROCESSING AREA


// include mysql database configuration file

 
if (isset($_POST['upload']))
{
 
    // Allowed mime types
    $fileMimes = array(
        'text/x-comma-separated-values',
        'text/comma-separated-values',
        'application/octet-stream',
        'application/vnd.ms-excel',
        'application/x-csv',
        'text/x-csv',
        'text/csv',
        'application/csv',
        'application/excel',
        'application/vnd.msexcel',
        'text/plain'
    );
 
    // Validate whether selected file is a CSV file
    if (!empty($_FILES['csvfile']['name']) && in_array($_FILES['csvfile']['type'], $fileMimes))
    {
       // $stdid = $_SESSION['stdid'];
            // Open uploaded CSV file with read-only mode
            $csvFile = fopen($_FILES['csvfile']['tmp_name'], 'r');
 
            // Skip the first line
            fgetcsv($csvFile);
 
            // Parse data from CSV file line by line
             // Parse data from CSV file line by line
            while (($getData = fgetcsv($csvFile, 10000, ",")) !== FALSE)
            {   // celebrantname,mobilenumber,catid,anniversarydate
                // Get row data
                $name = $getData[0];
                $phone = $getData[1];
                $catid = $getData[2];
                $date = $getData[3];
               
                $sql="INSERT INTO  tblbooks(StudentId,CelebrantName,CatId,AnniversaryDate,MobileNumber) VALUES(:stdid,:celebrantName,:category,:anniversaryDate,:phone)";
                $query = $dbh->prepare($sql);
                $query->bindParam(':celebrantName',$name,PDO::PARAM_STR);
                $query->bindParam(':stdid',$stdid,PDO::PARAM_STR);
                $query->bindParam(':category',$catid,PDO::PARAM_STR);
                $query->bindParam(':anniversaryDate',$date,PDO::PARAM_STR);
                $query->bindParam(':phone',$phone,PDO::PARAM_STR);
                //$query->bindParam(':price',$price,PDO::PARAM_STR);
                //$query->bindParam(':imgnewname',$imgnewname,PDO::PARAM_STR);
                $query->execute();
            }
                $lastInsertId = $dbh->lastInsertId();
                    if($lastInsertId)
                    {
                echo "<script>alert('Anniversary Record added successfully');</script>";
                //echo "<script>window.location.href='manage-books.php'</script>";

                    } else 
                        {
                echo "<script>alert('Something went wrong. Please try again');</script>";    



                // If user already exists in the database with the same email
                //$query = "SELECT id FROM tblbooks WHERE email = '" . $getData[1] . "'";
 
               /* $check = mysqli_query($conn, $query);
 
                if ($check->num_rows > 0)
                {
                    mysqli_query($conn, "UPDATE users SET name = '" . $name . "', phone = '" . $phone . "', status = '" . $status . "', created_at = NOW() WHERE email = '" . $email . "'");
                }
                else
                {
                     mysqli_query($conn, "INSERT INTO users (name, email, phone, created_at, updated_at, status) VALUES ('" . $name . "', '" . $email . "', '" . $phone . "', NOW(), NOW(), '" . $status . "')");
 
                 }*/
                }
 
            // Close opened CSV file
            fclose($csvFile);
 
           // header("Location: index.php");
         
           // }   
   
        }     else
    {
    echo "<script>alert('Please select a valid csv file');</script>"; 
    }

}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anniversary Records Management System | Add Anniversary</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- CUSTOM STYLE  -->
    <link href="assets/css/style.css" rel="stylesheet" />
    <!-- GOOGLE FONT -->
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
<script type="text/javascript">
    function checkisbnAvailability() {
$("#loaderIcon").show();
jQuery.ajax({
url: "check_availability.php",
data:'isbn='+$("#isbn").val(),
type: "POST",
success:function(data){
$("#isbn-availability-status").html(data);
$("#loaderIcon").hide();
},
error:function (){}
});
}

</script>
</head>
<body>
      <!------MENU SECTION START-->
<?php include('includes/header.php');?>
<!-- MENU SECTION END-->
    <div class="content-wrapper">
         <div class="container">
        <div class="row pad-botm">
            <div class="col-md-12">
                <h4 class="header-line">Add Anniversary</h4>
                
                            </div>

</div>
<div class="row">
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="panel panel-info">
<div class="panel-heading">
Anniversary Details
</div>
<div class="panel-body">
<form role="form" method="post" enctype="multipart/form-data">

<div class="col-md-6">   
<div class="form-group">
<label>Celebrant Name<span style="color:red;">*</span></label>
<input class="form-control" type="text" name="celebrantName" autocomplete="on" />
</div>
</div>

<div class="col-md-6">  
<div class="form-group">
<label> Anniversary Type<span style="color:red;">*</span></label>
<select class="form-control" name="category" required="required">
<option value=""> Select Anniversary</option>
<?php 
$status=1;
$sql = "SELECT * from  tblcategory where Status=:status";
$query = $dbh -> prepare($sql);
$query -> bindParam(':status',$status, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->CategoryName);?></option>
 <?php }} ?> 
</select>
</div></div>

<div class="col-md-6">  
<div class="form-group">
<label> Anniversary Date<span style="color:red;">*</span></label>
<input type="date" id="author" name="anniversaryDate">
<!--select class="form-control" name="author" required="required">
<option value=""> Select Date</option>
<?php /*

$sql = "SELECT * from  tblauthors ";
$query = $dbh -> prepare($sql);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;
if($query->rowCount() > 0)
{
foreach($results as $result)
{               ?>  
<option value="<?php echo htmlentities($result->id);?>"><?php echo htmlentities($result->AuthorName);?></option>
 <?php }} */?> 
</select-->
</div></div>

<div class="col-md-6">  
<div class="form-group">
<label>Mobile Number<span style="color:red;"> </span></label>
<input class="form-control" type="text" name="phone" id="isbn" autocomplete="on" />
<p class="help-block">Celebrant's GSM number to receive SMS</p>
         <span id="isbn-availability-status" style="font-size:12px;"></span>
</div></div>

<div class="col-md-6">  
 <div class="form-group">
 <label><span style="color:red;"></span></label>
 <!--input class="form-control" type="text" name="price" autocomplete="off"   required="required" /-->
 <button type="submit" name="add" id="add" class="btn btn-info">Submit </button>
 </div>
</div>
</form>

<form role="form" method="post" enctype="multipart/form-data">
<div class="col-md-6">  
 <div class="form-group">
 <label>Upload Celebrants in Bulk (.csv only)<span style="color:red;"></span></label>
 <input class="form-control" type="file" name="csvfile" autocomplete="off"    /><br>
 <button type="submit" name="upload" id="add" class="btn btn-info">Upload </button>
 </div>
    </div>
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

