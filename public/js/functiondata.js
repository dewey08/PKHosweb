
// alert('OJJJJOL');


  /////////  ตั้งเวลา  //////////////
  
  // setTimeout(() => {
  //     window.location.reload(true);
  //   }, 3000);
  //   // }, timeout);
  $(document).ready(function(){
    $('#insert_memberForm').on('submit',function(e){
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
                window.location = "/staff/member"; //  
              }
            })      
          }
        }
      });
    });
  });
   //********** แก้ไข ดึงข้อมูลขึ้นโชว์ Modal เพื่อทำการ Update ********************//
   $(document).on('click','.edit_member',function(e){
    e.preventDefault();        
    var id = $(this).val();
    // var date = date('Y');
    var date = new Date();
    $('#editmemberModal').modal('show');
    // alert(id);
    console.log(id);
    $.ajax({
      type:"GET",
      url:"/staff/staff_member_edit/"+id,
      success: function(response){
        
        console.log(response.data.fname);       
        $('#memfname').val(response.data.fname);
        $('#memlname').val(response.data.lname);
        $('#mememail').val(response.data.email);
        $('#memtel').val(response.data.tel);
        $('#memusername').val(response.data.username);
        $('#img').val(response.data.img);
        $('#memtype').val(response.data.type);               
        $('#editmember_id').val(response.data.member_id);       
        $('#iduser').val(response.data.id);
      }
    })
  });
 //********** Update member ********************//

$(document).ready(function(){
  $('#update_memberForm').on('submit',function(e){
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
              window.location = "/staff/member"; //  
            }
          })      
        }
      }
    });
  });
});


function staff_member_destroy(id)
  {
    // alert('delete');
        Swal.fire({
        title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
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
            url:'/staff/member_destroy/'+id,
            type:'DELETE',
            data:{
              _token : $("input[name=_token]").val()
            },
            success:function(response)
            {            
              Swal.fire({
                title: 'Deleted!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+id).remove();  
                  window.location.reload();   
                }
              })                
            }
          })
         
        }
      })
  }

  function editmember(input) {
    var fileInput = document.getElementById('img');
    var url = input.value;
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();
    
            reader.onload = function (e) {
                $('#edit_upload_preview').attr('src', e.target.result);
            }
    
            reader.readAsDataURL(input.files[0]);
        }else{
    
                    alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                    fileInput.value = '';
                    return false;
            }
        }


