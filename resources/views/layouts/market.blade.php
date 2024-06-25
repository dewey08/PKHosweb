<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="shortcut icon" href="{{ asset('assets/images/logoZoffice2.ico') }}">
     
    <link href="{{ asset('css/fullcalendar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="{{ asset('assets/fontawesome/css/all.css') }}" rel="stylesheet">   
    <link href="{{ asset('css/tablebook.css') }}" rel="stylesheet">
    <script src="{{ asset('lib/webviewer.min.js') }}"></script>
  
      <!-- MDB -->
      <link rel="stylesheet" href="{{ asset('assets/css/mdb.min.css') }}" />
      <link href="{{ asset('css/fontuser.css') }}" rel="stylesheet">
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> 

  </head>
<style>
   
    .bd-placeholder-img {
      font-size: 1.125rem;
      text-anchor: middle;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
    }

    @media (min-width: 768px) {
      .bd-placeholder-img-lg {
        font-size: 3.5rem;
      }
    }

    .b-example-divider {
      height: 3rem;
      background-color: rgba(0, 0, 0, .1);
      border: solid rgba(0, 0, 0, .15);
      border-width: 1px 0;
      box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
    }
    .bg-head{
        background-color: #8f87fc;
    color: #ffffff;
    }

    .b-example-vr {
      flex-shrink: 0;
      width: 1.5rem;
      height: 100vh;
    }

    .bi {
      vertical-align: -.125em;
      fill: currentColor;
    }

    .nav-scroller {
      position: relative;
      z-index: 2;
      height: 2.75rem;
      overflow-y: hidden;
    }

    .nav-scroller .nav {
      display: flex;
      flex-wrap: nowrap;
      padding-bottom: 1rem;
      margin-top: -1px;
      overflow-x: auto;
      text-align: center;
      white-space: nowrap;
      -webkit-overflow-scrolling: touch;
    }
  
    .dataTables_wrapper   .dataTables_filter{
            float: right 
          }

        .dataTables_wrapper  .dataTables_length{
                float: left 
        }
        .dataTables_info {
                float: left;
        }
        .dataTables_paginate{
                float: right
        }
        .custom-tooltip {
            --bs-tooltip-bg: var(--bs-primary);
      
    }
  </style>
