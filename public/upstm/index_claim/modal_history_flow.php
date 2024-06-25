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
    $s_pdp = "SELECT d.outdate,o.name AS staff_name,d.intime
            ,k1.department AS from_department,d.outtime
            ,k2.department AS to_department
            FROM ptdepart d  
            LEFT JOIN kskdepartment k1 ON k1.depcode = d.depcode 
            LEFT JOIN kskdepartment k2 ON k2.depcode = d.outdepcode  
            LEFT JOIN opduser o ON o.loginname = d.staff 
            WHERE d.vn = '$vn'  ORDER BY d.outdate,d.intime
            LIMIT 50 ";
}

$pattern_tel = '/-/i';

$q_pdp = mysqli_query($con_hos, $s_pdp) or die(mysqli_error($con_hos));
?>

<table class="table table-responsive table-striped table-hover" id="test_table" >
    <thead>
        <tr>
            <th><h4>NO</th>
            <th><h4>วันที่</th>
            <th><h4>เวลา</th>
            <th><h4>เจ้าหน้าที่</th>
            <th><h4>แผนกรับส่ง</th>
            <th><h4>ส่งไปแผนก</th>
        </tr>
    </thead>

    <tbody>
        <?php
        while($r_pdp = mysqli_fetch_array($q_pdp)){
        ?>
        <tr>
            <td><h5></td>
            <td><h5><?= DateThaisubmonth($r_pdp['outdate'])?></td>

            <td data-order='<?php echo $row_show["vstdate"].' '.$r_pdp['intime']?>'>
                <h5><?= $r_pdp['intime']?>
            </td>

            <td><h5><?= $r_pdp['staff_name']?></td>
            <td><h5><?= $r_pdp['from_department']?></td>
            <td><h5><?= $r_pdp['to_department']?></td>
        </tr>

        <?php
        }
        ?>
    </tbody>

</table>

modal_history_flow

<script type="text/javascript">
$(document).ready(function (){ 
     
 
    /** Responsive table with colreorder, fixed header;footer, sortable teble*/
    var table = $('#test_table').DataTable({
        //dom: '<"top"lipf<"clear">> rt <"bottom"ip<"clear">>',
        
         "pageLength": 10,
         "lengthMenu": [ 10, 100 ],
         "autoWidth": false
        // "scrollX": true,
        // fixedHeader: true,

        //"scrollX": "100%",
        //responsive: true

    })

    table.on('order.dt search.dt', function () {
        let i = 1;
 
        table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
            this.data(i++);
        });
    }).draw();
});
</script>
