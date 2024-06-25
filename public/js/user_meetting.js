
 //********** meetting  ********************//

  // alert('ok')
    function checkroom(){  

        var ROOM_ID=document.getElementById("ROOM_ID").value;
        var MEETTING_DATE_BEGIN=document.getElementById("MEETTING_DATE_BEGIN").value;
        var MEETTING_TIME_BEGIN=document.getElementById("MEETTING_TIME_BEGIN").value;
      
        var _token=$('input[name="_token"]').val();
            $.ajax({
                    // url:"{{route('meeting.checkroom')}}",
                    method:"GET",
                    data:{ROOM_ID:ROOM_ID,MEETTING_DATE_BEGIN:MEETTING_DATE_BEGIN,MEETTING_TIME_BEGIN:MEETTING_TIME_BEGIN,_token:_token},
                    success:function(result){  
                                        
                        $('.checkroom').html(result);                  
                    }
            })       
             
    } 

    $('#insert_meetingForm').on('submit',function(e){
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
                window.location="/user_meetting/meetting_index"; //
              }
            })      
          }
        }
      });
    });
    $('#insert_chooselinesaveForm').on('submit',function(e){
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
                window.location="/user_meetting/meetting_index"; //
              }
            })      
          }
        }
      });
    });

    $('#insert_chooselineupdateForm').on('submit',function(e){
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
              text: "You Insert data success",
              icon: 'success',
              showCancelButton: false,
              confirmButtonColor: '#06D177',
              // cancelButtonColor: '#d33',
              confirmButtonText: 'เรียบร้อย'
            }).then((result) => {
              if (result.isConfirmed) {                  
                window.location="/user_meetting/meetting_index"; //
              }
            })      
          }
        }
      });
    });
  
    // $(document).ready(function() { 
    //       $.ajaxSetup({
    //         headers: {
    //             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    //         }
    //       });
    //       $(function() {
    //         $('#saveBtn').click(function() {
    //           var meettingtitle = $('#meetting_title').val();
    //           var status = $('#status').val();
    //           var meettingyear = $('#meetting_year').val();
    //           var meettingtarget = $('#meetting_target').val();
    //           var meettingpersonqty = $('#meetting_person_qty').val();
    //           var meetingdatebegin = $('#meeting_date_begin').val();
    //           var meetingdateend = $('#meeting_date_end').val();
    //           var meetingobj = $('#meeting_objective_id').val();
    //           var userid = $('#userid').val();
    //           var roomid = $('#room_id').val();
    //           var timbegin = $('#meeting_time_begin').val();
    //           var timeend = $('#meeting_time_end').val();
    //           alert(meettingtitle);
    //           $.ajax({
    //             url: "{{ route('meetting.meetting_choose_save') }}",
    //             type: "POST",
    //             dataType: 'json',
    //             data: {
    //                 meettingtitle,
    //                 meetingdatebegin,
    //                 meetingdateend,
    //                 status,
    //                 // meettingyear,
    //                 // meettingtarget,
    //                 // meettingpersonqty,
    //                 // meetingobj,
    //                 // userid,
    //                 roomid,
    //                 // timbegin,
    //                 // timeend
    //             },
    //             success: function(response) {

    //                 if (response.status == 0) {

    //                 } else {
    //                     Swal.fire({
    //                         title: 'บันทึกข้อมูลสำเร็จ',
    //                         text: "You Insert data success",
    //                         icon: 'success',
    //                         showCancelButton: false,
    //                         confirmButtonColor: '#06D177',
    //                         // cancelButtonColor: '#d33',
    //                         confirmButtonText: 'เรียบร้อย'
    //                     }).then((result) => {
    //                         if (result
    //                             .isConfirmed) {
    //                             console.log(
    //                                 response);
    //                                 window.location="/user_meetting/meetting_index"; //
    //                             // window.location
    //                             //     .reload();
    //                         }
    //                     })
    //                 }
    //                 // $('#meettingModal').modal('hide')

    //             },                
    //         });
    //         });
    //       });
    //   });