<body>
  
       <div id="app">
        <div class="px-3 py-2 bg-secondary text-white">
            <div class="container">
              <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
                <a href="{{url('staff/home')}}" class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-white text-decoration-none">
                  <!-- <img src="{{ asset('assets/images/logoZoffice.png') }}" alt="logo-dark" height="80">  -->
                  <label for="" style="color: white;font-size:45px">Z-</label>
                  <label for="" style="color: rgb(250, 120, 33);font-size:45px">Mar</label>
                  <label for="" style="color: rgb(33, 181, 250);font-size:45px">Ket</label>
                </a>
                
      
                <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0 text-small">
                    
                     <li>
                    <a href="{{url("/home")}}" class="nav-link text-white text-center"> 
                      <i class="fa-solid fa-2x fa-house-chimney text-white"></i>
                      <br>
                      หน้าหลัก
                    </a>
                  </li> 
                  <li>
                    <a href="{{url("staff/home")}}" class="nav-link text-white position-relative text-center">
                      <i class="fa-solid fa-2x fa-envelope text-white"></i>
                      <span class="position-absolute top-0 start-70 translate-middle badge rounded-pill bg-danger">2 <span class="visually-hidden">unread messages</span></span>
                      <br>
                      ข้อความ
                    </a>
                  </li>
                
                 
                        @guest
                        @if (Route::has('login'))
                            <li class="nav-item text-white">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item text-white">
                                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown ">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle text-white text-center" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                             
                              <i class="fa-solid fa-2x fa-user-tie text-white "></i><br>
                              {{ Auth::user()->fname }}   {{ Auth::user()->lname }}
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                  onclick="event.preventDefault();
                                                document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>                
              </div>
            </div>
          </div>
          
          @yield('menu')

            </div>
          </div>

        <main class="py-3">
            @yield('content')
        </main>
    </div>

    <script src="{{ asset('assets/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script> 
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <!-- MDB -->
    <script type="text/javascript" src="{{ asset('assets/js/mdb.min.js') }}"></script> 
    <script type="text/javascript" src="{{ asset('fullcalendar/lib/moment.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/fullcalendar.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('fullcalendar/lang/th.js') }}"></script>


    <script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('js/dataTables.bootstrap5.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   
    @yield('footer')
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
<script>


  function onScanSuccess(decodedText, decodedResult) {
  // handle the scanned code as you like, for example:
  console.log(`Code matched = ${decodedText}`, decodedResult);

  $("#myInput").val(decodedText)
}

function onScanFailure(error) {
  // handle scan failure, usually better to ignore and keep scanning.
  // for example:
  console.warn(`Code scan error = ${error}`);
}

let html5QrcodeScanner = new Html5QrcodeScanner(
  "reader",
  { fps: 10, qrbox: {width: 300, height: 150} },
  /* verbose= */ false);
html5QrcodeScanner.render(onScanSuccess, onScanFailure);
</script>
<script type="text/javascript">

    $(document).ready(function () {

                $('#scanner').val('');  // Input field should be empty on page load
                $('#scanner').focus();  // Input field should be focused on page load 

                $('html').on('click', function () {
                    $('#scanner').focus();  // Input field should be focused again if you click anywhere
                });

                $('html').on('blur', function () {
                    $('#scanner').focus();  // Input field should be focused again if you blur
                });

                $('#scanner').change(function () {

                    if ($('#scanner').val() == '') {
                        return;  // Do nothing if input field is empty
                    }

                    // $.ajax({
                    //     url: '/scan/save',
                    //     cache: false,
                    //     type: 'GET',
                    //     data: {
                    //         user_id: $('#scanner').val()
                    //     },
                    //     success: function (response) {
                    //         $('#scanner').val('');
                    //     }
                    // });
                });
    });


    $(document).ready(function () {
        $('#example').DataTable();
        $('#example2').DataTable();
              
        $('#product_categoryid').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#product_unit_bigid').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#product_unit_subid').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#request_year').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });
        $('#request_vendor_id').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });   
        $('#customer_pname').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });   
        $('#request_sub_unitid').select2({
            placeholder:"--เลือก--",
            allowClear:true
        }); 
        $('#request_sub_product_id').select2({
            placeholder:"--เลือก--",
            allowClear:true
        });   
    });


    $(document).ready(function(){
        $.ajaxSetup({
             headers: {
                 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
        });

        $('#save_productForm').on('submit',function(e){
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
                      title: 'บันทึกข้อมูลสำเร็จ',
                      text: "You Insert data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177',
                      // cancelButtonColor: '#d33',
                      confirmButtonText: 'เรียบร้อย'
                    }).then((result) => {
                      if (result.isConfirmed) {                  
                        window.location="{{url('market/product_index')}}";
                      }
                    })      
                  }
                }
              });
        });

        $('#update_productForm').on('submit',function(e){
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
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {  
                          window.location="{{url('market/product_index')}}";
                        }
                      })      
                    }
                  }
                });
        });

        $('#insert_repForm').on('submit',function(e){
              e.preventDefault(); 
              var id = $("#refmaxid").val(); 
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
                      title: 'เพิ่มรายการสินค้า',
                      text: "You next step",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177', 
                      confirmButtonText: 'ต่อไป'
                    }).then((result) => {
                      if (result.isConfirmed) {                  
                        window.location="{{url('market/rep_product_addsub')}}" +'/'+ id; 
                      }
                    })      
                  }
                }
              });
        });
        $('#update_repForm').on('submit',function(e){
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
                        confirmButtonText: 'เรียบร้อย'
                      }).then((result) => {
                        if (result.isConfirmed) {  
                          window.location="{{url('market/rep_product')}}";
                        }
                      })      
                    }
                  }
                });
        });

        $('#save_customerForm').on('submit',function(e){
              e.preventDefault(); 
              // var id = $("#refmaxid").val(); 
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
                      title: 'บันทึกข้อมูลสำเร็จ',
                      text: "You Insert data success",
                      icon: 'success',
                      showCancelButton: false,
                      confirmButtonColor: '#06D177', 
                      confirmButtonText: 'ต่อไป'
                    }).then((result) => {
                      if (result.isConfirmed) {                  
                        window.location="{{url('customer/customer')}}" ; 
                      }
                    })      
                  }
                }
              });
        });
        $('#update_customerForm').on('submit',function(e){
              e.preventDefault(); 
              // var id = $("#refmaxid").val(); 
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
                      confirmButtonText: 'ต่อไป'
                    }).then((result) => {
                      if (result.isConfirmed) {                  
                        window.location="{{url('customer/customer')}}" ; 
                      }
                    })      
                  }
                }
              });
        });

        $('#saveBtn').click(function() {
          // alert('ooo');
          var product_id = $('#product_id').val();
          var product_qty = $('#product_qty').val();
          var product_price = $('#product_price').val();
           alert(product_id);
          $.ajax({
              url: "{{ route('mar.sale_save') }}",
              type: "POST",
              dataType: 'json',
              data: {
                product_id,
                product_qty,
                product_price
              },
              success: function(response) {
                  if (response.status == 0) {
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
                          if (result
                              .isConfirmed) {                              
                              window.location.reload();
                          }
                      })
                  }
              },                                
          });

        });
    });

    function addvendor() {
        var vennew = document.getElementById("VEN_INSERT").value;
        // alert(vennew);
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{url('market/addvendor')}}",
            method: "GET",
            data: {
              vennew: vennew,
                _token: _token
            },
            success: function (result) {
                $('.shwo_ven').html(result);
            }
        })
    }

    function addcategory() {
        var catnew = document.getElementById("CAT_INSERT").value;
        // alert(catnew);
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{url('market/addcategory')}}",
            method: "GET",
            data: {
              catnew: catnew,
                _token: _token
            },
            success: function (result) {
                $('.show_cat').html(result);
            }
        })
    }

    function addunit() {
        var unitnew = document.getElementById("UNIT_INSERT").value;
        // alert(unitnew);
        var _token = $('input[name="_token"]').val();
        $.ajax({
            url: "{{url('article/addunit')}}",
            method: "GET",
            data: {
              unitnew: unitnew,
                _token: _token
            },
            success: function (result) {
                $('.show_unit').html(result);
            }
        })
    }

    function addbrand() {
        var brandnew = document.getElementById("BRAND_INSERT").value; 
        var _token = $('input[name="_token"]').val();
        $.ajax({ 
            url: "{{url('article/addbrand')}}",
            method: "GET",
            data: {
              brandnew: brandnew,
                _token: _token
            },
            success: function (result) {
                $('.show_brand').html(result);
            }
        })
    }

    function addpic(input) {
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

    function editpic(input) {
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

</script>

<script>
  function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
            b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;
      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
          x[i].parentNode.removeChild(x[i]);
        }
      }
    }
    /*execute a function when someone clicks in the document:*/
    document.addEventListener("click", function (e) {
        closeAllLists(e.target);
    });
  }
  
  /*An array containing all the country names in the world:*/
  var countries = ["Afghanistan","Albania","Algeria","Andorra","Angola","Anguilla","Antigua & Barbuda","Argentina","Armenia","Aruba","Australia","Austria","Azerbaijan","Bahamas","Bahrain","Bangladesh","Barbados","Belarus","Belgium","Belize","Benin","Bermuda","Bhutan","Bolivia","Bosnia & Herzegovina","Botswana","Brazil","British Virgin Islands","Brunei","Bulgaria","Burkina Faso","Burundi","Cambodia","Cameroon","Canada","Cape Verde","Cayman Islands","Central Arfrican Republic","Chad","Chile","China","Colombia","Congo","Cook Islands","Costa Rica","Cote D Ivoire","Croatia","Cuba","Curacao","Cyprus","Czech Republic","Denmark","Djibouti","Dominica","Dominican Republic","Ecuador","Egypt","El Salvador","Equatorial Guinea","Eritrea","Estonia","Ethiopia","Falkland Islands","Faroe Islands","Fiji","Finland","France","French Polynesia","French West Indies","Gabon","Gambia","Georgia","Germany","Ghana","Gibraltar","Greece","Greenland","Grenada","Guam","Guatemala","Guernsey","Guinea","Guinea Bissau","Guyana","Haiti","Honduras","Hong Kong","Hungary","Iceland","India","Indonesia","Iran","Iraq","Ireland","Isle of Man","Israel","Italy","Jamaica","Japan","Jersey","Jordan","Kazakhstan","Kenya","Kiribati","Kosovo","Kuwait","Kyrgyzstan","Laos","Latvia","Lebanon","Lesotho","Liberia","Libya","Liechtenstein","Lithuania","Luxembourg","Macau","Macedonia","Madagascar","Malawi","Malaysia","Maldives","Mali","Malta","Marshall Islands","Mauritania","Mauritius","Mexico","Micronesia","Moldova","Monaco","Mongolia","Montenegro","Montserrat","Morocco","Mozambique","Myanmar","Namibia","Nauro","Nepal","Netherlands","Netherlands Antilles","New Caledonia","New Zealand","Nicaragua","Niger","Nigeria","North Korea","Norway","Oman","Pakistan","Palau","Palestine","Panama","Papua New Guinea","Paraguay","Peru","Philippines","Poland","Portugal","Puerto Rico","Qatar","Reunion","Romania","Russia","Rwanda","Saint Pierre & Miquelon","Samoa","San Marino","Sao Tome and Principe","Saudi Arabia","Senegal","Serbia","Seychelles","Sierra Leone","Singapore","Slovakia","Slovenia","Solomon Islands","Somalia","South Africa","South Korea","South Sudan","Spain","Sri Lanka","St Kitts & Nevis","St Lucia","St Vincent","Sudan","Suriname","Swaziland","Sweden","Switzerland","Syria","Taiwan","Tajikistan","Tanzania","Thailand","Timor L'Este","Togo","Tonga","Trinidad & Tobago","Tunisia","Turkey","Turkmenistan","Turks & Caicos","Tuvalu","Uganda","Ukraine","United Arab Emirates","United Kingdom","United States of America","Uruguay","Uzbekistan","Vanuatu","Vatican City","Venezuela","Vietnam","Virgin Islands (US)","Yemen","Zambia","Zimbabwe"];
 
  // var pro =  
  /*initiate the autocomplete function on the "myInput" element, and pass along the countries array as possible autocomplete values:*/
  autocomplete(document.getElementById("myInput"), countries);
  </script>

</body>
</html>
