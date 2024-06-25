// $(document).on('click','.edit_line',function(){
//   var line_token_id = $(this).val();
//   // alert(line_token_id);
//   $('#linetokenModal').modal('show');
//   $.ajax({
//     type: "GET", 
//     url: "/setting/line_token_edit/"+ line_token_id,  //ทำในคอมตัวเอง
//     success: function(data) {
//         console.log(data.line_token.line_token_name);
//         $('#line_token_name').val(data.line_token.line_token_name)  
//         $('#line_token_code').val(data.line_token.line_token_code) 
//         $('#line_token_id').val(data.line_token.line_token_id)                
//     },      
// });
 
// });

// alert('jjjjj');
// $(document).ready(function(){
//   alert('jjjjjdddddddddd');
// });

          // $('#book_updateForm').on('submit',function(e){
          //   e.preventDefault();  
          //   var form = this;
          //   // alert('OJJJJOL');
          //   $.ajax({
          //     url:$(form).attr('action'),
          //     method:$(form).attr('method'),
          //     data:new FormData(form),
          //     processData:false,
          //     dataType:'json',
          //     contentType:false,
          //     beforeSend:function(){
          //       $(form).find('span.error-text').text('');
          //     },
          //     success:function(data){
          //       if (data.status == 200 ) {
          //           Swal.fire({
          //             title: 'แก้ไขข้อมูลสำเร็จ',
          //             text: "You edit data success",
          //             icon: 'success',
          //             showCancelButton: false,
          //             confirmButtonColor: '#06D177',
          //             // cancelButtonColor: '#d33',
          //             confirmButtonText: 'เรียบร้อย'
          //           }).then((result) => {
          //             if (result.isConfirmed) { 
          //               // window.location.reload(); 
          //               // window.location = "/book/bookmake_index"; // กรณี add page new  
          //               window.location.href = "{{url('bookmake_index')}}";
          //               // http://dekbanbanproject.com/PK-BACKOFFice/public/book/bookmake_index
          //               // "http://www.code-father.com/member.php";
          //               // window.location.href = "http://dekbanbanproject.com/PK-BACKOFFice/public/book/bookmake_index";
          //             }
          //           })      
          //       } else {          
                
          //       }
          //     }
          //   });
          // });
            



$(document).ready(function(){



//             $('#insert_commentForm').on('submit',function(e){
//               e.preventDefault();

//               var form = this;
//               // alert('OJJJJOL');
//               $.ajax({
//                 url:$(form).attr('action'),
//                 method:$(form).attr('method'),
//                 data:new FormData(form),
//                 processData:false,
//                 dataType:'json',
//                 contentType:false,
//                 beforeSend:function(){
//                   $(form).find('span.error-text').text('');
//                 },
//                 success:function(data){
//                   if (data.status == 0 ) {
                    
//                   } else {          
//                     Swal.fire({
//                       title: 'แก้ไขข้อมูลสำเร็จ',
//                       text: "You Update data success",
//                       icon: 'success',
//                       showCancelButton: false,
//                       confirmButtonColor: '#06D177',
//                       // cancelButtonColor: '#d33',
//                       confirmButtonText: 'เรียบร้อย'
//                     }).then((result) => {
//                       if (result.isConfirmed) {                  
//                         window.location.reload(); 
//                       }
//                     })      
//                   }
//                 }
//               });
//             });


          
//             $('#insert_depForm').on('submit',function(e){
//               e.preventDefault();  
//               var form = this;
//             //   alert('OJJJJOL');
//               $.ajax({
//                 url:$(form).attr('action'),
//                 method:$(form).attr('method'),
//                 data:new FormData(form),
//                 processData:false,
//                 dataType:'json',
//                 contentType:false,
//                 beforeSend:function(){
//                   $(form).find('span.error-text').text('');
//                 },
//                 success:function(data){
//                   if (data.status == 0 ) {
                    
//                   } else {          
//                     Swal.fire({
//                       title: 'บันทึกข้อมูลสำเร็จ',
//                       text: "You Insert data success",
//                       icon: 'success',
//                       showCancelButton: false,
//                       confirmButtonColor: '#06D177',
//                       // cancelButtonColor: '#d33',
//                       confirmButtonText: 'เรียบร้อย'
//                     }).then((result) => {
//                       if (result.isConfirmed) {                  
//                         window.location="/setting/setting_index"; //
//                       }
//                     })      
//                   }
//                 }
//               });
//             });
          
//             $('#update_depForm').on('submit',function(e){
//               e.preventDefault();  
//               var form = this;
//               // alert('OJJJJOL');
//               $.ajax({
//                 url:$(form).attr('action'),
//                 method:$(form).attr('method'),
//                 data:new FormData(form),
//                 processData:false,
//                 dataType:'json',
//                 contentType:false,
//                 beforeSend:function(){
//                   $(form).find('span.error-text').text('');
//                 },
//                 success:function(data){
//                   if (data.status == 0 ) {
                    
//                   } else {          
//                     Swal.fire({
//                       title: 'แก้ไขข้อมูลสำเร็จ',
//                       text: "You edit data success",
//                       icon: 'success',
//                       showCancelButton: false,
//                       confirmButtonColor: '#06D177',
//                       // cancelButtonColor: '#d33',
//                       confirmButtonText: 'เรียบร้อย'
//                     }).then((result) => {
//                       if (result.isConfirmed) { 
                                        
//                         window.location = "/setting/setting_index"; // กรณี add page new  
//                       }
//                     })      
//                   }
//                 }
//               });
//             });

            $('#signature_saveForm').on('submit',function(e){
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
                        // window.location="/building/building_index"; //
                      }
                    })      
                  }
                }
              });
          });
        });
