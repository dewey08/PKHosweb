<?php
include('../connect/connect.php');
include('../session/session.php');

$pttype=$_REQUEST['pttype'];

if($pttype!=''){
    $sql = "SELECT 
    name, pttype
    FROM temp_pttype_hos 
    WHERE pttype='$pttype' limit 1 ";
}

$result_concat_pttype = mysqli_query($con_money, $sql) or die($pttype);
$row_concat_pttype = mysqli_fetch_array($result_concat_pttype);
echo "<table class='table table-responsive table-striped table-hover' >";
echo "<tr>";
echo "<th><h3>" .$row_concat_pttype["pttype"]."-".$row_concat_pttype["name"] . "</th>";
echo "</tr>";
echo "</table>";
echo "<div id='txtHin' style='margin-left:20px;'></div>"
?>



