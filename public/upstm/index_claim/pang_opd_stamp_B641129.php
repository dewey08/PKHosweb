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
@$pang=$_REQUEST["pang"];
echo @$backto=$_REQUEST["backto"];
echo "<BR>";
echo $_REQUEST["vn"];
#for($i=0;$i<count($_REQUEST["vn"]);$i++)
#{
  

  if(trim($_REQUEST["vn"][$i]) != "")
  {
    //$vn=$_POST["vn"][$i];

    #@$vn_con_uc_money=$_REQUEST['vn'][$i]; // รับค่า
    @$vn_con_uc_money=$_REQUEST['vn']; // รับค่า
    $vn=substr($vn_con_uc_money,0,12); // ตัดเอา VN 12 หลัก

    $uc_money_kortok=substr($vn_con_uc_money,12); // ตัดเอา uc_money
    $explode_uc_money_kortok = explode("|", $uc_money_kortok);
    
    $uc_money=$explode_uc_money_kortok[0]; // ตัดเอา uc_money
    
    $pang_stamp_uc_money_kor_tok=$explode_uc_money_kortok[1]; // เงินตามข้อตกลง
    
    //$vn=$_POST["vn"][$i];

    //"vn $i = ".$_POST["vn"][$i]."<br>";
    $sql_vn="SELECT  
              o.vn,o.hn,o.vstdate
              ,p.cid 
              ,o.pttype 
              ,cs.check_sit_subinscl, cs.check_sit_startdate
              ,GROUP_CONCAT(DISTINCT od.icd10 ORDER BY od.diagtype)icd
              ,ROUND(v.income,2)AS 'income',ROUND(v.paid_money,2) AS 'paid_money' ,ROUND(v.uc_money,2) AS 'uc_money'
              ,CONCAT(o.hn,DATE_FORMAT(o.vstdate, '%d%m%Y'),DATE_FORMAT(o.vsttime, '%H%i00'))match_hos
              FROM ovst o
              LEFT OUTER JOIN patient p ON o.hn=p.hn
              LEFT OUTER JOIN $database_ii.check_sit cs ON o.vn=cs.check_sit_vn AND '$date_now'=cs.check_sit_date
              LEFT OUTER JOIN ovstdiag od ON o.vn=od.vn
              LEFT OUTER JOIN vn_stat v ON o.vn=v.vn
              WHERE o.vn='$vn'
              GROUP BY o.vn
              LIMIT 10";
    $result_vn = mysqli_query($con_hos, $sql_vn) or die(mysqli_error($con_hos));
    $row_vn = mysqli_fetch_array($result_vn);

    
    $stamp_insert="INSERT INTO pang_stamp
                        (pang_stamp_vn      ,pang_stamp_vstdate         ,pang_stamp           ,pang_stamp_hn  
                        ,pang_stamp_nhso                      ,pang_stamp_nhso_startdate  
                        ,pang_stamp_income        ,pang_stamp_paid_money        ,pang_stamp_uc_money  ,pang_stamp_uc_money_kor_tok
                        ,pang_stamp_icd       ,match_hos                    ,pang_stamp_user_stamp)
                      VALUES 
                        ('$vn'              ,'".$row_vn["vstdate"]."'   ,'$pang'              ,'".$row_vn["hn"]."'
                        ,'".$row_vn["check_sit_subinscl"]."'  ,'".$row_vn["check_sit_startdate"]."'
                        ,'".$row_vn["income"]."'  ,'".$row_vn["paid_money"]."'  ,'".$uc_money."'      ,'".$pang_stamp_uc_money_kor_tok."'
                        ,'".$row_vn["icd"]."' ,'".$row_vn["match_hos"]."'   ,'".$pang_stamp_user_stamp."'
                        );
                          ";
    mysqli_query($con_money, $stamp_insert) or die(mysqli_error($con_money));
  }
#}
?>
<script>
          //Using setTimeout to execute a function after 5 seconds.
          setTimeout(function () {
             //Redirect with JavaScript
             //window.location.href= '<?php echo $backto?>';
          }, 0);
</script>

</body>
</html>