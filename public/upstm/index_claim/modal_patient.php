<style type="text/css">
    .modal_patient{
        /*font: normal normal normal 20px/1 Helvetica, arial, sans-serif;*/
        /*border-bottom: 2px solid #000;
        background:#000;
        color:#fff;
          
        display:inline-block;
        padding:3px 15px;
        margin-left:10px;*/
    }
</style>
<?php
include('../connect/connect.php');
include('../session/session.php');

function DateThaisubmonth($strDate){
   $strYear = date("Y",strtotime($strDate))+543;
   $strMonth= date("n",strtotime($strDate));
   $strDay= date("j",strtotime($strDate));
   $strMonthCut = Array("","มค","กพ","มีค","มย","พค","มิย","กค","สค","กย","ตค","พย","ธค");
   $strMonthThai=$strMonthCut[$strMonth];
   return "$strDay $strMonthThai $strYear";
}

$vn=$_REQUEST['vn'];
$count_q = strlen($vn);
if($count_q==12){
    $sql = "SELECT o.vn,o.hn, v.cid, o.vstdate
    #,CONCAT(p.pname,CONCAT(SUBSTR(p.fname,1,4),'xxx'),' ',CONCAT(SUBSTR(p.lname,1,4)),'xxx') AS pt_sub_name
    ,CONCAT(p.pname,p.fname,' ',p.lname) AS pt_sub_name
    ,v.age_y, v.age_m, v.age_d 
    ,CONCAT( IFNULL(p.hometel,''),', ', IFNULL(p.informtel,'') ) AS tel
    ,os.cc, os.pe, os.hpi, os.pmh, os.fh, os.sh
    ,(  SELECT GROUP_CONCAT(diag_text SEPARATOR ', ') FROM (
            select diag_text FROM ovst WHERE vn='$vn'
            union 
            select diag_text FROM ovst_doctor_diag WHERE vn='$vn'
        ) a
    ) AS diag_text 
    ,(
        SELECT GROUP_CONCAT(t.name ORDER BY t.position_id ASC) AS group_doctor_name 
        FROM
        (
            SELECT d.name, d.position_id FROM doctor d , 
            (SELECT doctor_code AS doctor FROM ovst_doctor_diag WHERE vn = '$vn' LIMIT 10) AS c, 
            (SELECT doctor FROM ovstdiag WHERE vn = '$vn' LIMIT 10) AS b, 
            (SELECT doctor FROM pq_doctor WHERE vn = '$vn'   LIMIT 10) AS a 
            WHERE (d.code=a.doctor OR d.code=b.doctor OR d.code=c.doctor) AND d.position_id IN (1,2,5,9,58,9999)  
            GROUP BY d.code
        ) AS t
    ) AS group_doctor_name
    ,(SELECT an FROM ovst where vn=o.vn) AS an
    FROM ovst o
    LEFT JOIN patient p ON o.hn=p.hn
    LEFT JOIN vn_stat v ON v.vn=o.vn
    LEFT JOIN opdscreen os ON o.vn=os.vn
    WHERE o.vn='$vn'
    LIMIT 1 ";
}

$pattern_tel = '/-/i';

$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));

$row_concat_pttype = mysqli_fetch_array($result_concat_pttype);
$hn = $row_concat_pttype["hn"];
$an = $row_concat_pttype["an"];
$vstdate = $row_concat_pttype["vstdate"];
$pt_sub_name = $row_concat_pttype["pt_sub_name"];
$cc = $row_concat_pttype["cc"];
$hpi = $row_concat_pttype["hpi"];
$pmh = $row_concat_pttype["pmh"];
$fh = $row_concat_pttype["fh"];
$sh = $row_concat_pttype["sh"];
$pe = $row_concat_pttype["pe"];
$diag_text = $row_concat_pttype["diag_text"];
$group_doctor_name = $row_concat_pttype["group_doctor_name"];
$tel = preg_replace($pattern_tel, '', $row_concat_pttype["tel"]); #ตัดขีดออก มีขีดแล้วก๊อปปี้ยาก
$age_y = $row_concat_pttype["age_y"];$age_m = $row_concat_pttype["age_m"];$age_d = $row_concat_pttype["age_d"];
$cid = $row_concat_pttype["cid"];
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card bg-success">
            <div class="card-body">  
                <?php
                echo "<h1>VN : $vn, HN : $hn</h1><BR>";
                echo "<h1>CID : $cid</h1><BR>";
                if($an!=''){
                    echo "<h1>AN : $an<BR>";
                    $s_an = "SELECT dchdate,regdate FROM an_stat WHERE an='$an' LIMIT 1 ";
                    $q_an = mysqli_query($con_hos, $s_an);
                    $r_an = mysqli_fetch_array($q_an);
                    echo "<h2>รับ : ".DateThaisubmonth($r_an['regdate'])." - จำหน่าย ".DateThaisubmonth($r_an['dchdate'])."<BR>";
                }    
                echo "<h2 class='modal_patient'>วันที่รับบริการ : ".DateThaisubmonth($vstdate)."</h2>"."<BR>";
                echo "<h2>ชื่อ : $pt_sub_name, อายุ : $age_y ปี $age_m เดือน $age_d วัน </h2>"."<BR>";
                echo "<h2>เบอร์ : $tel</h2>"."<BR>";
                ?>
            </div>
        </div>

        <div class="card bg-light">
            <div class="card-body">  
                <?php
                echo "<h2>CC : $cc</h2>"."<BR>";
                echo "<h2>HPI : $hpi</h2>"."<BR>";
                echo "<h2>PMH : $pmh</h2>"."<BR>";
                echo "<h2>FH : $fh</h2>"."<BR>";
                echo "<h2>SH : $sh</h2>"."<BR>";
                echo "<h2>PE : $pe</h2>"."<BR>";
                ?>
            </div>
        </div>

        <div class="card bg-success">
            <div class="card-body">  
                <?php
                echo "<h2>วินิจฉัย : $diag_text</h2>"."<BR>";
                echo "<h2>ผู้ตรวจ : $group_doctor_name</h2>"."<BR>";
                ?>
            </div>
        </div>

    </div>        
</div>

modal_patient

