<?php
include('../connect/connect.php');
include('../session/session_claim.php');

function DateThaisubmonth($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มค","กพ","มีค","มย","พค","มิย","กค","สค","กย","ตค","พย","ธค");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strDay $strMonthThai $strYear";
}

$pang_stamp_send=$_REQUEST['pang_stamp_send'];


$sql = "SELECT *
         FROM pang_stamp_send
         WHERE pang_stamp_send = '$pang_stamp_send'
         AND pang_stamp_edit IS NOT NULL
         GROUP BY pang_stamp_edit
         LIMIT 123
      ";

$result_concat_pttype = mysqli_query($con_money, $sql) or die(mysqli_error($con_money));
echo "<table class='table table-striped table-hover'>";
echo "<tr>";
echo "<th>No</th>";
echo "<th>ฉบับที่</th>";
echo "<th>วันที่ปรับปรุง</th>";
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

echo "<td>" . $row_concat_pttype["pang_stamp_edit"] . "</td>";
echo "<td><a class='btn btn-success ' target='_blank' href='../report/index_calim_send.php?pang_stamp_send=".$row_concat_pttype["pang_stamp_send"]."&pang_stamp_edit=".$row_concat_pttype["pang_stamp_edit"]."'>รายงานฉบับที่ ".$row_concat_pttype["pang_stamp_edit"]."</a></td>";
echo "<td>" . DateThaisubmonth($row_concat_pttype["pang_stamp_send_date"]) . "</td>";
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



