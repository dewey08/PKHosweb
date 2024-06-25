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

$sql = "SELECT o.income, n.name, SUM(o.qty) AS sum_qty ,SUM(o.sum_price) AS sum_sumprice
FROM opitemrece o
LEFT OUTER JOIN income n ON o.income=n.income
WHERE $vn_or_an = '$q'
GROUP BY n.income LIMIT 100 ";

$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));
echo "<table class='table table-striped table-hover'>";
echo "<tr>";
echo "<th>in_come</th>";
echo "<th>name</th>";
echo "<th>sum_qty</th>";
echo "<th>sum_price</th>";
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

echo "<td>" . $row_concat_pttype["income"] . "</td>";
echo "<td><a onclick='showCus(this.id)' data-bs-toggle='popover' class='btn btn-sm btn-success' data-bs-trigger='focus' data-bs-html='true' title='รายละเอียดราย income' 
   id='".$q.$row_concat_pttype["income"]."'>" . $row_concat_pttype["name"] . "</a></td>";
echo "<td>" . $row_concat_pttype["sum_qty"] . "</td>";
echo "<td>" . $row_concat_pttype["sum_sumprice"] . "</td>";

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



