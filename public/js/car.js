
$.ajaxSetup({
  headers:{
    'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
  }
})


function detail(id){
  $.ajax({
          url:"{{route('hn.detailappall')}}",
          method:"GET",
          data:{id:id},
          success:function(result){
              $('#detail').html(result);
          }
      })
  }

  function suphn_detail(id){
    $.ajax({
            url:"/suphn_detail",
            method:"GET",
            data:{id:id},
            success:function(result){
                $('#suphn_detail').html(result);
            }
        })
    }


 //**********HN Product  ********************//
//  function supplies_dataadd_sub(product_id)
 function supplies_dataadd_sub(id,product_id)
 {
        // alert(id);
        Swal.fire({
        title: 'ต้องการเพิ่ม',
        //  text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'ใช่',
        cancelButtonText: 'ยกเลิก'
        }).then((result) => {
    if (result.isConfirmed) {
        $.ajax({
        //  url:'/user/supplies_data_add_subsave/'+ product_id,
        url:'/user/supplies_data_add_subsave/'+id +'/'+ product_id,
        type:'POST',
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
                $("#sid"+product_id).remove();     
                // window.location.reload(); 
                //  window.location = "/user/supplies_data_add_sub/"+ product_id; //  
                window.location = "/user/supplies_data_add_sub/"+id +'/'+ product_id; //    
              }
            }) 
        }
        })        
      }
      })
 }
 $(document).ready(function(){
   
    $('#update_usersuppliesForm').on('submit',function(e){
      e.preventDefault();
      var id = $("#user_id").val();
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
                window.location="/user/supplies_data_add/" + id; //
              }
            })      
          }
        }
      });
    });
    
  });

  //********** แก้ไข ดึงข้อมูลขึ้นโชว์ Modal เพื่อทำการ Update ********************//
  $(document).on('click','.edithn_suprep',function(e){
    e.preventDefault();        
        let request_id = $(this).data('request_id');
        let request_code = $(this).data('request_code');
        let request_year = $(this).data('request_year');
        let request_date = $(this).data('request_date');
        let request_debsubsub_name = $(this).data('request_debsubsub_name');
        let request_user_name = $(this).data('request_user_name');
        let user_id = $(this).data('user_id');
        let request_because = $(this).data('request_because');
        let request_hn_id = $(this).data('request_hn_id');
        let request_hn_name = $(this).data('request_hn_name'); 

        $('#editexampleModal').modal('show');      
        $('#up_request_code').val(request_code);
        $('#up_request_year').val(request_year);
        $('#up_request_date').val(request_date);
        $('#up_request_debsubsub_name').val(request_debsubsub_name);
        $('#up_request_user_name').val(request_user_name);
        $('#up_user_id').val(user_id);
        $('#up_request_because').val(request_because);
        $('#up_request_hn_id').val(request_hn_id);
        $('#up_request_hn_name').val(request_hn_name);
        $('#up_request_id').val(request_id);
    $.ajax({
    
      url:"/hn/hn_purchaseindex_detail/"+request_id,
      type:"GET",
      success: function(response){
        
        console.log(response.data.request_id);       
        // $('#request_code').val(response.data.request_code);
        // $('#memlname').val(response.data.lname);
        // $('#mememail').val(response.data.email);
        // $('#memtel').val(response.data.tel);
        // $('#memusername').val(response.data.username);
        // $('#img').val(response.data.img);
        // $('#memtype').val(response.data.type);               
        // $('#request_id').val(response.data.request_id);       
        // $('#user_id').val(response.data.id);
      }
    })
  });

  $('#update_upplies_repForm').on('submit',function(e){
    e.preventDefault();
    var id = $("#user_id").val();
    var up_request_id = $("#up_request_id").val();
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
              window.location="/user/supplies_data_add/" + id; //
            }
          })      
        }
      }
    });
  });

  function addcartype() {
    var car_typename = document.getElementById("CAR_TYPE_INSERT").value;
    // alert(car_typename);
    var _token = $('input[name="_token"]').val();
    $.ajax({
        url: "/car/add_cartype",
        method: "GET",
        data: {
          car_typename: car_typename,
            _token: _token
        },
        success: function (result) {
            $('.show_type').html(result);
        }
    })
}

function addcarbrand() {
  var car_brandname = document.getElementById("CAR_MODEL_INSERT").value;
  // alert(car_brandname);
  var _token = $('input[name="_token"]').val();
  $.ajax({
      url: "/car/add_carbrand",
      method: "GET",
      data: {
        car_brandname: car_brandname,
          _token: _token
      },
      success: function (result) {
          $('.show_brand').html(result);
      }
  })
}
function addcarcolor() {
  var car_colorname = document.getElementById("CAR_COLOR_INSERT").value;
  // alert(car_brandname);
  var _token = $('input[name="_token"]').val();
  $.ajax({
      url: "/car/add_carcolor",
      method: "GET",
      data: {
        car_colorname: car_colorname,
          _token: _token
      },
      success: function (result) {
          $('.show_color').html(result);
      }
  })
}

function addarticle(input) {
  var fileInput = document.getElementById('article_img');
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

function editarticle(input) {
var fileInput = document.getElementById('article_img');
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

$(document).ready(function(){

    $('#insert_carForm').on('submit',function(e){
      e.preventDefault();
      var form = this; 
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
          if (data.status == 500 ) {
            alert('Error');
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
                window.location="/car/car_data_index"; //
              }
            })      
          }
        }
      });
    });

    $('#update_carForm').on('submit',function(e){
      e.preventDefault();
      var form = this; 
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
                // window.location.reload();             
                window.location = "/car/car_data_index"; // กรณี add page new  
                // window.location="{{url('car/car_data_index')}}"; //
              }
            })      
          }
        }
      });
    });
  
  
});

function car_destroy(article_id)
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
        url:'/car/car_destroy/'+article_id,
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
                $("#sid"+article_id).remove();     
                // window.location.reload(); 
                window.location = "/car/car_data_index"; //     
              }
            }) 
        }
        })        
      }
      })
  }