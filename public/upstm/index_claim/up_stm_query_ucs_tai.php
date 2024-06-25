<?php
@include("../session/session_claim.php"); // session_login
include("../connect/connect.php");
$stm_user_reccord=$_SESSION["UserID_BN"];

/** PHPExcel */
require_once '../upstm/Classes/PHPExcel.php';

/** PHPExcel_IOFactory - Reader */
include '../upstm/Classes/PHPExcel/IOFactory.php';

$target_file = $_GET["target_file"];
$file_name = $_GET["file_name"];
#$inputFileName = "myData.xls";
$backto=$_GET["backto"];
//$inputFileName = $_FILES["fileToUpload"]["tmp_name"]; 
//$target_file = basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

	@$inputFileType = PHPExcel_IOFactory::identify($target_file);  
	@$objReader = PHPExcel_IOFactory::createReader($inputFileType);  
	@$objReader->setReadDataOnly(true);  
	@$objPHPExcel = $objReader->load($target_file);  

	@$objWorksheet = $objPHPExcel->setActiveSheetIndex(2);
	@$highestRow = $objWorksheet->getHighestRow();
	@$highestColumn = $objWorksheet->getHighestColumn();

	@$headingsArray = $objWorksheet->rangeToArray('A1:'.$highestColumn.'1',null, true, true, true);
	@$headingsArray = $headingsArray[1];

	

	$r = -1;
	$namedDataArray = array();
	for ($row = 2; $row <= $highestRow; ++$row) {
	    $dataRow = $objWorksheet->rangeToArray('A'.$row.':'.$highestColumn.$row,null, true, true, true);
	    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '') && (is_numeric($dataRow[$row]['A'])) && (empty($dataRow[$row]['AA'])) ) { //ตรวจคอลัมน์ Excel
	        ++$r;
	        foreach($headingsArray as $columnKey => $columnHeading) {
	            //$namedDataArray[$r][$columnHeading] = $dataRow[$row][$columnKey];
	            foreach (range('A', 'Z') as $column){
			        $namedDataArray[$r][$column] = $dataRow[$row][$column];
			    }  
	        }
	    }elseif( isset($dataRow[$row]['AA']) ){
	    	$show_error = "<font style='background-color: red'>ไม่ใช่ STM ข้าราชการ</font>";
	    }
	}

	


	$i = 0;
	$fail_up=0;
	$fail_count=array();
	$success_up=0;

	foreach ($namedDataArray as $result) {
		$i++;
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		if($result["D"]==""){
			$s_get_hn = "SELECT hn FROM patient WHERE cid= '".$result["F"]."' ";
			$q_get_hn = mysqli_query($con_hos, $s_get_hn) or die(mysqli_error());
			$r_get_hn = mysqli_fetch_array($q_get_hn);
			$get_hn = $r_get_hn["hn"];

			$match_stm=$get_hn.(str_replace(" ","",str_replace("/","",str_replace(":","",$result["K"]))));	
			$hn=$get_hn;

		}else{
			$match_stm=$result["D"].(str_replace(" ","",str_replace("/","",str_replace(":","",$result["K"]))));	
			$hn=$result["D"];
		}

		$stm_claim_check = $result["T"];
		//สำหรับเช็ค ว่าอัพโหลดหรือยัง และ สำหรับจับกับ Visit
		
		$check_rep = "SELECT match_stm FROM stm WHERE match_stm='".$match_stm."' AND stm_claim ='$stm_claim_check' LIMIT 1";
		$check_rep_r = mysqli_query($con_money, $check_rep) or die(mysqli_error());
		$check_rep_r_s = mysqli_fetch_array($check_rep_r);
		@$check_rep_r_s_f = $check_rep_r_s["match_stm"];
		if( isset($check_rep_r_s_f) ){
			$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
			$fail_count[$i]="Row $i ".$result["C"]." ".$result["G"]." <font style='background-color: red'>นำเข้าแล้ว </font> <br>";
			//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
		}else{
			
			#echo $result["B"];
			$strSQL = "INSERT INTO stm
			(match_stm			,stm_claim				,stm_file_name		,stm_user_reccord			,stm_hn
			,stm_rep
			,stm_type
			) 
			VALUES 
			('".$match_stm."'	,'".$result["T"]."'		,'".$file_name."'	,'".$stm_user_reccord."' 	,'".$hn."'
			,'".$result["B"]."'
			,'stm_ucs_tai'
			) ";
			mysqli_query($con_money, $strSQL) or die(mysqli_error($con_money));
			//mysql_query($strSQL) or die(mysql_error());
			$success_up++; //นับจำนวนที่ up สำเร็จ
			//echo "Row $i Inserted...<br>";

			
		}
	}
include('up_stm_check_query.php'); #ปรับยอดชดเชย ใน pang_stamp
?>

<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/docs/4.0/assets/img/favicons/favicon.ico">

    <title>Signin Template for Bootstrap</title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sign-in/">

    <!-- Bootstrap core CSS -->
    <link href="js/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.css">

    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.js">
    </script>

</head>

<body class="text-center">

    <div class="col-12">
        <a class="btn btn-lg btn-primary btn-block" href="<?php echo $backto;?>">Continue</a>

        <Br></Br>
        <h3><?= @$show_error; ?></h3>
        <h3><?= "จำนวนทั้งหมด ".$i; ?></h3>
        <h3><?= "นำเข้าได้จำนวน ".$success_up.' visit'; ?></h3>
        <h3><?= "นำเข้าไม่ได้จำนวน ".$fail_up.' visit'; ?></h3>
        <h3><?= "นำเข้าไม่ได้จำนวน ".$fail_up.' visit'; ?></h3>
    </div>

    <div class="col-12">

        <table id="example" class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>นำเข้าไม่สำเร็จ</th>
                </tr>
            </thead>

            <tbody>
                <?php 
					foreach($fail_count as $key) {
					?>
                <tr>
                    <td><?php echo $key;?></td>
                </tr>
                <?php
					}
					?>
            </tbody>
            <table>
    </div>


    </table>
    <script>
    $(document).ready(function() {
        $("#example").DataTable();

        table.on('order.dt search.dt', function() {
            let i = 1;

            table.cells(null, 0, {
                search: 'applied',
                order: 'applied'
            }).every(function(cell) {
                this.data(i++);
            });
        }).draw();
    });
    </script>



</body>

</html>