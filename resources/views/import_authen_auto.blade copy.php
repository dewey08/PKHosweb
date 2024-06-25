@extends('layouts.authenthemes')
@section('title', 'PK-OFFICER || Authen Code')
@section('content')
 
<script language="JavaScript">
    var HttPRequest = false;

    function doCallAjax(Sort) {
       HttPRequest = false;
       if (window.XMLHttpRequest) { // Mozilla, Safari,...
          HttPRequest = new XMLHttpRequest();
          if (HttPRequest.overrideMimeType) {
             HttPRequest.overrideMimeType('text/html');
          }
       } else if (window.ActiveXObject) { // IE
          try {
             HttPRequest = new ActiveXObject("Msxml2.XMLHTTP");
          } catch (e) {
             try {
                HttPRequest = new ActiveXObject("Microsoft.XMLHTTP");
             } catch (e) {}
          }
       }        
       if (!HttPRequest) {
          alert('Cannot create XMLHTTP instance');
          return false;
       } 
         var url = '{{url('authen_realtime')}}';
         var pmeters = 'mySort='+Sort;
         HttPRequest.open('POST',url,true);

         HttPRequest.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
         HttPRequest.setRequestHeader("Content-length", pmeters.length);
         HttPRequest.setRequestHeader("Connection", "close");
         HttPRequest.send(pmeters);
                  
         HttPRequest.onreadystatechange = function()
         {
              if(HttPRequest.readyState == 3)  // Loading Request
               {
                document.getElementById("mySpan").innerHTML = "Now is Loading...";
               }

              if(HttPRequest.readyState == 4) // Return Request
               {
                document.getElementById("mySpan").innerHTML = HttPRequest.responseText;
               }
             
         }

    }
 </script>
<body Onload="bodyOnload();">

    <form name="frmMain" action="" method="post">
        <script language="JavaScript">
    
            function bodyOnload()
            {
                  doCallAjax('CustomerID')
                  setTimeout("doLoop();",60000);
            }
         
            function doLoop()
            {
                  bodyOnload();
            }
        </script>
    
    <span id="mySpan"></span>
    </body>   
@endsection
@section('footer')
 

    
 
@endsection
 
 