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


# pang_pttype #########################################
$concat_pttype_all="";
$sql_concat_pttype=" SELECT pp.pang_pttype FROM pang_pttype pp WHERE pp.pang_id='$pang' LIMIT 500";
$result_concat_pttype = mysqli_query($con_money, $sql_concat_pttype) or die(mysqli_error($con_money));
while($row_concat_pttype = mysqli_fetch_array($result_concat_pttype)){
  $concat_pttype_all.="'".$row_concat_pttype['pang_pttype']."',";
}//loop while row_concat_pttype
$concat_pttype_all=substr($concat_pttype_all,0,strlen($concat_pttype_all)-1);


if($concat_pttype_all!=""){
  $where_pttype=" AND o.pttype IN (".$concat_pttype_all.") ";
}else{
  $where_pttype=" AND ptt.hipdata_code = 'UCS' AND ptt.paidst='02' ";
}
# pang_pttype #########################################

# pang_hospcode #########################################
$concat_hospcode="";
$s_concat_hospcode=" SELECT ph.pang_hospcode FROM pang_hospcode ph WHERE ph.pang_id='$pang' LIMIT 500";
$q_concat_hospcode = mysqli_query($con_money, $s_concat_hospcode) or die(mysqli_error($con_money));
while($r_concat_hospcode = mysqli_fetch_array($q_concat_hospcode)){
  $concat_hospcode.="'".$r_concat_hospcode['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode=substr($concat_hospcode,0,strlen($concat_hospcode)-1);


if($concat_hospcode!=""){
  $where_hospcode_in=" AND o.hospmain IN (".$concat_hospcode.") ";
}else{
  $where_hospcode_in="  ";
}
# pang_hospcode #########################################

# pang_hospcode_notin #########################################
$concat_hospcode_notin="";
$s_concat_hospcode_notin=" SELECT phn.pang_hospcode FROM pang_hospcode_notin phn WHERE phn.pang_id='$pang' LIMIT 500";
$q_concat_hospcode_notin = mysqli_query($con_money, $s_concat_hospcode_notin) or die(mysqli_error($con_money));
while($r_concat_hospcode_notin = mysqli_fetch_array($q_concat_hospcode_notin)){
  $concat_hospcode_notin.="'".$r_concat_hospcode_notin['pang_hospcode']."',";
}//loop while row_concat_hospcode
$concat_hospcode_notin=substr($concat_hospcode_notin,0,strlen($concat_hospcode_notin)-1);

if($concat_hospcode_notin!=""){
  $where_hospcode_notin=" AND o.hospmain NOT IN (".$concat_hospcode_notin.") ";
}else{
  $where_hospcode_notin="  ";
}
# pang_hospcode_notin #########################################

# pang_kor_tok check ข้อตกลง #########################################
$pang_kor_tok = $row_pang_preview["pang_kor_tok"];
$pang_kor_tok_icd = $row_pang_preview["pang_kor_tok_icd"];
# pang_kor_tok check ข้อตกลง #########################################

# pang_cancer ###########
/*
if(isset($row_pang_preview["pang_cancer"])){
  $where_pang_cancer = " AND v.pdx LIKE 'C%' ";
}else{
  $where_pang_cancer = " AND v.pdx NOT LIKE 'C%' ";
}
*/
# pang_cancer ###########


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
                    FROM $database_ii.pang_stamp ps
                    WHERE ps.pang_stamp = '$pang'
                    AND $s_date BETWEEN '$start_year' AND '$end_year'
                    AND ps.pang_stamp_uc_money <>0
                    ORDER BY ps.pang_stamp_hn
                    LIMIT 50000";
    

                    #AND ps.pang_stamp_edit_olddata !='sit'
    $result_showed = mysqli_query($con_money, $sqlshow);
    $field_c = mysqli_num_fields($result_showed);
    ?>

 

    <div class="row">
      <div class="col-12">
        <div class="card">
          <div class="card-body">  
            <h2>รายการที่ทำการ Stamp แล้ว</h2>  
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
                        
                        <div class="modal-body"><?= "pang_opd_stamped"?></div>
                        <div class="modal-body"><?php echo nl2br (tab2nbsp($sqlshow));?></div>
                        
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

              
              <!-- ฟอร์ม บันทึกลงเลขที่เอกสารเบิกแบบกลุ่ม จะทำงานก็ต่อเมื่อ pang_stm =doc -->  
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

                <table id="example" class="table table-striped table-bordered zero-configuration">  
                  <thead>
                    <tr>

                      <th><input  name="select_all" value="1" type="checkbox" autocomplete="off"></th>

                      <th class=""><div align="center">No</div></th>
                      <th class=""><div align="center">Stamp(แก้ไข)</div></th>
                      <th class=""><div align="center">บันทึกแก้</div></th>
                      <th class=""><div align="center">HN(การรักษา)</div></th>
                      <th class=""><div align="center">วันที่รับบริการ</div></th>
                      <th class=""><div align="center">Stamp_uc_money</div></th>

                      <th class=""><div align="center">ชดเชย</div></th>
                      <th class=""><div align="center">ส่วนต่ำ</div></th>
                      <th class=""><div align="center">ส่วนสูง</div></th>

                      <th class=""><div align="center">STM</div></th>
                      
                      <th class=""><div align="center">เลขที่ส่งหนังสือ</div></th>
                      
                      
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
              
                      <td>
                        <!-- กระบวนการ ตัดเอกสาร กรณีผังที่เลือกต้องตัดด้วยเอกสาร และยังไม่ได้ระบุเอกสารเบิก -->
                        <?php 
                        if($pang_stm=='doc' && $pang_stamp_stm_file_name==''){
                        ?>  
                          <input type="checkbox" name="pang_stamp_id[]" value="<?php echo $pang_stamp_id?>" >
                          <input type="hidden" name="pang_stamp"      value="<?php echo $pang_stamp?>">
                          <input type="hidden" name="pang_type"       value="<?php echo $pang_type?>">
                          <input type="hidden" name="m_s"             value="<?php echo $m_s?>">
                        <?php 
                        }
                        ?>
                        <!-- กระบวนการ ตัดเอกสาร กรณีผังที่เลือกต้องตัดด้วยเอกสาร และยังไม่ได้ระบุเอกสารเบิก -->
                        
                      </td>
              </form> <!-- ฟอร์ม บันทึกลงเลขที่เอกสารเบิกแบบกลุ่ม จะทำงานก็ต่อเมื่อ pang_stm =doc -->
                      
                      <td></td>

                      <td>
                        <!-- กระบวนการ Stamp -->
                        <?php
                        #echo $no;
                        
                        if($row_show["0"]=="Y" && $row_show["pang_stamp_send"]!=""){
                        ?>
                          <!--
                          <a class="btn btn-md btn-danger" >ส่งการเงินแล้ว</a>
                          -->
                          <button type="button" name="view_edit_stamp" class="btn btn-danger view_edit_stamp" 
                            id="<?php echo $pang_stamp_vn.'|'.$pang_stamp."|".$backto;?>"  >ส่งการเงินแล้ว
                          </button>

                          <?php
                        }elseif($row_show["0"]=="Y"){
                        ?>
                          <button type="button" name="view_edit_stamp" class="btn btn-primary view_edit_stamp" 
                            id="<?php echo $pang_stamp_vn.'|'.$pang_stamp."|".$backto;?>"  >Stamp
                          </button>
                        <?php
                        }else{
                          echo $row_show["0"];
                        }    
                        ?>
                        <!-- กระบวนการ Stamp -->

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
                        <?php 
                        if($pang_stamp_edit_send_id!=''){
                        ?>
                          <a class="btn btn-info " target="_blank" href="../report/edit_stamp.php?pang_stamp_id=<?=$pang_stamp_id?>">บันทึกข้อความ</a>
                        <?php 
                        }
                        ?>
                      </td>          

                      <td class="text-center">
                        <button type="button" name="view_patient" class="btn mb-1 btn-secondary view_patient" id="<?php echo $pang_stamp_vn;?>"  >
                          <?php echo $row_show["hn"]; ?>
                        </button>
                      </td>

                      <td class="text-center" data-order='<?php echo $row_show["pang_stamp_vstdate"]; ?>' >
                        <?php
                        echo DateThaisubmonth($row_show["pang_stamp_vstdate"]);
                        ?>
                      </td>

                     

                      <td class="text-right">
                        <?php
                        if($row_show["pang_stamp_uc_money_kor_tok"]!=0){
                          $show_kor_tok="<span style='color:red;'>(".number_format($row_show["pang_stamp_uc_money_kor_tok"],2).")</span>";
                        }else{$show_kor_tok='';}
                        echo number_format($row_show["pang_stamp_uc_money"],2).$show_kor_tok;
                        ?>
                      </td>


                      <td class="text-right">
                        <?php
                        if($row_show["stm"]!='' || $row_show["stm"] !=0){                        
                          echo number_format($row_show["stm"],2);
                        }
                        ?>
                      </td>


                      <td align="right" style="font-size: 20px; color: green;">
                        <?php 
                        if($row_show["pang_stamp_uc_money_minut_stm_money"]<=0){
                          echo $row_show["pang_stamp_uc_money_minut_stm_money"];
                        } 
                        ?>
                      </td>  

                      <td align="right" style="font-size: 20px; color: red;">                       
                        <?php 
                        if($row_show["pang_stamp_uc_money_minut_stm_money"]>0){
                          echo number_format(abs($row_show["pang_stamp_uc_money_minut_stm_money"]),2); 
                        }
                        ?>
                      </td>
                      

                      <td class="text-nowrap">
                        <?php
                        echo $row_show["pang_stamp_stm_file_name"];
                        ?>
                      </td>                  
              
                      <td>
                        <?php echo $row_show["pang_stamp_send"]; ?>
                      </td>
                    </tr>
                    <?php
                    }// loop while
                    ?>
                  </tbody>
                </table>

    
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
      order: [1, 'asc'],

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
          
      'order': [[1, 'asc']],

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








