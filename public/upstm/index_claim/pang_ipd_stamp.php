<?php

include("../connect/connect.php");
set_time_limit(0);
// some code

@session_start();
$pang_stamp_user_stamp = $_SESSION["UserID"];

?>
<html>
<head>
<title>ThaiCreate.Com Tutorial</title>
</head>
<body>
<?php
@$date_now=date("Y-m-d");
@$pang=$_POST["pang"];
@$backto=$_POST["backto"];
for($i=0;$i<count($_POST["an"]);$i++)
{
  

  if(trim($_POST["an"][$i]) != "")
  {
    //$vn=$_POST["vn"][$i];

    @$vn_con_uc_money=$_POST['an'][$i]; // รับค่า
    $an=substr($vn_con_uc_money,0,9); // ตัดเอา VN 12 หลัก

    $uc_money_kortok=substr($vn_con_uc_money,9); // ตัดเอา uc_money
    $explode_uc_money_kortok = explode("|", $uc_money_kortok);
    
    $uc_money=$explode_uc_money_kortok[0]; // ตัดเอา uc_money
    
    
    //$vn=$_POST["vn"][$i];

    //"vn $i = ".$_POST["vn"][$i]."<br>";
    $sql_vn="SELECT  
              o.an,o.hn,o.dchdate,o.regdate
              ,p.cid 
              ,o.pttype 
              ,cs.check_sit_subinscl, cs.check_sit_startdate
              ,GROUP_CONCAT(DISTINCT od.icd10 ORDER BY od.diagtype)icd
              ,ROUND(v.income,2)AS 'income',ROUND(v.paid_money,2) AS 'paid_money' ,ROUND(v.uc_money,2) AS 'uc_money'
              ,CONCAT(o.hn,DATE_FORMAT(o.regdate, '%d%m%Y'),DATE_FORMAT(o.regtime, '%H%i00'))match_hos
              FROM ipt o
              LEFT OUTER JOIN patient p ON o.hn=p.hn
              LEFT OUTER JOIN $database_ii.check_sit cs ON o.an=cs.check_sit_vn AND '$date_now'=cs.check_sit_date
              LEFT OUTER JOIN iptdiag od ON o.an=od.an
              LEFT OUTER JOIN an_stat v ON o.an=v.an
              WHERE o.an='$an'
              GROUP BY o.an
              LIMIT 10";
    $result_vn = mysqli_query($con_hos, $sql_vn) or die(mysqli_error($con_hos));
    $row_vn = mysqli_fetch_array($result_vn);

    
    $stamp_insert="INSERT INTO pang_stamp
                        (pang_stamp_an      ,pang_stamp_dchdate       ,pang_stamp_vstdate         ,pang_stamp           ,pang_stamp_hn  
                        ,pang_stamp_nhso                      ,pang_stamp_nhso_startdate  
                        ,pang_stamp_income        ,pang_stamp_paid_money        ,pang_stamp_uc_money  
                        ,pang_stamp_icd       ,pang_stamp_user_stamp        ,match_hos)
                      VALUES 
                        ('$an'              ,'".$row_vn["dchdate"]."' ,'".$row_vn["dchdate"]."'   ,'$pang'              ,'".$row_vn["hn"]."'
                        ,'".$row_vn["check_sit_subinscl"]."'  ,'".$row_vn["check_sit_startdate"]."'
                        ,'".$row_vn["income"]."'  ,'".$row_vn["paid_money"]."'  ,'".$uc_money."'      
                        ,'".$row_vn["icd"]."' ,'".$pang_stamp_user_stamp."' ,'".$row_vn["match_hos"]."'
                        );
                          ";
    mysqli_query($con_money, $stamp_insert) or die(mysqli_error($con_money));
  }
}
?>
<script>
          //Using setTimeout to execute a function after 5 seconds.
          setTimeout(function () {
             //Redirect with JavaScript
             window.location.href= '<?php echo $backto?>';
          }, 0);
</script>

</body>
</html>