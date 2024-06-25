<?php
include('../connect/connect.php');
include('../session/session_claim.php');

$q=$_GET['q'];
$count_q = strlen($q);
if($count_q==12){
   $vn_or_an=" o.vn ";
}elseif($count_q==9){
   $vn_or_an=" o.an ";
}

$sql = "SELECT #pa.* 
CONCAT(pa.pname,pa.fname,' ',pa.lname) AS pt_name
,pa.hn
,pa.cid
,pa.pttype AS 'สิทธิ Patient'
,pa.birthday
,pa.clinic
FROM $database.ovst o
LEFT OUTER JOIN $database.patient pa ON o.hn=pa.hn
WHERE $vn_or_an='$q'
LIMIT 1";

$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));

while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){


$hn = $row_concat_pttype["hn"];
$pt_name = $row_concat_pttype["pt_name"];

echo '<div class="card" style="width: 18rem;">
  <img src="index_claim/get_person_pic.php?hn='.$hn.'" class="card-img-top" alt="...">
  <div class="card-body">
    <h5 class="card-title">'.$pt_name.'</h5>
    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the cards content.</p>
    <a href="#" class="btn btn-primary">Link Test</a>
  </div>
</div>';
}


?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>



