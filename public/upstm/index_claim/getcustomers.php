<?php
include('../connect/connect.php');
include('../session/session_claim.php');

$q=$_GET['q'];

#$vn=substr($q,0,12); // ตัดเอา VN 12 หลัก
#$income=substr($q,12); // ตัดเอา income# 9+2 หลักคือ income   12+2

if(strlen($q)=='11'){
      $vn=substr($q,0,9); // ตัดเอา VN 12 หลัก
      $income=substr($q,9); // ตัดเอา income
      $where_sql=" WHERE o.an = '$vn' AND o.income = '$income' ";
}elseif(strlen($q)=='14'){
      $vn=substr($q,0,12); // ตัดเอา VN 12 หลัก
      $income=substr($q,12); // ตัดเอา income
      $where_sql=" WHERE o.vn = '$vn' AND o.income = '$income' ";
}

if($income=='03' || $income=='04' || $income=='17'){
	$left_join = " drugitems ";
}else{
	$left_join = " nondrugitems ";
}

$sql = "SELECT n.nhso_adp_code, n.name, SUM(o.qty) AS sum_qty 
      ,SUM(if(o.paidst=02,o.sum_price,0)) AS uc_money 
      ,SUM(if(o.paidst!=02,o.sum_price,0)) AS paid_money 
      FROM opitemrece o
      LEFT OUTER JOIN $left_join n ON o.icode=n.icode
      $where_sql
      GROUP BY o.vn,o.icode LIMIT 100 
";
$s_income = "SELECT name FROM income WHERE income='$income' LIMIT 1 ";
$q_income = mysqli_query($con_hos, $s_income) or die(mysqli_error($con_hos));
$r_income = mysqli_fetch_array($q_income);
echo "<h3>".$income." ".$r_income["name"];
echo "<BR>"."<BR>";
$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));
echo "<table class='table table-responsive table-striped table-hover'>";
echo "<tr>";
echo "      <th><h4>nhso_adp_code</th>";
echo "      <th><h4>name</th>";
echo "      <th><h4>จำนวน</th>";
echo "      <th><h4>uc_money</th>";
echo "      <th><h4>paid_money</th>";
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

echo "<td><h4>" . $row_concat_pttype["nhso_adp_code"] . "</td>";
echo "<td><h4>" . $row_concat_pttype["name"] . "</td>";
echo "<td><h4>" . $row_concat_pttype["sum_qty"] . "</td>";
echo "<td><h4>" . number_format($row_concat_pttype["uc_money"],2) . "</td>";
echo "<td><h4>" . number_format($row_concat_pttype["paid_money"],2) . "</td>";

echo "</tr>";

}

echo "</table>";
echo "<div id='txtHin'></div>"
?>
