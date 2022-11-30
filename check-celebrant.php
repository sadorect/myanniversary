<?php 

include('includes/error-reporting.php');

include('includes/config.php');
$currentDate = new DateTime();

$sql="SELECT * FROM tblstudents";//order by tblissuedbookdetails.id desc";
$query = $dbh -> prepare($sql);
//$query-> bindParam(':sid', $sid, PDO::PARAM_STR);
$query->execute();
$results=$query->fetchAll(PDO::FETCH_OBJ);
$cnt=1;

if($query->rowCount() > 0)
{
 
  
  while ($results){
    foreach($results as $registrar){
      echo "<b><p>Records for ".$registrar->StudentId." : <br></b>";
      echo "___________________<br>";
// CHECK FOR A CELEBRANT TODAY AND FETCH ONLY THOSE RECORDS
      
      $thisday= $currentDate->format('d');
      $thismonth= $currentDate->format('m');

    $stdid= $registrar->StudentId;
    $wedding = 2;
    $sql="SELECT * FROM tblbooks WHERE StudentId=:stdid and MONTH(AnniversaryDate)=:thismonth and DAY(AnniversaryDate)=:thisday and CatId=:catid";//order by tblissuedbookdetails.id desc";
    $query = $dbh -> prepare($sql);
    $query-> bindParam(':stdid', $stdid, PDO::PARAM_STR);
    $query-> bindParam(':thisday', $thisday, PDO::PARAM_STR);
    $query-> bindParam(':thismonth', $thismonth, PDO::PARAM_STR);
    $query-> bindParam(':catid', $wedding, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

      if($query->rowCount() > 0){
        echo "WEDDING CELEBRANTS<br>";
        echo "You have <b>".$query->rowCount()."</b> celebrants<br>";
        foreach ($results as $celebrant){

    //SEPARATE CELEBRANTS ACCORDING TO THEIR ANNIVERSARY TYPES (BIRTHDAY | WEDDING)
    //BIRTHDAYS FIRST
                  
        echo $celebrant->CelebrantName."<br>";

              }
          }
// REPEAT THE QUERY FOR BIRTHDAY CELEBRANTS

$birthday = 1;
    $sql="SELECT * FROM tblbooks WHERE StudentId=:stdid and MONTH(AnniversaryDate)=:thismonth and DAY(AnniversaryDate)=:thisday and CatId=:catid";//order by tblissuedbookdetails.id desc";
    $query = $dbh -> prepare($sql);
    $query-> bindParam(':stdid', $stdid, PDO::PARAM_STR);
    $query-> bindParam(':thisday', $thisday, PDO::PARAM_STR);
    $query-> bindParam(':thismonth', $thismonth, PDO::PARAM_STR);
    $query-> bindParam(':catid', $birthday, PDO::PARAM_STR);
    $query->execute();
    $results=$query->fetchAll(PDO::FETCH_OBJ);

      if($query->rowCount() > 0){
        echo "<p>BIRTHDAY CELEBRANTS<br>";
        echo "You have <b>".$query->rowCount()."</b> celebrants<br>";
        foreach ($results as $celebrant){

    //SEPARATE CELEBRANTS ACCORDING TO THEIR ANNIVERSARY TYPES (BIRTHDAY | WEDDING)
    //BIRTHDAYS FIRST
                  
        echo $celebrant->CelebrantName."<br>";

              }
          }


      }

}
  //echo $result->StudentId;

 
}

/*
$result = $mysqli->query($query);
while($row = $result->fetch_object()){
  $query = "UPDATE product_option_value SET quantity = quantity - {$row->quantity} WHERE product_id='{$row->id}' AND option_value_id='{$row->option_value_id}'";
  $mysqli->query($query);
}

*/
?>