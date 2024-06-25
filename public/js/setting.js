
  $(function () {     
    var table = $('#datatable').DataTable({
        processing: true,
        serverSide: true,
        ajax: "setting/setting_index",
        columns: [
            {data: 'DEPARTMENT_ID', name: 'DEPARTMENT_ID'},
            {data: 'DEPARTMENT_NAME', name: 'DEPARTMENT_NAME'},
            {data: 'LEADER_NAME', name: 'LEADER_NAME'},   
            {data: 'LINE_TOKEN', name: 'LINE_TOKEN'},        
        ]
    });
     
  });
//   $(document).ready(function() {
//     $('#datatable').dataTable( {
//         processing: true,
//         serverSide: true,
//         ajax: {
//             url: "setting.setting_index",
//             type: "GET"
//         },
//         columns: [
//             { "data": "DEPARTMENT_ID" },
//             { "data": "DEPARTMENT_NAME" },
//             { "data": "LEADER_NAME" },
//             { "data": "LINE_TOKEN" } 
//         ]
//     } );
// } );


 //********** Department  ********************//

 $(document).ready(function(){
    $('#insert_depForm').on('submit',function(e){
      e.preventDefault();
  
      var form = this;
    //   alert('OJJJJOL');
      $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
          $(form).find('span.error-text').text('');
        },
        success:function(data){
          if (data.status == 0 ) {
            
          } else {          
            Swal.fire({
              title: 'บันทึกข้อมูลสำเร็จ',
              text: "You Insert data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                window.location="/setting/setting_index"; //
              }
            })      
          }
        }
      });
    });
  
    $('#update_depForm').on('submit',function(e){
      e.preventDefault();
  
      var form = this;
      // alert('OJJJJOL');
      $.ajax({
        url:$(form).attr('action'),
        method:$(form).attr('method'),
        data:new FormData(form),
        processData:false,
        dataType:'json',
        contentType:false,
        beforeSend:function(){
          $(form).find('span.error-text').text('');
        },
        success:function(data){
          if (data.status == 0 ) {
            
          } else {          
            Swal.fire({
              title: 'แก้ไขข้อมูลสำเร็จ',
              text: "You edit data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                window.location = "/setting/setting_index"; // กรณี add page new  
              }
            })      
          }
        }
      });
    });
    
    
  });

  function settingdep_destroy(DEPARTMENT_ID)
  {
    Swal.fire({
    title: 'ต้องการลบใช่ไหม?',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url:'/setting/setting_index_destroy/'+DEPARTMENT_ID,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'ลบข้อมูล!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+DEPARTMENT_ID).remove();     
                // window.location.reload(); 
                window.location = "/setting/setting_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }

// *******************************************

  $('#insert_depsubForm').on('submit',function(e){
    e.preventDefault();

    var form = this;
  //   alert('OJJJJOL');
    $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,
      beforeSend:function(){
        $(form).find('span.error-text').text('');
      },
      success:function(data){
        if (data.status == 0 ) {
          
        } else {          
          Swal.fire({
            title: 'บันทึกข้อมูลสำเร็จ',
            text: "You Insert data success",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#06D177',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'เรียบร้อย'
          }).then((result) => {
            if (result.isConfirmed) {                  
              window.location="/setting/depsub_index"; //
            }
          })      
        }
      }
    });
  });

  $('#update_depsubForm').on('submit',function(e){
    e.preventDefault();

    var form = this;
    // alert('OJJJJOL');
    $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,
      beforeSend:function(){
        $(form).find('span.error-text').text('');
      },
      success:function(data){
        if (data.status == 0 ) {
          
        } else {          
          Swal.fire({
            title: 'แก้ไขข้อมูลสำเร็จ',
            text: "You edit data success",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#06D177',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'เรียบร้อย'
          }).then((result) => {
            if (result.isConfirmed) {                  
              window.location = "/setting/depsub_index"; // กรณี add page new  
            }
          })      
        }
      }
    });
  });
  function depsub_destroy(DEPARTMENT_SUB_ID)
  {
    Swal.fire({
    title: 'ต้องการลบใช่ไหม?',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url:'/setting/depsub_destroy/'+DEPARTMENT_SUB_ID,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'ลบข้อมูล!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+DEPARTMENT_SUB_ID).remove();     
                // window.location.reload(); 
                window.location = "/setting/depsub_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }
// *******************************************

$('#insert_depsubsubForm').on('submit',function(e){
  e.preventDefault();

  var form = this;
//   alert('OJJJJOL');
  $.ajax({
    url:$(form).attr('action'),
    method:$(form).attr('method'),
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    beforeSend:function(){
      $(form).find('span.error-text').text('');
    },
    success:function(data){
      if (data.status == 0 ) {
        
      } else {          
        Swal.fire({
          title: 'บันทึกข้อมูลสำเร็จ',
          text: "You Insert data success",
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#06D177',
          // cancelButtonColor: '#d33',
          confirmButtonText: 'เรียบร้อย'
        }).then((result) => {
          if (result.isConfirmed) {                  
            window.location="/setting/depsubsub_index"; //
          }
        })      
      }
    }
  });
});
$('#update_depsubsubForm').on('submit',function(e){
        e.preventDefault();

        var form = this;
        // alert('OJJJJOL');
        $.ajax({
          url:$(form).attr('action'),
          method:$(form).attr('method'),
          data:new FormData(form),
          processData:false,
          dataType:'json',
          contentType:false,
          beforeSend:function(){
            $(form).find('span.error-text').text('');
          },
          success:function(data){
            if (data.status == 0 ) {
              
            } else {          
              Swal.fire({
                title: 'แก้ไขข้อมูลสำเร็จ',
                text: "You edit data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  window.location = "/setting/depsubsub_index"; // กรณี add page new  
                }
              })      
            }
          }
        });
});



function depsubsub_destroy(DEPARTMENT_SUB_SUB_ID)
  {
    Swal.fire({
    title: 'ต้องการลบใช่ไหม?',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url:'/setting/depsubsub_destroy/'+DEPARTMENT_SUB_SUB_ID,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'ลบข้อมูล!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+DEPARTMENT_SUB_SUB_ID).remove();     
                // window.location.reload(); 
                window.location = "/setting/depsubsub_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }
// *******************************************

$('#insert_leaderForm').on('submit',function(e){
  e.preventDefault();

  var form = this;
//   alert('OJJJJOL');
  $.ajax({
    url:$(form).attr('action'),
    method:$(form).attr('method'),
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    beforeSend:function(){
      $(form).find('span.error-text').text('');
    },
    success:function(data){
      if (data.status == 0 ) {
        
      } else {          
        Swal.fire({
          title: 'บันทึกข้อมูลสำเร็จ',
          text: "You Insert data success",
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#06D177',
          // cancelButtonColor: '#d33',
          confirmButtonText: 'เรียบร้อย'
        }).then((result) => {
          if (result.isConfirmed) {                  
            window.location="/setting/leader"; //
          }
        })      
      }
    }
  });
});

$('#insert_leadersubForm').on('submit',function(e){
  e.preventDefault();

  var form = this;
  // alert('OJJJJOL');
  $.ajax({
    url:$(form).attr('action'),
    method:$(form).attr('method'),
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    beforeSend:function(){
      $(form).find('span.error-text').text('');
    },
    success:function(data){
      if (data.status == 0 ) {
        
      } else {          
        Swal.fire({
          title: 'บันทึกข้อมูลสำเร็จ',
          text: "You Insert data success",
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#06D177',
          // cancelButtonColor: '#d33',
          confirmButtonText: 'เรียบร้อย'
        }).then((result) => {
          if (result.isConfirmed) {   
            window.location.reload();                
            // window.location="/setting/leader"; //
          }
        })      
      }
    }
  });
});
function leader_destroy(leave_id)
  {
    Swal.fire({
    title: 'ต้องการลบใช่ไหม?',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url:'/setting/leader_destroy/'+leave_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'ลบข้อมูล!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+leave_id).remove();     
                window.location.reload(); 
                // window.location = "/setting/depsubsub_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }
function leadersub_destroy(leave_sub_id)
  {
    Swal.fire({
    title: 'ต้องการลบใช่ไหม?',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        url:'/setting/leadersub_destroy/'+leave_sub_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'ลบข้อมูล!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+leave_sub_id).remove();     
                window.location.reload(); 
                // window.location = "/setting/depsubsub_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }

 $(document).on('click','.edit_line',function(){
    var line_token_id = $(this).val();
    // alert(line_token_id);
    $('#linetokenModal').modal('show');
    $.ajax({
      type: "GET",
      // url: "/zoffice/public/setting/line_token_edit/"+ line_token_id, // กรณีอยู่บนคลาวให้ใส่พาทให้ด้วย
      url: "/setting/line_token_edit/"+ line_token_id,  //ทำในคอมตัวเอง
      success: function(data) {
          console.log(data.line_token.line_token_name);
          $('#line_token_name').val(data.line_token.line_token_name)  
          $('#line_token_code').val(data.line_token.line_token_code) 
          $('#line_token_id').val(data.line_token.line_token_id)                
      },      
  });
   
 });
//  $(document).on('click','edit_line',function(e){
//   e.preventDefault();
//   alert('ok');
// });
$('#insert_lineForm').on('submit',function(e){
  e.preventDefault();

  var form = this;
//   alert('OJJJJOL');
  $.ajax({
    url:$(form).attr('action'),
    method:$(form).attr('method'),
    data:new FormData(form),
    processData:false,
    dataType:'json',
    contentType:false,
    beforeSend:function(){
      $(form).find('span.error-text').text('');
    },
    success:function(data){
      if (data.status == 0 ) {
        
      } else {          
        Swal.fire({
          title: 'แก้ไขข้อมูลสำเร็จ',
          text: "You Update data success",
          icon: 'success',
          showCancelButton: false,
          confirmButtonColor: '#06D177',
          // cancelButtonColor: '#d33',
          confirmButtonText: 'เรียบร้อย'
        }).then((result) => {
          if (result.isConfirmed) {                  
            window.location.reload(); 
          }
        })      
      }
    }
  });
});