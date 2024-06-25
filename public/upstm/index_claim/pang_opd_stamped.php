<?php

include("../connect/connect.php");

set_time_limit(0);

@session_start();

#เงื่อนไขผัง
if(isset($_GET["pang"])){
    $pang = $_SESSION["pang"] = $_GET["pang"];
}else{
    $pang = $_SESSION["pang"];
}

$sql_pang_preview=" SELECT p.pang_id, p.pang_fullname, p.pang_instument, p.pang_stm, p.pang_kor_tok, p.pang_kor_tok_icd
                  , p.pang_cancer, p.pang_type
                  FROM pang p LEFT OUTER JOIN pang_sub ps ON p.pang_id=ps.pang_id
                  WHERE p.pang_id='$pang' AND p.pang_year='$y_s'
                  LIMIT 100";
$result_pang_preview = mysqli_query($con_money, $sql_pang_preview) or die(mysqli_error($con_money));
$row_pang_preview = mysqli_fetch_array($result_pang_preview);
$pang_type = $row_pang_preview["pang_type"];##ตรวจว่าเป็นคนไข้ในหรือคนไข้นอก

##ตรวจการตัดชดเชย
$pang_stm = $row_pang_preview["pang_stm"];
##ตรวจการตัดชดเชย

#สำหรับแสดงปุ่ม SQL ตัวประมวลผลอยู่ที่ pang_opd_stamped_ajax.php
if($pang_type=='OPD'){
  $s_date = "ps.pang_stamp_vstdate";
}elseif($pang_type=='IPD'){
  $s_date = "ps.pang_stamp_dchdate";
}else{
}
$sqlshow = "SELECT IF(ps.pang_stamp_vn IS NULL,'','Y')AS Stamp
            ,ps.pang_stamp_vn AS 'vn'
            ,ps.pang_stamp_hn AS 'hn'
            ,ps.pang_stamp_vstdate
            ,ps.pang_stamp_nhso
            ,ps.pang_stamp_uc_money  ,ps.pang_stamp_uc_money_kor_tok
            ,ps.pang_stamp_stm_money AS stm
            ,ps.pang_stamp_uc_money_minut_stm_money
            ,ps.pang_stamp_send
            ,ps.pang_stamp_id
            ,ps.pang_stamp
            ,ps.pang_stamp_stm_file_name ,ps.pang_stamp_stm_rep
            ,ps.pang_stamp_edit_send_id
            
            ,CONCAT(ps.pang_stamp_pname,ps.pang_stamp_fname,' ',ps.pang_stamp_lname) AS pt_sub_name
            FROM $database_ii.pang_stamp ps
            WHERE ps.pang_stamp = '$pang'
            AND $s_date BETWEEN '$start_year' AND '$end_year'
            AND ps.pang_stamp_uc_money <>0
            ORDER BY ps.pang_stamp_hn
            LIMIT 50000 ";
            #,CONCAT(ps.pang_stamp_pname,CONCAT(SUBSTR(ps.pang_stamp_fname,1,4),'xxx'),' ',CONCAT(SUBSTR(ps.pang_stamp_lname,1,4)),'xxx') AS pt_sub_name
