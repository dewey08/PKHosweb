<?php
@session_start();
@include("../session/session_claim.php");
include("../connect/connect.php");

function DateThai($strDate){
  $strYear = date("Y",strtotime($strDate))+543;
  $strMonth= date("n",strtotime($strDate));
  $strDay= date("j",strtotime($strDate));
  $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
  $strMonthThai=$strMonthCut[$strMonth];
  return "$strDay $strMonthThai $strYear";
}
?>

<!DOCTYPE html>
<html>

  <head>
  <!-- Custom Stylesheet -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script><!--modal-->
  </head>

  <body>

  <?php
            if(isset($_POST["sir_pang_stamp_send"]) ){
              $sir_pang_stamp_send = $_POST["sir_pang_stamp_send"];
              $where_sir_pang_stamp_send = " WHERE pss.pang_stamp_send LIKE '%$sir_pang_stamp_send%' ";  
            }else{
              $where_sir_pang_stamp_send = " WHERE pss.money_receive_date IS NULL AND pss.pang_stamp_send_year = '$y_s'  "; 
            }

            $y_s = $_SESSION["y_s"];
           
   
            @$sql_pang_sub=" SELECT pss.pang_stamp_send 
                        ,((pss.pang_stamp_send_year)+543) AS pang_stamp_send_year
                        , pss.pang_stamp_send_date , pss.pang_stamp_send_time 
                        ,(SELECT count(*) FROM pang_stamp WHERE pang_stamp_send=pss.pang_stamp_send AND pang_stamp_edit<>'')check_edit 
                        ,GROUP_CONCAT(DISTINCT d.name)AS doctor_send
                        ,GROUP_CONCAT(DISTINCT pss.pang_stamp_status_send)AS pang_stamp_status_send
                        FROM pang_stamp_send pss
                        LEFT OUTER JOIN $database.opduser o ON pss.pang_stamp_send_user=o.loginname
                        LEFT OUTER JOIN $database.doctor d ON o.doctorcode=d.code
                        $where_sir_pang_stamp_send
                        GROUP BY pss.pang_stamp_send 
                        ORDER BY pss.pang_stamp_send_date DESC 
                        LIMIT 1000";
            $result_pang_sub = mysqli_query($con_money, $sql_pang_sub);
            ?>
     



  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body"> 

          <h2>รายการที่ส่งลูกหนี้</h2>  

            <!-- Modal sql -->    
            <div class="col-auto">
                <button class="btn btn-primary" data-toggle="modal" data-target=".bd-example-modal-lg">SQL</button>
              </div>
              <div class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                  <div class="modal-content">
                    <div class="modal-header">
                      <h5 class="modal-title">Modal SQL</h5>
                      <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                      </button>
                    </div>
                    
                    <div class="modal-body"><?= "index_claim_send"?></div>
                    <div class="modal-body"><?php echo nl2br (tab2nbsp($sql_pang_sub));?></div>
                    
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                      <!--
                      <button type="button" class="btn btn-primary">Save changes</button>
                      -->
                    </div>
                  </div>
                </div>
              </div>
              <!-- Modal sql -->
          
          <div class="">

            
            <table id="example" class="table table-striped table-bordered zero-configuration"> 
              <thead>
                <tr>
                  <th>No</th>
                  <th class="text-nowrap"><div align="center">เลขรายงาน</div></th>
                  <th class="text-nowrap"><div align="center">ปีงบ</div></th>
                  <th class="text-nowrap"><div align="center">วันที่ เวลาส่งการเงิน</div></th>
                  <th class="text-nowrap"><div align="center">ส่งโดย</div></th>
                  <td>check_edit</td>
                </tr>
              </thead>

              <tbody>
                
              <?php
              while($row_show = mysqli_fetch_array($result_pang_sub)){
                $check_edit = $row_show['check_edit'];
                $pang_stamp_send = $row_show["pang_stamp_send"];
                $pang_stamp_status_send = $row_show["pang_stamp_status_send"];
              ?>
            
                <tr>

                  <td></td>
                  <td class="text-nowrap " align="left" data-search="<?php echo $pang_stamp_send;?>" >
                    <?php
                    echo '<a class="btn btn-success " target="_blank" href="../report/index_calim_send.php?pang_stamp_send='.$pang_stamp_send.'">'.$pang_stamp_send.'</a>&nbsp';

                    if($check_edit>0){
                    echo '<a class="btn btn-danger " href="index_other.php?sum=stamp&pang_stamp_send='.$pang_stamp_send.'">ปรับปรุง</a>';
                    }
                    ?>


                    <button type="button" name="view_old_report_s" class="btn btn-info view_old_report_s" id="<?= $pang_stamp_send;?>">
                      เอกสาร
                    </button>

                    <?php 
                    if($pang_stamp_status_send!=''){
                    ?>
                    <button type="button" name="view_after_send" class="btn btn-warning view_after_send" id="<?= $pang_stamp_send;?>">
                      ลูกหนี้ย้อนหลัง
                    </button>
                    <?php 
                    }
                    ?>
                  

                  </td>
              
                  <td class="text-nowrap " align="left" >
                    <?php echo $row_show["pang_stamp_send_year"]; ?>
                  </td>
                  <td class="text-nowrap " align="left" >
                    <?php echo DateThai($row_show["pang_stamp_send_date"])." ".$row_show["pang_stamp_send_time"]; ?>
                  </td>

                  <td class="text-nowrap " align="left" >
                    <?php echo $row_show["doctor_send"]; ?>
                  </td>  

                  <td class="text-nowrap " align="left" >
                    <?php echo $row_show["check_edit"]; ?>
                  </td>

                  
                
                

                </tr>
              <?php
              }
              ?>
              </tbody>  
            </table>

      
        
          </div>
        </div>
      </div>
    </div>
  </div>

    <!-- Modal_get_old_sum_report-->
