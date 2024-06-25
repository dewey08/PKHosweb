<?php
include("../session/session_claim.php");
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


#ช่วงระยะเวลาปีงบ
$start_year_ngob=($y_s-1)."-10-01";
$end_year_ngob=$y_s."-09-30";
#ช่วงระยะเวลาปีงบ

?>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
  <head>
    <!-- Custom Stylesheet -->
    <link href="../plugins/tables/css/datatable/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/input_datatable.css"/><!-- css สำหรับเปลี่ยน search ให้เห็นกรอบ -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.2.0/jquery.min.js"></script><!--modal-->

  </head>
      




  <body>

    

    <?php

    if($pang_type=='OPD'){
      $s_date = "ps.pang_stamp_vstdate";
    }elseif($pang_type=='IPD'){
      $s_date = "ps.pang_stamp_dchdate";
    }else{
    }

    $date_now=date("Y-m-d");
    $sqlshow = "SELECT 
                    ps.pang_stamp_vn AS 'vn'
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
                    FROM $database_ii.pang_stamp ps
                    LEFT JOIN receipt_number rn ON ps.pang_stamp_stm_file_name=rn.receipt_number_stm_file_name
                    WHERE ps.pang_stamp = '$pang'
                    AND $s_date BETWEEN '$start_year_ngob' AND '$end_year_ngob'
                    AND (ps.pang_stamp_stm_money IS NULL OR ps.pang_stamp_stm_money='')
                    AND (rn.receipt_book_id IS NOT NULL OR rn.receipt_book_id!='')
                    GROUP BY ps.pang_stamp_vn
                    LIMIT 10001 ";
                    #AND ps.pang_stamp_edit_olddata !='sit'
    $result_showed = mysqli_query($con_money, $sqlshow);
    $field_c = mysqli_num_fields($result_showed);
    ?>

 

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">  
            <h2>ตัดลูกหนี้รายตัว แสดงทั้งปีงบ</h2>  
              <div class="table-responsive">

                  <!-- Modal sql -->    
                  <div class="col-md-1 col-lg-1 mb-1">
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
                        
                        <div class="modal-body"><?php echo $sqlshow?></div>
                        pang_opd_stamped_doc
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

              

                <table id="example"  class="table table-striped table-bordered zero-configuration">  
                  <thead>
                    <tr>

                      <th class=""><div align="center">No</div></th>
                      <th class=""><div align="center">เอกสารเบิก</div></th>
                      <th class=""><div align="center">ตัดรายตัว</div></th>
                      <th class=""><div align="center">HN(การรักษา)</div></th>
                      
                      <th class=""><div align="center">Stamp_uc_money</div></th>
                      <th class=""><div align="center">วันที่รับบริการ</div></th>
                      
                      
                      
                    </tr>
                  </thead>

                  <tbody>
                    <?php                
                    $no=0;
                    while($row_show = mysqli_fetch_array($result_showed)){
                    $no++;   
                    $pang_stamp = $row_show["pang_stamp"]; 
                    $pang_stamp_vn = $row_show["vn"]; 
                    $pang_stamp_edit_send_id = $row_show["pang_stamp_edit_send_id"];  
                    $pang_stamp_id = $row_show["pang_stamp_id"];
                    $pang_stamp_stm_file_name = $row_show["pang_stamp_stm_file_name"];
                    ?>
                    <tr>              
                                            
                      <td></td>

                      <td class="text-left" >
                      
                        <!-- กระบวนการ_ตัดเอกสาร_กรณีผังที่เลือกต้องตัดด้วยเอกสาร -->
                        <?php 
                        if($pang_stm=='doc'){
                          #ถ้าว่าง แสดงว่ายังไม่ได้ระบุเลขที่เอกสารเบิก
                          if($pang_stamp_stm_file_name==''){
                          ?>
                            <button type="button" name="view_insert_stm_doc" class="btn btn-info view_insert_stm_doc" 
                            id="<?php echo $pang_stamp_id.'|'.$pang_stamp."|".$pang_type."|".$m_s;?>"  >ลงเอกสาร
                            </button>
                          <?php 
                          }else{
                          ?>
                            <button type="button" class="btn btn-success view_doc" id="<?php echo $pang_stamp_stm_file_name;?>">
                              <?php echo $row_show["pang_stamp_stm_rep"] ; ?>
                            </button>
                          <?php  
                          }
                        }
                        ?>
                        <!-- กระบวนการ_ตัดเอกสาร_กรณีผังที่เลือกต้องตัดด้วยเอกสาร -->

                      </td>  

                      <td class="text-center">
                        <button type="button" name="view_patient" class="btn mb-1 btn-warning view_stm_doc" id="<?php echo $pang_stamp_id.'_'.$pang_type;?>"  >
                          ลงตัดรายตัว
                        </button>
                      </td>          

                      <td class="text-center">
                        <button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="<?php echo $pang_stamp_vn;?>"  >
                          <?php echo $row_show["hn"]; ?>
                        </button>
                      </td>

                      

                      <td class="text-right">
                        <?php
                        if($row_show["pang_stamp_uc_money_kor_tok"]!=0){
                          $show_kor_tok="<span style='color:red;'>(".number_format($row_show["pang_stamp_uc_money_kor_tok"],2).")</span>";
                        }else{$show_kor_tok='';}
                        echo number_format($row_show["pang_stamp_uc_money"],2).$show_kor_tok;
                        ?>
                      </td>

                      <td class="text-center" data-order='<?php echo $row_show["pang_stamp_vstdate"]; ?>' >
                        <?php
                        echo DateThaisubmonth($row_show["pang_stamp_vstdate"]);
                        ?>
                      </td>

                      
                      <!-- ############################################## -->
              
    
                    </tr>
                    <?php
                    }// loop while
                    ?>
                  </tbody>
        <!-- </form> -->
                </table>

    
            </div>

          </div>
        </div>
      </div>
    </div>

    <!-- Modal_stm_doc -->
    <script>
      $(document).ready(function(){
             
        function fetch_post_data_lab(pang_stamp_id)
        {
          $.ajax({
            url:"pang_opd_stamped_doc_stm_form.php",
            method:"POST",
            data:{pang_stamp_id:pang_stamp_id},
            success:function(data)
            {
              $('#post_modal_patient').modal('show');
              $('#post_detail_patient').html(data);
            }
          });
        }

        $(document).on('click', '.view_stm_doc', function(){
          var pang_stamp_id = $(this).attr("id");
          fetch_post_data_lab(pang_stamp_id);
        });
             
      });
    </script>

    <div id="post_modal_patient" class="modal fade">
      <div class="modal-dialog modal-lg">
        <div class="modal-content"> 
          <div class="modal-header">
            <h1 class="modal-title">ลงตัดรายตัว</h1>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body" id="post_detail_patient"></div>
        </div>
      </div>
    </div>
    <!-- Modal_stm_doc-->


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
            <h1 class="modal-title">การรักษา</h1>
            <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
          </div>
          <div class="modal-body" id="post_detail_patient"></div>
        </div>
      </div>
    </div>
    <!-- Modal_patient-->



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
    var table = $('#example').DataTable({
      "pageLength": 500,
      "lengthMenu": [ 10, 100, 500, 5000 ],
      dom: '<"top"lipf<"clear">> rt <"bottom"ip<"clear">>',
      responsive: {
        details: {
          type: 'column'
        }
      },
      order: [2, 'desc'],

      colReorder: {
        fixedColumnsLeft: 1,
        fixedColumnsLeft: 2
      },
            
      fixedHeader: {
        header: true,
        footer: true
      }, 
      
      'columnDefs': [{
          'targets': 1,
          'searchable': false,
          'orderable': false,
          'width': '1%',
          'className': 'dt-body-center'
        },
          {
          'className': 'control',
          'orderable': false,
          targets: 0
        }, 
      ],
          
      'order': [[5, 'desc']],

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
       
    /** mark single checkboxes */

    table.on('order.dt search.dt', function () {
      let i = 1;
     
      table.cells(null, 0, { search: 'applied', order: 'applied' }).every(function (cell) {
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
                  <h1 class="modal-title">แก้ไขรายการ Stamp</h1>
                  <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                </div>
                <div class="modal-body" id="post_detail_claim_code">
                </div>
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
                  <h1 class="modal-title">ลงเอกสารเบิก</h1>
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
                    <h4 class="modal-title">เอกสารเบิก</h4>
                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="post_detail_doc_pic">
                </div>
            </div>
        </div>
    </div>
    <!-- Modal_doc_stm-->


  </body>
</html>








