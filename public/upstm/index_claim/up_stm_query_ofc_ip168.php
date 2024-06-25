<?php
@include("../session/session_claim.php"); // session_login
include("../connect/connect.php");
$stm_user_reccord=$_SESSION["UserID_BN"];
// xml file path
#$target_file = "10978_BOCDSTM_20210402.xml";

//$target_file = "10978_BIGNSTM_202104.xml";

$target_file = $_GET["target_file"];
$file_name = $_GET["file_name"];
#$inputFileName = "myData.xls";
$backto=$_GET["backto"];
// Read entire file into string
#$xmlfile = file_get_contents($path);

// Convert xml string into an object
#$new = simplexml_load_string($xmlfile);

// Convert into json
#$con = json_encode($new);

// Convert into associative array
#$newArr = json_decode($con, true);

$xml = new SimpleXMLElement($target_file,0,TRUE);
#print_r($newArr);
#print_r( array_values( $newArr ));
#echo $newArr[0];

#print '<pre>';
#print_r($newArr);die;
#var_dump($xml);
#print '</pre>';



$i = 0;
$fail_up=0;
$fail_count=array();
$success_up=0;

foreach($xml->thismonip as $tesss){
  	$match_stm = $tesss->an;
  	$adjrw = $tesss->adjrw; # vstdate
  	$stm_claim = $tesss->gtotal; # stm_claim
  	$stm_rep = $tesss->rid; # stm_rep

	$i++;
		
	$check_rep = "SELECT match_stm FROM stm WHERE match_stm='".$match_stm."' AND stm_claim ='$stm_claim' LIMIT 1";
	$check_rep_r = mysqli_query($con_money, $check_rep) or die(mysqli_error());
	$check_rep_r_s = mysqli_fetch_array($check_rep_r);
	@$check_rep_r_s_f = $check_rep_r_s["match_stm"];
	if( isset($check_rep_r_s_f) ){
		$fail_up++; //นับจำนวนที่อัพไม่สำเร็จ
		$fail_count[$i]="Row $i ".$hn." ".$vstdate." <font style='background-color: red'>นำเข้าแล้ว </font> <br>";
		//echo "Row $i ".$result["C"]." ".$result["G"]." นำเข้าแล้ว <br>";
	}else{

		$strSQL = "
			INSERT INTO stm 
			(match_stm, stm_rep, stm_claim, stm_file_name, stm_user_reccord
			,stm_type) 
			VALUES ('".$match_stm."','".$stm_rep."','".$stm_claim."','".$file_name."','".$stm_user_reccord."'
			,'stm_ofc_ip16') ";
		mysqli_query($con_money, $strSQL) or die(mysqli_error($con_money));
		//mysql_query($strSQL) or die(mysql_error());
		$success_up++; //นับจำนวนที่ up สำเร็จ
		//echo "Row $i Inserted...<br>";
	}
} // loop foreach
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