<script>
    $(document).ready(function() {
        function fetch_post_data_lab(pang_stamp_send) {
            $.ajax({
                url: "../index_money/stamp_send_accept_no_modalform.php?c=claim",
                method: "POST",
                data: {
                    pang_stamp_send: pang_stamp_send
                },
                success: function(data) {
                    $('#post_modal_choose_car').modal('show');
                    $('#post_detail_choose_car').html(data);
                }
            });
        }
        $(document).on('click', '.view_old_report_s', function() {
            var pang_stamp_send = $(this).attr("id");
            fetch_post_data_lab(pang_stamp_send);
        });
    });
    </script>

    <div id="post_modal_choose_car" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">เอกสาร</h1>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_choose_car"></div>
                <div class="modal-foot">
                  <h4>stamp_send_accept_no_modalform</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_get_old_sum_report-->

    
    <!-- Modal_view_stamp_send_detail_detail-->
<script>
    $(document).ready(function() {

        function fetch_post_data_lab(file_name) {
            $.ajax({
                url: "../index_money/stamp_accept_send_detail.php",
                method: "POST",
                data: {
                    file_name: file_name
                },
                success: function(data) {
                    $('#post_modal_view_stamp_send_detail').modal('show');
                    $('#post_detail_view_stamp_send_detail').html(data);
                }
            });
        }

        $(document).on('click', '.view_stamp_send_detail', function() {
            var file_name = $(this).attr("id");
            fetch_post_data_lab(file_name);
        });

    });
    </script>

    <div id="post_modal_view_stamp_send_detail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">รายละเอียดใบเสร็จรับเงิน</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="post_detail_view_stamp_send_detail">
                </div>
                <div class="modal-foot">
                  <h4>stamp_accept_send_detail</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_view_stamp_send_detail_detail-->


    <!-- Modal_view_after_send-->
    <script>
    $(document).ready(function() {
        function fetch_post_data_lab(pang_stamp_send) {
            $.ajax({
                url: "../index_money/stamp_after_send_modal.php?c=claim",
                method: "POST",
                data: {
                    pang_stamp_send: pang_stamp_send
                },
                success: function(data) {
                    $('#post_view_after_send').modal('show');
                    $('#post_detail_view_after_send').html(data);
                }
            });
        }
        $(document).on('click', '.view_after_send', function() {
            var pang_stamp_send = $(this).attr("id");
            fetch_post_data_lab(pang_stamp_send);
        });
    });
    </script>

    <div id="post_view_after_send" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">รายการส่งลูกหนี้ย้อนหลัง</h1>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_view_after_send"></div>
                <div class="modal-foot">
                  <h4>stamp_after_send_modal</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_view_after_send-->


    <!-- Modal_after_send_detail-->
    <script>
    $(document).ready(function() {
        function fetch_post_data_lab(pang_stamp_send) {
            $.ajax({
                url: "../index_money/stamp_after_send_detail_modal.php?c=claim",
                method: "POST",
                data: {
                    pang_stamp_send: pang_stamp_send
                },
                success: function(data) {
                    $('#post_after_send_detail').modal('show');
                    $('#post_detail_after_send_detail').html(data);
                }
            });
        }
        $(document).on('click', '.after_send_detail', function() {
            var pang_stamp_send = $(this).attr("id");
            fetch_post_data_lab(pang_stamp_send);
        });
    });
    </script>

    <div id="post_after_send_detail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">รายการส่งลูกหนี้ย้อนหลัง รายผัง</h1>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_after_send_detail"></div>
                <div class="modal-foot">
                  <h4>stamp_after_send_detail_modal</h4>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_after_send_detail-->

    <script type="text/javascript">

    $(document).ready( function () {
      var t = $('#example').DataTable({
        "autoWidth": false,
        "scrollX": true,
        "pageLength": 100,
        order: [5,1, 'desc'],
        "lengthMenu": [ 10, 100, 500 ],
        columnDefs: [
          {
            target: 5,
            visible: false,
            searchable: false,
          },
          {
            target: 2,
            visible: false,
            searchable: false,
          },
        ],
      });
     
      t.on('order.dt search.dt', function () {
        let i = 1;
        t.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
          this.data(i++);
        });
      }).draw();
    } );
    </script>

  </body>

</html>






    


