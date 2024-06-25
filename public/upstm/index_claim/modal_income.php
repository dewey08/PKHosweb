<?php
include('../connect/connect.php');
include('../session/session.php');

$vn=$_REQUEST['vn'];
$count_q = strlen($vn);
if($count_q==12){
   $vn_or_an=" o.vn ";
}elseif($count_q==9){
   $vn_or_an=" o.an ";
}

$sql = "SELECT o.income
    ,IF(LENGTH(n.name)>25
        ,CONCAT( SUBSTR(n.name,1,25),'...')
        ,n.name
    ) AS name
    , SUM(o.qty) AS sum_qty ,SUM(o.sum_price) AS sum_sumprice
    FROM opitemrece o
    LEFT OUTER JOIN income n ON o.income=n.income
    WHERE $vn_or_an = '$vn'
    GROUP BY n.income LIMIT 100 ";

$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));
echo "<table class='table table-responsive table-striped table-hover'>";
echo "<tr>";
echo "<th><h3>Income</th>";
echo "<th><h3>หมวด</th>";
echo "<th><h3>จำนวน</th>";
echo "<th><h3>ราคารวม</th>";
echo "</tr>";

while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){

/*
$stmt = $mysqli->prepare($sql);
$stmt->bind_param("s", $_GET['q']);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($vn, $icode, $sumprice);
$stmt->fetch();
$stmt->close();
*/

echo "<tr>";

echo "<td><h4>" . $row_concat_pttype["income"] . "<h4></td>";
echo "<td><button type='button' onclick='showCus(this.id)' data-bs-toggle='popover' class='btn mb-1 btn-secondary' data-bs-trigger='focus' data-bs-html='true' title='รายละเอียดราย income' 
   id='".$vn.$row_concat_pttype["income"]."'><h4>" . $row_concat_pttype["name"] . "</h4></button></td>";
echo "<td><h4>" . $row_concat_pttype["sum_qty"] . "</td>";
echo "<td><h4>" . $row_concat_pttype["sum_sumprice"] . "</td>";

echo "</tr>";

}

echo "</table>";
echo "<div id='txtHin' style='margin-left:20px;'></div>"
?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>



