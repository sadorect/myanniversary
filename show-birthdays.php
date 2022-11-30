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



    ?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Anniversary Records Management System |  Issued Books</title>
    <!-- BOOTSTRAP CORE STYLE  -->
    <link href="assets/css/bootstrap.css" rel="stylesheet" />
    <!-- FONT AWESOME STYLE  -->
    <link href="assets/css/font-awesome.css" rel="stylesheet" />
    <!-- DATATABLE STYLE  -->
    <link href="assets/js/dataTables/dataTables.bootstrap.css" rel="stylesheet" />
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
                <h4 class="header-line">View Anniversary Records</h4>
    </div>
    

            <div class="row">
                <div class="col-md-12">
                    <!-- Advanced Tables -->
                    <div class="panel panel-default">
                        <div class="panel-heading">
                          Celebrants 
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover" id="dataTables-example">
                                    <thead>
                                   
                                        <tr>
                                            <th>#&nbsp;&nbsp;<input type="checkbox" name="check_all" id="check_all" value=""/></th>
                                            <th>Name</th>
                                            <th>Phone </th>
                                            <th>Anniversary</th>
                                            <th>Date</th>
                                           <th>Operations &nbsp;&nbsp; <input type="submit"  name="btn_delete_select" value="Delete Selected"/></th>
                                        </tr>    
                                    </thead>
                                    <tbody>
<?php 
$sid=$_SESSION['stdid'];
$catid=1;
$sql='SELECT id,CelebrantName,MobileNumber,CatId,DATE_FORMAT(AnniversaryDate, "%b %d") as aDate FROM tblbooks where StudentId=:sid and CatId=:catid ORDER BY MONTH(AnniversaryDate) ASC';//order by tblissuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
//$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query-> bindParam(':catid', $catid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

function anniversaryType($annivType){
    if ($annivType == 1){
        $whatType = "Birthday";
    }else{
            $whatType = "Wedding";
        }
        return $whatType;
    }
if($query->rowCount() > 0)
{
foreach($results as $result)
{   
 
    ?>                              
                                        <tr class="odd gradeX" id="<?php echo $sid; ?>">
                                            <td class="center" id="<?php echo $result->id;?>"><?php echo htmlentities($cnt)."  ";?><input type="checkbox" class="checkbox" name="selected_id[]"  value="<?php echo $result->id; ?>"/></td>
                                            <td class="center" contenteditable="true" id="<?php echo 'CelebrantName:' .$result->id;?>"><?php echo htmlentities($result->CelebrantName);?></td>
                                            <td class="center" contenteditable="true" id="<?php echo 'MobileNumber:'. $result->id;?>"><?php echo "0".htmlentities($result->MobileNumber);?></td>
                                            <td class="center" id="updated"><?php echo anniversaryType($result->CatId);?></td>
                                            <td class="center" contenteditable="true" id="<?php echo 'aDate:'. $result->id;?>"><?php echo $result->aDate;?></td>
                                            <td class="center">

<a href="edit-celebrant.php?stdid=<?php echo $sid; ?>&id=<?php echo htmlentities($result->id);?>"><button class="btn btn-primary to-edit"  id="updated"><i class="fa fa-edit "></i> Edit</button> 
<a href="manage-celebrant.php?del=<?php echo htmlentities($result->id);?>" onclick="return confirm('Are you sure you want to delete this celebrant?');"" >  <button class="btn btn-danger"><i class="fa fa-pencil"></i> Delete</button>
</td> 
                                         
                                        </tr>

        <!----- TOGGLE DISPLAY SECTION FOR EDIT OPERATION  -->
                                        
                                       
 <?php $cnt=$cnt+1;}} ?>                                      
                                    </tbody>
                                </table>
                            </div>
                            
                        </div>
                    </div>
                    <!--End Advanced Tables -->
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
    <!-- DATATABLE SCRIPTS  -->
    <script src="assets/js/dataTables/jquery.dataTables.js"></script>
    <script src="assets/js/dataTables/dataTables.bootstrap.js"></script>
      <!-- CUSTOM SCRIPTS  -->
    <script src="assets/js/custom.js"></script>
    <script>

<script type="text/javascript">
function deleteConfirm(){
    var result = confirm("Do you really want to delete records?");
    if(result){
        return true;
    }else{
        return false;
    }
}
$(document).ready(function(){
    $('#check_all').on('click',function(){
        if(this.checked){
            $('.checkbox').each(function(){
                this.checked = true;
            });
        }else{
             $('.checkbox').each(function(){
                this.checked = false;
            });
        }
    });
    
    $('.checkbox').on('click',function(){
        if($('.checkbox:checked').length == $('.checkbox').length){
            $('#check_all').prop('checked',true);
        }else{
            $('#check_all').prop('checked',false);
        }
    });
});
</script>
<?php
/*
    $(document).ready(function(){

      
    //acknowledgement message
    var message_status = $("#status");
    $("td[contenteditable=true]").focus(function{
    
        var old_content = $this.text();
    
    });
    $("td[contenteditable=true]").blur(function(){
        var new_content = $this.text();
        if (old_content == new_content){alert('Content Changed!');
        } else {alert("Nothing happend!");}

        var field_userid = $(this).attr("id") ;
        var value = $(this).text() ;
        var recorder = $(tr.id).text();
        $.post('edit-records.php' , field_userid + "=" + value + recorder, function(data){
            if(data != '')
            {
                message_status.show();
                message_status.text(data);
                //hide the message
                setTimeout(function(){message_status.hide()},3000);
            }
        });
    });





 /**       $("#editable").hide();
  $(".to-edit").click(function(){
    $(this).hide();
    var id = $(this).attr('id');
    if(id === "edit"){
        $(this).parents('tr').find('td.editable').show();
    }
  });
});*/
?>
    
   </script>
    </script>
</body>
</html>
<?php } ?>