////////****** */ Store *****************//////////////

  $(document).ready(function(){
    //********** บันทึก Store  ********************//
    $('#insert_store').on('submit',function(e){
      e.preventDefault();
      var store_name = $("#store_name").val();
      var store_storename = $("#store_storename").val();
      var store_tel = $("#store_tel").val();
      var store_type = $("#store_type").val();
      var store_email = $("#store_email").val();
      var store_username = $("#store_username").val();
      var password = $("#password").val();

      // console.log(store_name); 
        $.ajax({
        type:"POST",
        url:"/staff/store_save",
        data:$('#insert_store').serialize(),
        success:function(response){
          // console.log(response)
          Swal.fire({
                title: 'บันทึกข้อมูลสำเร็จ',
                text: "You save data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  // window.location.reload(); // กรณี Modal 
                  window.location = "/staff/store"; // กรณี add page new 
                }
              })      
        },
        error:function(error){
          console.log(error)
          Swal.fire(
              'บันทึกข้อมูลไม่สำเร็จ!',
              'You clicked the OK!',
              'warning'
            )
        }
      })    
    })
  });



  // //********** Update Store ********************//
  $(document).ready(function(){
    $('#Update_storeForm').on('submit',function(e){
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
            // $.each(data.error,function(prefix,val){
            //   $('span.'+prefix+'_error').text(val[0]);
            // });
            alert('1111');
          } else {
            // $('#Update_storeForm')[0].reset();
            // alert(data.msg);
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
                window.location = "/staff/store"; // กรณี add page new  
              }
            })      
          }
        }
      });
    });
  });
 

  
  function staff_store_destroy(store_id)
  {
    // alert('delete');
        Swal.fire({
        title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
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
            url:'/staff/store_destroy/'+store_id,
            type:'DELETE',
            data:{
              _token : $("input[name=_token]").val()
            },
            success:function(response)
            {           
              Swal.fire({
                title: 'Deleted!',
                text: "You Delet data success",
                icon: 'success',
                showCancelButton: false,
                confirmButtonColor: '#06D177',
                // cancelButtonColor: '#d33',
                confirmButtonText: 'เรียบร้อย'
              }).then((result) => {
                if (result.isConfirmed) {                  
                  $("#sid"+store_id).remove();   
                  window.location.reload();   
                }
              })      
                      
            }
          })
         
        }
      })
  }

   /////// Unit //////////////

  $(document).ready(function(){
    //********** บันทึกหน่วยนับ  ********************//
   $('#insert_unit').on('submit',function(e){
     e.preventDefault();
     var unit_name = $("#unit_name").val();
     // console.log(unit_name); 
       $.ajax({
       type:"POST",
       url:"/staff/unit_save",
       data:$('#insert_unit').serialize(),
       success:function(response){
         // console.log(response)
         // $('#exampleModal').modal('hide')
         Swal.fire({
               title: 'บันทึกข้อมูลสำเร็จ',
               text: "You save data success",
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
       },
       error:function(error){
         console.log(error)
         Swal.fire(
             'บันทึกข้อมูลไม่สำเร็จ!',
             'You clicked the OK!',
             'warning'
           )
       }
     })    
   })
   
    //********** Update หน่วยนับ ********************//
    $('#update_unit').on('submit',function(e){
     e.preventDefault();
     var unit_name = $("#unit_name").val();
     // console.log(unit_name); 
       $.ajax({
       type:"POST",
       url:"/staff/unit_update",
       data:$('#update_unit').serialize(),
       success:function(response){
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
                 window.location.reload(); 
               }
             })      
       },
       error:function(error){
         console.log(error)
         Swal.fire(
             'บันทึกข้อมูลไม่สำเร็จ!',
             'You clicked the OK!',
             'warning'
           )
       }
     })    
   })

   //********** แก้ไข หน่วยนับ ดึงข้อมูลขึ้นโชว์ Modal เพื่อทำการ Update ********************//
   $(document).on('click','.edit_unit',function(e){
       e.preventDefault();        
       var unit_id = $(this).val();
       $('#editexampleModal').modal('show');
       // alert(unit_id);
       // console.log(unit_id);
       $.ajax({
         type:"GET",
         url:"/staff/staff_unit_edit/"+unit_id,
         success: function(response){
           console.log(response.data.unit_name);       
           $('#editunit_name').val(response.data.unit_name);
           $('#editunit_id').val(response.data.unit_id);
         }
       })
     });
   });

  function staff_unit_destroy(unit_id)
  {
    // alert('delete');
    Swal.fire({
    title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
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
        url:'/staff/staff_unit_destroy/'+unit_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {          
            Swal.fire({
              title: 'Deleted!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+unit_id).remove();     
                window.location.reload();   
              }
            }) 
        }
        })        
      }
      })
  }

  /////// category  //////////////

  $(document).ready(function(){
    //********** บันทึก  ********************//
   $('#insert_category').on('submit',function(e){
     e.preventDefault();
     var category_name = $("#category_name").val();
     // console.log(category_name); 
       $.ajax({
       type:"POST",
       url:"/staff/category_save",
       data:$('#insert_category').serialize(),
       success:function(response){
         // console.log(response)
         // $('#exampleModal').modal('hide')
         Swal.fire({
               title: 'บันทึกข้อมูลสำเร็จ',
               text: "You save data success",
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
         // Swal.fire(
         //     'บันทึกข้อมูลสำเร็จ!',
         //     'You clicked at OK!',
         //     'success'
         //   )
         //   window.location.reload();           
       },
       error:function(error){
         console.log(error)
         Swal.fire(
             'บันทึกข้อมูลไม่สำเร็จ!',
             'You clicked the OK!',
             'warning'
           )
       }
     })    
   })
   
    //********** Update  ********************//
    $('#update_category').on('submit',function(e){
     e.preventDefault();
     var category_name = $("#category_name").val();
     // console.log(category_name); 
       $.ajax({
       type:"POST",
       url:"/staff/category_update",
       data:$('#update_category').serialize(),
       success:function(response){
         console.log(response)          
         // Swal.fire(
         //     'บันทึกข้อมูลสำเร็จ!',
         //     'You clicked at OK!',
         //     'success'
         //   )

           // Swal.fire({
           //   position: 'top-end',
           //   icon: 'success',
           //   title: 'Your work has been saved',
           //   showConfirmButton: false,
           //   timer: 1500
           // })

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
                 window.location.reload(); 
               }
             })
           // window.location.reload();  
           // $('#editexampleModal').modal('hide')         
       },
       error:function(error){
         console.log(error)
         Swal.fire(
             'บันทึกข้อมูลไม่สำเร็จ!',
             'You clicked the OK!',
             'warning'
           )
       }
     })    
   })

   //********** แก้ไข ดึงข้อมูลขึ้นโชว์ Modal เพื่อทำการ Update ********************//
   $(document).on('click','.edit_category',function(e){
       e.preventDefault();        
       var category_id = $(this).val();
       $('#editexampleModal').modal('show');
       // alert(category_id);
       // console.log(category_id);
       $.ajax({
         type:"GET",
         url:"/staff/category_edit/"+category_id,
         success: function(response){
           console.log(response.data.category_name);       
           $('#editcategory_name').val(response.data.category_name);
           $('#editcategory_id').val(response.data.category_id);
         }
       })
     });
   });

  function staff_category_destroy(category_id)
  {
    // alert('delete');
    Swal.fire({
    title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
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
        url:'/staff/staff_category_destroy/'+category_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {           
            $("#sid"+category_id).remove(); 
            Swal.fire({
              title: 'Deleted!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+category_id).remove();     
                window.location.reload();   
              }
            })              
        }
        })        
    }
    })
}

