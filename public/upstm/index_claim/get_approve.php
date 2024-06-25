<?php
include('../connect/connect.php');
include('../session/session_claim.php');

echo $q=$_GET['q'];
$explod_q=explode("|",$q);
echo $explod_q[0].'<BR>';
echo $explod_q[1].'<BR>';
#$q="440000010";
#$sql = "SELECT rp.rcpno,bill_amount,bill_date_time,user,computer from rcpt_print rp WHERE rp.vn='$q' LIMIT 20";

#$result_concat_pttype = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));

echo '
<form class="mb-3 row">
    <div class="form-floating">
        <textarea class="form-control" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
        <label for="floatingTextarea2">Comments</label>
    </div>
</div>
<BR><BR>
<div class="col-auto">
    <button type="submit" class="btn btn-primary mb-3">ยืนยันการตรวจสอบ</button>
  </div>
</form>
';
echo "<div id='txtHin' style='margin-left:20px;'></div>"

?>

<script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>



