<?php
include('../connect/connect.php');
include('../session/session_claim.php');

$q=$_GET['q'];
$count_q = strlen($q);
if($count_q==12){
    $sql = "SELECT 
    od.diagtype, od.icd10, od.doctor
    ,d.name, d.licenseno
    FROM ovstdiag od 
    LEFT OUTER JOIN doctor d ON od.doctor=d.code
    where od.vn='$q'
    ORDER BY od.diagtype
    limit 30 ";
}elseif($count_q==9){
    $sql = "SELECT 
    id.diagtype, id.icd10, id.doctor
    ,d.name, d.licenseno
    FROM iptdiag id 
    LEFT OUTER JOIN doctor d ON id.doctor=d.code
    where id.an='$q'
    ORDER BY id.diagtype
    limit 30 ";
}

$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));
echo "<table class='table table-striped table-hover'>";
echo "<tr>";
echo "<th>diagtype</th>";
echo "<th>icd10</th>";
echo "<th>doctor</th>";
echo "<th>name</th>";
echo "<th>licenseno</th>";
echo "</tr>";

while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){

echo "<tr>";
echo "<td>" . $row_concat_pttype["diagtype"] . "</td>";
echo "<td>" . $row_concat_pttype["icd10"].	"</td>";
echo "<td>" . $row_concat_pttype["doctor"] . "</td>";
echo "<td>" . $row_concat_pttype["name"] . "</td>";
echo "<td>" . $row_concat_pttype["licenseno"] . "</td>";
echo "</tr>";

}

if($count_q==9){
    $s_icd9 = "SELECT 
    CONCAT(id.opdate,id.optime,' / ',id.enddate,id.endtime) AS oprt_time
    , id.icd9, id.doctor
    ,d.name, d.licenseno
    FROM iptoprt id 
    LEFT OUTER JOIN doctor d ON id.doctor=d.code
    where id.an='$q'
    limit 30 ";
    $q_icd9 = mysqli_query($con_hos, $s_icd9) or die(mysqli_error($con_hos));
    echo "<table class='table table-striped table-hover'>";
    echo "<tr>";
    echo "<th>icd9</th>";
    echo "<th>doctor</th>";
    echo "<th>name</th>";
    echo "<th>licenseno</th>";
    echo "<th>วัน/เวลา ทำหัตถการ</th>";
    echo "</tr>";

    while($r_icd9 = mysqli_fetch_array($q_icd9)){

    echo "<tr>";
    echo "<td>" . $r_icd9["icd9"] . "</td>";
    echo "<td>" . $r_icd9["doctor"].  "</td>";
    echo "<td>" . $r_icd9["name"] . "</td>";
    echo "<td>" . $r_icd9["licenseno"] . "</td>";
    echo "<td>" . $r_icd9["oprt_time"] . "</td>";
    echo "</tr>";

    }
}

echo "</table>";
echo "<div id='txtHin' style='margin-left:20px;'></div>"
?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>