///****************************************** */
function staff_product_destroy(id)
{
    // alert('delete');
    Swal.fire({
    title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
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
        url:'/staff/staff_product_destroy/'+id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {
            Swal.fire(
            'Deleted!',
            'ไฟล์ของคุณถูกลบไปแล้ว.',
            'success'
            )
            $("#sid"+id).remove();             
        }
        })
        
    }
    })
}

 //**********  employee  ********************//
function addemployee(input) {
  var fileInput = document.getElementById('img');
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
          var reader = new FileReader();  
          reader.onload = function (e) {
              $('#add_upload_preview').attr('src', e.target.result);
          }  
          reader.readAsDataURL(input.files[0]);
      }else{  
                  alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                  fileInput.value = '';
                  return false;
          }
      }

function editemployee(input) {
  var fileInput = document.getElementById('img');
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
          var reader = new FileReader();  
          reader.onload = function (e) {
              $('#edit_upload_preview').attr('src', e.target.result);
          }  
          reader.readAsDataURL(input.files[0]);
      }else{  
                  alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                  fileInput.value = '';
                  return false;
          }
      }
 //********** Store employee  ********************//
$(document).ready(function(){
  $('#insert_storeemployeeForm').on('submit',function(e){
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
            }
          })      
        }
      }
    });
  });
});
function store_employee_destroy(employee_id)
{
  // alert('delete');
  Swal.fire({
  title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
  text: "ข้อมูลนี้จะถูกลบไปเลย !!",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
  cancelButtonText: 'ไม่, ยกเลิก'
  }).then((result) => {
  if (result.isConfirmed) {
    var store_id = $("#store_id").val();
      $.ajax({
      url:'/staff/store_employee_destroy/'+employee_id,
      type:'DELETE',
      data:{
          _token : $("input[name=_token]").val()
      },
      success:function(response)
      {           
          $("#sid"+employee_id).remove(); 
          Swal.fire({
            title: 'Deleted!',
            text: "You Delet data success",
            icon: 'success',
            showCancelButton: false,
            confirmButtonColor: '#06D177',
            // cancelButtonColor: '#d33',
            confirmButtonText: 'เรียบร้อย'
          }).then((result) => {
            if (result.isConfirmed) {                  
              $("#sid"+employee_id).remove();     
          
              window.location = "/staff/store_employee/"+store_id; //    
            }
          })              
      }
      })        
  }
  })
}
//========== Vendor ==================//
$(document).ready(function(){
  $('#insert_vendorForm').on('submit',function(e){
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
      success:function(data){
        if (data.status == 200 ) {
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
              window.location="/staff/vendor"; //
            }
          })     
        } else {          
          
        }
      }
    });
  });

  $(document).on('click','.edit_vendor',function(e){
    e.preventDefault();        
    var vender_id = $(this).val();
    $('#editexampleModal').modal('show');
    // alert(vender_id);
    // console.log(vender_id);
    $.ajax({
      type:"GET",
      url:"/staff/vendor_edit/"+vender_id,
      success: function(response){
        console.log(response.data.vender_name);  
        console.log(response.data.vender_tel);  
        console.log(response.data.vender_email);  
        console.log(response.data.vender_vat);  
        console.log(response.data.vender_address);  

        $('#editvender_name').val(response.data.vender_name);
        $('#editvender_tel').val(response.data.vender_tel);
        $('#editvender_email').val(response.data.vender_email);
        $('#editvender_vat').val(response.data.vender_vat);
        $('#editvender_address').val(response.data.vender_address);
        $('#vender_id').val(response.data.vender_id);
      }
    })
  });
  
  $('#update_vendorForm').on('submit',function(e){
    e.preventDefault();

    var form = this;
    $.ajax({
      url:$(form).attr('action'),
      method:$(form).attr('method'),
      data:new FormData(form),
      processData:false,
      dataType:'json',
      contentType:false,     
      success:function(data){
        if (data.status == 200 ) { 
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
              window.location = "/staff/vendor"; // กรณี add page new  
            }
          })              
        } else {          
           
        }
      }
    });
  });


});