//           $('#book_saveForm').on('submit',function(e){
//             e.preventDefault();  
//             var form = this;
//             // var orginfo_link = $(this).val(); 
//             // alert(orginfo_link);
//             $.ajax({
//               url:$(form).attr('action'),
//               method:$(form).attr('method'),
//               data:new FormData(form),
//               processData:false,
//               dataType:'json',
//               contentType:false,
//               beforeSend:function(){
//                 $(form).find('span.error-text').text('');
//               },
//               success:function(data){
//                 if (data.status == 0 ) {
                  
//                 } else {          
//                   Swal.fire({
//                     title: 'บันทึกข้อมูลสำเร็จ',
//                     text: "You Insert data success",
//                     icon: 'success',
//                     showCancelButton: false,
//                     confirmButtonColor: '#06D177',
//                     // cancelButtonColor: '#d33',
//                     confirmButtonText: 'เรียบร้อย'
//                   }).then((result) => {
//                     if (result.isConfirmed) {   
//                       // window.location.replace('{{route("book-bookmake_index"}}');
//                         // window.location = '{{ url("book-bookmake_index" ) }}';      
//                         // window.location.href = path; //         
//                       // window.location="/book/bookmake_index"; //{{ asset('js/gcpdfviewer.js') }}
//                       link == data.link
//                       window.location.href = "{{ asset('book/bookmake_index') }}";
//                       // window.location.href = "http://203.157.231.35/PK-BACKOFFice/public/book/bookmake_index";
//                     }
//                   })      
//                 }
//               }
//             });
//           });


  
  
        //   function settingdep_destroy(DEPARTMENT_ID)
        //   {
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //         url:'/setting/setting_index_destroy/'+DEPARTMENT_ID,
        //         type:'DELETE',
        //         data:{
        //             _token : $("input[name=_token]").val()
        //         },
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+DEPARTMENT_ID).remove();     
        //                 // window.location.reload(); 
        //                 window.location = "/setting/setting_index"; //     
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }

        //   function addtype() {
        //       var bookrep_type = document.getElementById("BOOK_TYPE_INSERT").value;
        //       // alert(bookrep_type);
        //       var _token = $('input[name="_token"]').val();
        //       $.ajax({
        //           url: "/book/addtype",
        //           method: "GET",
        //           data: {
        //             bookrep_type: bookrep_type,
        //               _token: _token
        //           },
        //           success: function (result) {
        //               $('.show_type').html(result);
        //           }
        //       })
        //   }

        //   function addfam() {
        //     var book_fam = document.getElementById("BOOK_FAM_INSERT").value;
        //     // alert(bookrep_type);
        //     var _token = $('input[name="_token"]').val();
        //     $.ajax({
        //         url: "/book/addfam",
        //         method: "GET",
        //         data: {
        //           book_fam: book_fam,
        //             _token: _token
        //         },
        //         success: function (result) {
        //             $('.show_fam').html(result);
        //         }
        //     })
        // }


     

        //   function bookmake_destroy(bookrep_id)
        //   {
        //     alert(bookrep_id);
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({ 
        //         type: "GET",
        //         url:"/bookmake_destroy/"+bookrep_id,
        //         //  dataType:'json',
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+bookrep_id).remove();     
        //                 window.location.reload(); 
        //                 // window.location = "/book/bookmake_index"; //   
                        
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }
        //   function bookdep_destroy(senddep_id)
        //   {
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //         url:'/book/bookmake_senddep_destroy/'+senddep_id,
        //         type:'DELETE',
        //         data:{
        //             _token : $("input[name=_token]").val()
        //         },
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+senddep_id).remove();     
        //                 window.location.reload(); 
        //                 // window.location = "/book/bookmake_index"; //     
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }

        //   function bookdepsub_destroy(senddepsub_id)
        //   {
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //         url:'/book/bookmake_senddepsub_destroy/'+senddepsub_id,
        //         type:'DELETE',
        //         data:{
        //             _token : $("input[name=_token]").val()
        //         },
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+senddepsub_id).remove();     
        //                 window.location.reload(); 
        //                 // window.location = "/book/bookmake_index"; //     
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }
        //   function bookperson_destroy(sendperson_id)
        //   {
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //         url:'/book/bookmake_sendperson_destroy/'+sendperson_id,
        //         type:'DELETE',
        //         data:{
        //             _token : $("input[name=_token]").val()
        //         },
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+sendperson_id).remove();     
        //                 window.location.reload(); 
        //                 // window.location = "/book/bookmake_index"; //     
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }

        //   // function booksendteam_destroy(sendteam_id,bookrep_id)
        //   function booksendteam_destroy(sendteam_id)
        //   {
        //         // alert(bookrep_id);
        //         Swal.fire({
        //         title: 'ต้องการลบใช่ไหม?',
        //         text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonColor: '#3085d6',
        //         cancelButtonColor: '#d33',
        //         confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //         cancelButtonText: 'ไม่, ยกเลิก'
        //         }).then((result) => {
        //         if (result.isConfirmed) {
        //           $.ajax({
        //           url:'/book/bookmake_sendteam_destroy/'+sendteam_id,
        //           type:'DELETE',
        //           data:{
        //               _token : $("input[name=_token]").val()
        //           },
        //           success:function(response)
        //           {          
        //               Swal.fire({
        //                 title: 'ลบข้อมูล!',
        //                 text: "You Delet data success",
        //                 icon: 'success',
        //                 showCancelButton: false,
        //                 confirmButtonColor: '#06D177',
        //                 // cancelButtonColor: '#d33',
        //                 confirmButtonText: 'เรียบร้อย'
        //               }).then((result) => {
        //                 if (result.isConfirmed) {                  
        //                   $("#sid"+sendteam_id).remove();     
        //                   window.location.reload(); 
        //                   // window.location = "/book/bookmake_index_send/"+sendteam_id; //     
        //                 }
        //               }) 
        //           }
        //           })        
        //         }
        //         })
        //   }


        //   function bookrep_file1_destroy(bookrep_id)
        //   {
        //     Swal.fire({
        //     title: 'ต้องการลบใช่ไหม?',
        //     text: "ข้อมูลนี้จะถูกลบไปเลย !!",
        //     icon: 'warning',
        //     showCancelButton: true,
        //     confirmButtonColor: '#3085d6',
        //     cancelButtonColor: '#d33',
        //     confirmButtonText: 'ใช่, ลบเดี๋ยวนี้ !',
        //     cancelButtonText: 'ไม่, ยกเลิก'
        //     }).then((result) => {
        //     if (result.isConfirmed) {
        //         $.ajax({
        //         url:'/book/bookrep_file1_destroy/'+bookrep_id,
        //         type:'DELETE',
        //         data:{
        //             _token : $("input[name=_token]").val()
        //         },
        //         success:function(response)
        //         {          
        //             Swal.fire({
        //               title: 'ลบข้อมูล!',
        //               text: "You Delet data success",
        //               icon: 'success',
        //               showCancelButton: false,
        //               confirmButtonColor: '#06D177',
        //               // cancelButtonColor: '#d33',
        //               confirmButtonText: 'เรียบร้อย'
        //             }).then((result) => {
        //               if (result.isConfirmed) {                  
        //                 $("#sid"+bookrep_id).remove();     
        //                 window.location.reload(); 
        //                 // window.location = "/book/bookmake_index"; //     
        //               }
        //             }) 
        //         }
        //         })        
        //       }
        //       })
        //   }
  