#สำหรับแสดงปุ่ม SQL ตัวประมวลผลอยู่ที่ pang_opd_stamped_ajax.php
?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <!-- Custom Stylesheet -->
    <link href="../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/input_datatable.css"/><!-- css สำหรับเปลี่ยน search ให้เห็นกรอบ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script><!--modal-->

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
		<script type="text/javascript" language="javascript" src="https://code.jquery.com/jquery-3.5.1.js"></script>
		<script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>


		<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
		</script>

  </head>
      




  <body>

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">  
            <h2>รายการที่ทำการ Stamp แล้ว</h2>  
              <div class="table-responsive">

                  <!-- Modal sql -->    
                  <div class="col-md-1 col-lg-1">
                    <button type="button" name="view_sql" class="btn btn-primary view_sql" >
                      SQL
                    </button>
                  </div>
                  <!-- Modal sql -->
              <?php 
              if($pang_stm=='doc'){
              ?>
              <form method="post" action="pang_opd_stamped_doc_form_insert.php" enctype="multipart/form-data">
                  <div class="form-row align-items-center">
                    <div class="col-auto">
                      <label class="sr-only">เลขที่เอกสารเบิก</label>
                      <div class="input-group mb-2">
                        <div class="input-group-prepend">
                          <div class="input-group-text">ลงเอกสารตาม Checkbox ที่เลือก</div>
                        </div>
                        <input type="text" class="form-control" name="pang_stamp_stm_file_name" placeholder="ลงเลขที่หนังสือใหม่" maxlength="40" required="yes" 
                        autocomplete="off" >
                      </div>
                    </div>

                    <div class="form-group">
                      <input type="file" name="file" class="form-control-file" required="yes" >
                    </div>

                    <div class="col-auto">
                      <button type="submit" class="btn btn-dark mb-2">บันทึก</button>
                    </div>
                  </div>
              <?php 
              }
              ?>
                <table id="example" class="flex-fill flex-grow-1 table table-striped table-hover table-bordered"   >  
                  <thead>
                    <tr>

                      <th><input  name="select_all" value="1" type="checkbox" autocomplete="off"></th>

                      <th class=""><div align="center">No</div></th>
                      <th class=""><div align="center">Stamp(แก้ไข)</div></th>

                      <?php 
                      if($pang_stm=='doc'){
                      ?>
                      <th class=""><div align="center">เอกสาร</div></th>
                      <?php 
                      }
                      ?>

                      <th class=""><div align="center">บันทึกแก้</div></th>
                      <th class=""><div align="center">HN(การรักษา)</div></th>
                      <th class=""><div align="center">ชื่อ</div></th>
                      <th class=""><div align="center">วันที่รับบริการ</div></th>
                      <th class=""><div align="center">ค่าลูกหนี้</div></th>
                      <th class=""><div align="center">ชดเชย</div></th>
                      <th class=""><div align="center">ส่วนต่ำ</div></th>
                      <th class=""><div align="center">ส่วนสูง</div></th>
                      <th class=""><div align="center">STM</div></th>
                      <th class=""><div align="center">เลขที่ส่งหนังสือ</div></th>

                    </tr>
                  </thead>                  
                </table>
              </form>

    
            </div>

          </div>
        </div>
      </div>
    </div>



    <!-- Modal_patient-->
    <script>
      $(document).ready(function(){
             
        function fetch_post_data_lab(vn)
        {
          $.ajax({
            url:"modal_patient.php",
            method:"POST",
            data:{vn:vn},
            success:function(data)
            {
              $('#post_modal_patient').modal('show');
              $('#post_detail_patient').html(data);
            }
          });
        }

        $(document).on('click', '.view_patient', function(){
          var vn = $(this).attr("id");
          fetch_post_data_lab(vn);
        });
             
      });
    </script>

    <div id="post_modal_patient" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content"> 
          <div class="modal-header">
            <h1 class="modal-title">การรักษา modal_patient</h1>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body" id="post_detail_patient"></div>
        </div>
      </div>
    </div>
    <!-- Modal_patient-->


    <!-- Modalstamp-->
    <script>
            $(document).ready(function(){
             
             function fetch_post_data_lab(vnpang)
             {
              $.ajax({
               url:"pang_opd_stamped_edit_stamp.php",
               method:"POST",
               data:{vnpang:vnpang},
               success:function(data)
               {
                $('#post_modal_claim_code').modal('show');
                $('#post_detail_claim_code').html(data);
               }
              });
             }

             $(document).on('click', '.view_edit_stamp', function(){
              var vnpang = $(this).attr("id");
              fetch_post_data_lab(vnpang);
             });
             
            });
    </script>

    <div id="post_modal_claim_code" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                  <h1 class="modal-title">แก้ไขรายการ Stamp </h1>
                  
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_claim_code">
                </div><h4>pang_opd_stamped_edit_stamp</h4>
            </div>
            
        </div>
    </div>
    <!-- Modalstamp-->

    <!-- Modal_pang_opd_stamped_doc_form-->
    <script>
            $(document).ready(function(){
             
             function fetch_post_data_lab(pang_stamp_id)
             {
              $.ajax({
               url:"pang_opd_stamped_doc_form.php",
               method:"POST",
               data:{pang_stamp_id:pang_stamp_id},
               success:function(data)
               {
                $('#post_modal_doc_form').modal('show');
                $('#post_detail_doc_form').html(data);
               }
              });
             }

             $(document).on('click', '.view_insert_stm_doc', function(){
              var pang_stamp_id = $(this).attr("id");
              fetch_post_data_lab(pang_stamp_id);
             });
             
            });
    </script>

    <div id="post_modal_doc_form" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                  <h1 class="modal-title">ลงเอกสารเบิก pang_opd_stamped_doc_form</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_doc_form">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_pang_opd_stamped_doc_form-->

    <!-- Modal_doc_stm-->
    <script>
            $(document).ready(function(){
             
             function fetch_post_data_lab(pang_stamp_stm_file_name)
             {
              $.ajax({
               url:"pang_opd_stamped_doc_pic.php",
               method:"POST",
               data:{pang_stamp_stm_file_name:pang_stamp_stm_file_name},
               success:function(data)
               {
                $('#post_modal_doc_pic').modal('show');
                $('#post_detail_doc_pic').html(data);
               }
              });
             }

             $(document).on('click', '.view_doc', function(){
              var pang_stamp_stm_file_name = $(this).attr("id");
              fetch_post_data_lab(pang_stamp_stm_file_name);
             });
             
            });
    </script>

    <div id="post_modal_doc_pic" class="modal fade" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h4 class="modal-title">เอกสารเบิก pang_opd_stamped_doc_pic</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="post_detail_doc_pic">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_doc_stm-->



    <script type="text/javascript">
    $(document).ready(function (){
         
      /** Handling checboxes selection*/
         
      function updateDataTableSelectAllCtrl(table){
        var $table             = table.table().node();
        var $chkbox_all        = $('tbody input[type="checkbox"]', $table);
        var $chkbox_checked    = $('tbody input[type="checkbox"]:checked', $table);
        var chkbox_select_all  = $('thead input[name="select_all"]', $table).get(0);

        // If none of the checkboxes are checked
        if($chkbox_checked.length === 0){
            chkbox_select_all.checked = false;
            
          if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = false;
          }

        // If all of the checkboxes are checked
        }else if($chkbox_checked.length === $chkbox_all.length){
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
             chkbox_select_all.indeterminate = false;
          }

        // If some of the checkboxes are checked
        }else{
          chkbox_select_all.checked = true;
          if('indeterminate' in chkbox_select_all){
            chkbox_select_all.indeterminate = true;
          }
        }
      }
     
    /** Responsive table with colreorder, fixed header;footer, sortable teble*/
    <?php 
    if($pang_stm=='doc'){
      $value_order_vstdate= '7';#ลำดับที่ 7 คือ vstdate
    }else{
      $value_order_vstdate= '6';#ลำดับที่ 6 คือ vstdate
    }
    ?>
    var table =  $('#example').DataTable({
            scrollY: '60vh',
            scrollCollapse: true,
            scrollX: true,
            "autoWidth": false,
            "pageLength": 300,
            "lengthMenu": [ 10, 100, 300 ],
            dom: '<"top"lipf<"clear">> rt <"bottom"ip<"clear">>',
			        processing: true,
			        serverSide: true,
			        ajax: {
                url:'pang_opd_stamped_ajax.php',
                type: 'POST',
                "data" : {
                  "pang" : "<?= $pang;?>",
                  "start_year" : "<?= $start_year;?>",
                  "end_year" : "<?= $end_year;?>",
                  "pang_type" : "<?= $pang_type;?>",
                  "m_s" : "<?= $m_s;?>",
                  "y_s" : "<?= $y_s;?>",
                  "backto" : "<?= $backto;?>"
                }
              },
              responsive: {
                details: {
                  type: 'column'
                }
              },
              order:[ [ 3, 'asc' ] ,[<?= $value_order_vstdate?>, 'asc'] ],

            columnDefs: [
              { targets: 7,
                className: 'dt-body-right'
              },{ targets: 8,
                className: 'dt-body-right'
              },{ targets: 9,
                className: 'dt-body-right'
              },{ targets: 10,
                className: 'dt-body-right'
              }
            ],

      'rowCallback': function(row, data, dataIndex){
        // Get row ID
        var rowId = data[6];

        // If row ID is in the list of selected row IDs
        if($.inArray(rowId, /**rows_selected */) !== -1){
          $(row).find('input[type="checkbox"]').prop('checked', true);
          $(row).addClass('selected');
        }
      }

    });

    table.columns.adjust().draw();
       
    /** mark single checkboxes */

    table.on('order.dt search.dt', function () {
      let i = 1;
     
      table.cells(null, 1, { search: 'applied', order: 'applied' }).every(function (cell) {
        this.data(i++);
      });

    }).draw();

       
    $(document).ready(function (){
       // Array holding selected row IDs
       var rows_selected = [];
     

       // Handle click on checkbox
       $('#example tbody').on('click', 'input[type="checkbox"]', function(e){
          var $row = $(this).closest('tr');

          // Get row data
          var data = table.row($row).data();

          // Get row ID
          var rowId = data[6];

          // Determine whether row ID is in the list of selected row IDs
          var index = $.inArray(rowId, rows_selected);

          // If checkbox is checked and row ID is not in list of selected row IDs
          if(this.checked && index === -1){
             rows_selected.push(rowId);

          // Otherwise, if checkbox is not checked and row ID is in list of selected row IDs
          } else if (!this.checked && index !== -1){
             rows_selected.splice(index, 1);
          }

          if(this.checked){
            $row.addClass('selected');
          } else {
            $row.removeClass('selected');
          }

          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);

          // Prevent click event from propagating to parent
          e.stopPropagation();
       });

       // Handle click on table cells with checkboxes
      $('#example').on('click', 'tbody td, thead th:first-child', function(e){
        //$(this).parent().find('input[type="checkbox"]').trigger('click'); //88ลิ๊ก ที่ td cละ้ว checkbox
      });

       // Handle click on "Select all" control
       $('thead input[name="select_all"]', table.table().container()).on('click', function(e){
          if(this.checked){
             $('#example tbody input[type="checkbox"]:not(:checked)').trigger('click');
          } else {
             $('#example tbody input[type="checkbox"]:checked').trigger('click');
          }

          // Prevent click event from propagating to parent
          e.stopPropagation();
       });

       // Handle table draw event
       table.on('draw', function(){
          // Update state of "Select all" control
          updateDataTableSelectAllCtrl(table);
       });

       // Handle form submission event

       

    });
       
       
       
        /** Handling responsive expand collapse all*/
       
        // Handle click on "Expand All" button
        $('#btn-show-all-children').on('click', function(){
            // Expand row details
            table.rows(':not(.parent)').nodes().to$().find('td:first-child').trigger('click');
        });

        // Handle click on "Collapse All" button
        $('#btn-hide-all-children').on('click', function(){
            // Collapse row details
            table.rows('.parent').nodes().to$().find('td:first-child').trigger('click');
        });
    });
    </script>


    <!-- Modal_SQL-->
    <script>
            $(document).ready(function(){
            
            function fetch_post_data_lab(testt)
            {
              $.ajax({
              success:function(data)
              {
                $('#post_modal_sql').modal('show');
              }
              });
            }

            $(document).on('click', '.view_sql', function(){
              var testt = $(this).attr("id");
              fetch_post_data_lab(testt);
            });
            
            });
    </script>

    <div id="post_modal_sql" class="modal fade" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content"> 
                <div class="modal-header">
                    <h4 class="modal-title">Modal SQL</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body"><?= "pang_opd_stamped"?></div>
                <div class="modal-body"><?= "<HR>"?></div>
                <div class="modal-body"><?php echo nl2br (tab2nbsp($sqlshow));?></div>
                
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_SQL-->




  </body>
</html>