function vendor_destroy(vender_id)
  {
    // alert('delete');
    Swal.fire({
    title: 'คุณต้องการลบรายการนี้ใช่ไหม ??',
    text: "ข้อมูลนี้จะถูกลบไปเลย !!",
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
    cancelButtonText: 'ไม่, ยกเลิก'
    }).then((result) => {
    if (result.isConfirmed) {
      // var store_id = $("#store_id").val();
        $.ajax({
        url:'/staff/vendor_destroy/'+vender_id,
        type:'DELETE',
        data:{
            _token : $("input[name=_token]").val()
        },
        success:function(response)
        {           
            $("#sid"+vender_id).remove(); 
            Swal.fire({
              title: 'Deleted!',
              text: "You Delet data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                $("#sid"+vender_id).remove();     
            
                window.location = "/staff/vendor"; //    
              }
            })              
        }
        })        
    }
  })
}
 //********** Product  ********************//

$(document).ready(function(){
  $('#insert_productForm').on('submit',function(e){
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
              window.location="/staff/product"; //
            }
          })      
        }
      }
    });
  });

  $('#update_productForm').on('submit',function(e){
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
              window.location = "/staff/product"; // กรณี add page new  
            }
          })      
        }
      }
    });
  });
});

function addproducts(input) {
  var fileInput = document.getElementById('pro_img');
  var url = input.value;
  var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
      if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
          var reader = new FileReader();
  
          reader.onload = function (e) {
              $('#add_upload_preview').attr('src', e.target.result);
          }
  
          reader.readAsDataURL(input.files[0]);
      }else{
  
                  alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                  fileInput.value = '';
                  return false;
          }
      }
  
  function editproducts(input) {
      var fileInput = document.getElementById('pro_img');
      var url = input.value;
      var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
  
              if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
                  var reader = new FileReader();
  
                  reader.onload = function (e) {
                      $('#add_upload_preview').attr('src', e.target.result);
                  }
  
                  reader.readAsDataURL(input.files[0]);
              }else{
  
                          alert('กรุณาอัพโหลดไฟล์ประเภทรูปภาพ .jpeg/.jpg/.png/.gif .');
                          fileInput.value = '';
                          return false;
                  }
          }
