
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>    
        <style>
            @font-face {
                font-family: 'THSarabunNew';
                src: url('fonts/thsarabunnew-webfont.eot');
                src: url('fonts/thsarabunnew-webfont.eot?#iefix') format('embedded-opentype'),
                    url('fonts/thsarabunnew-webfont.woff') format('woff'),
                    url('fonts/thsarabunnew-webfont.ttf') format('truetype');
                font-weight: normal;
                font-style: normal;    
            }            
            @font-face {
                font-family: 'THSarabunNew';
                src: url('fonts/thsarabunnew_bolditalic-webfont.eot');
                src: url('fonts/thsarabunnew_bolditalic-webfont.eot?#iefix') format('embedded-opentype'),
                    url('fonts/thsarabunnew_bolditalic-webfont.woff') format('woff'),
                    url('fonts/thsarabunnew_bolditalic-webfont.ttf') format('truetype');
                font-weight: bold;
                font-style: italic;    
            }    
            @font-face {
                font-family: 'THSarabunNew';
                src: url('fonts/thsarabunnew_italic-webfont.eot');
                src: url('fonts/thsarabunnew_italic-webfont.eot?#iefix') format('embedded-opentype'),
                    url('fonts/thsarabunnew_italic-webfont.woff') format('woff'),
                    url('fonts/thsarabunnew_italic-webfont.ttf') format('truetype');
                font-weight: normal;
                font-style: italic;    
            }    
            @font-face {
                font-family: 'THSarabunNew';
                src: url('fonts/thsarabunnew_bold-webfont.eot');
                src: url('fonts/thsarabunnew_bold-webfont.eot?#iefix') format('embedded-opentype'),
                    url('fonts/thsarabunnew_bold-webfont.woff') format('woff'),
                    url('fonts/thsarabunnew_bold-webfont.ttf') format('truetype');
                font-weight: bold;
                font-style: normal;    
            }   
            body {
                font-family: 'THSarabunNew', sans-serif;
                font-size: 13px;
               line-height: 1;                
            }   
            table, th, td {
            border: 1px solid rgb(253, 253, 253);
            }   
            .text-pedding{
            padding-left:10px;
            padding-right:10px;
            }                     
            .table{
                border-collapse: collapse;  //กรอบด้านในหายไป
            }
            .page-break {
                page-break-after: always;
            }                
        </style>    
        <?php    
            function DateThaimount($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
    
            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
            $strMonthThai=$strMonthCut[$strMonth];
            return thainumDigit($strMonthThai);
            }            
            function DateThaifrom($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));
    
            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
            $strMonthThai=$strMonthCut[$strMonth];
            return thainumDigit($strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear);
            }    
            $date = date('Y-m-d');    
            function timefor($strtime)
                {
                $H = substr($strtime,10,6);
                return $H;
                }
        ?>    
    </head>
    
    <body>
    
    <center>
        <B style="font-size: 14px;">ใบแจ้งซ่อม</B>
        <br>
        <B style="font-size: 13px;">{{$info_orgs->ORG_NAME}}</B>
    </center><br>  
    <table  width="100%">
        <tr>          
            <td width="50%" >
                หน่วยงานผู้แจ้งซ่อม&nbsp; {{$informrepair_indexs->HR_DEPARTMENT_SUB_SUB_NAME}}
            </td>
            <td width="40%" >
                เบอร์โทร&nbsp;{{$informrepair_indexs->HR_PHONE}}
            </td>
        </tr>           
    </table>     
    <hr> 
    <table  width="100%">
        <tr>          
            <td width="40%" >
                ส่วนที่ 1 ผู้แจ้ง	เลขที่ : &nbsp; {{$informrepair_indexs->REPAIR_ID}}
            </td>
            <td width="30%" >
                วันที่: &nbsp;{{DateThai($informrepair_indexs->DATE_TIME_REQUEST)}}
            </td>
            <td width="30%" >
                เวลา:&nbsp;{{timefor($informrepair_indexs->DATE_TIME_REQUEST)}}
            </td>
        </tr>           
    </table>  
    <table  width="100%">
        <tr>          
            <td width="35%" >
                แจ้งซ่อม : &nbsp; {{$informrepair_indexs->REPAIR_NAME}}
            </td>            
            <td width="65%" >
                ยี่ห้อ/รุ่น : &nbsp; {{$informrepair_indexs->BRAND_NAME}} /&nbsp; {{$informrepair_indexs->MODEL_NAME}}
            </td>
        </tr>  
        <tr>          
            <td width="100%" >
                หมายเลขคุรุภัณฑ์ : &nbsp; {{$informrepair_indexs->ARTICLE_NUM}}
            </td> 
        </tr>  
        <tr>          
            <td width="100%" >
                อาการ : &nbsp; {{$informrepair_indexs->SYMPTOM}}
            </td> 
        </tr>           
    </table>
    <table  width="100%">
        <tr>          
            <td width="40%" > 
            </td>            
            <td width="60%" >
                <input class="form-check-input" type="checkbox" id="check1" name="option1" value="something" >
                &nbsp; &nbsp; รับทราบ
            </td>
        </tr>           
    </table> 
    <table  width="100%">
        <tr>          
            <td width="20%" >               
            </td> 
            <td width="40%" >
                ผู้แจ้งซ่อม  
            </td>            
            <td width="30%" >
               หัวหน้าฝ่ายงาน
            </td>
        </tr>  
    </table> 
    <table  width="100%">       
        <tr>          
            <td width="10%" >               
            </td> 
            <td width="40%" >
                (&nbsp; {{$informrepair_indexs->USRE_REQUEST_NAME}} &nbsp;) 
            </td>            
            <td width="30%" >
                (&nbsp; {{$headdeps->HR_FNAME}} &nbsp;&nbsp; {{$headdeps->HR_LNAME}} &nbsp;) 
            </td>
        </tr>           
    </table> 
    <table  width="100%">       
        <tr>          
            <td width="7%" >               
            </td> 
            <td width="50%" >
                ตำแหน่ง &nbsp; {{$informrepair_indexs->POSITION_IN_WORK}} &nbsp; 
            </td>            
            <td width="40%" >
                ตำแหน่ง &nbsp; {{$headdeps->POSITION_IN_WORK}} &nbsp; 
            </td>
        </tr>           
    </table> 
    <hr> 
    <table  width="100%">
        <tr>          
            <td width="40%" >
                ส่วนที่ 2 งานซ่อมบำรุง	เลขที่ : &nbsp; {{$informrepair_indexs->REPAIR_ID}} 
            </td>
            <td width="30%" >
                วันที่ : &nbsp;{{DateThai($informrepair_indexs->TECH_RECEIVE_DATE)}}
            </td>
            <td width="30%" >
                เวลา : &nbsp;{{$informrepair_indexs->TECH_RECEIVE_TIME}}
            </td>
        </tr>           
    </table>  
    <table  width="100%">
        <tr>          
            <td width="5%" >           
            </td>
            <td width="10%" >
                ความเร่งด่วน &nbsp; 
            </td>
            
                @if ($informrepair_indexs->PRIORITY_ID == '1')
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ปกติ
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วน
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนมาก
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนที่สุด
                        </label>
                    </td>
                @elseif ($informrepair_indexs->PRIORITY_ID == '2')
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ปกติ
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วน
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนมาก
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนที่สุด
                        </label>
                    </td>
                @elseif ($informrepair_indexs->PRIORITY_ID == '3')
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked">
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ปกติ
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วน
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนมาก
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนที่สุด
                        </label>
                    </td>
                @else
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ปกติ
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วน
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนมาก
                        </label>
                    </td>
                    <td width="10%" > 
                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                        <label class="form-check-label" for="flexCheckChecked">
                            &nbsp;&nbsp;ด่วนที่สุด
                        </label>
                    </td>
                @endif
               
        </tr>           
    </table> 
    <table  width="100%">
        <tr>          
            <td width="100%" >
                รายละเอียดการตรวจซ่อมที่พบ/ความเห็นของช่าง
            </td>           
        </tr> 
        <tr>          
            <td width="100%" >
                รายการวัสดุอุปกรณ์ที่ใช้
            </td>           
        </tr>                   
    </table> 
    <table  width="100%">
        <tr>          
            <td width="15%" >
                สถานะการซ่อม &nbsp;&nbsp;  
            </td>  
            <td width="85%" >
                1. (  ) ซ่อมได้ พร้อมส่งคืนหน่วยงาน วันที่.....................................  ผู้รับของ........................................              
            </td>          
        </tr> 
    </table>  
    <table  width="100%">
        <tr>          
            <td width="15%" >
                &nbsp;&nbsp;
            </td>  
            <td width="85%" >
                2. (  ) ส่งซ่อมภายนอก  
            </td>          
        </tr>  
    </table>  
    <table  width="100%">
        <tr>          
            <td width="20%" >
                
            </td>  
            <td width="80%" >
                ชื่อร้าน/บริษัท&nbsp;&nbsp;{{$informrepair_indexs->OUTSIDE_SHOP}}
            </td>          
        </tr> 
        <tr>          
            <td width="20%" >
                
            </td>  
            <td width="80%" >
                รายการอุปกรณ์ที่ส่ง &nbsp;&nbsp;{{$informrepair_indexs->OUTSIDE_TOOL}}
            </td>          
        </tr> 
    </table>  
    <table  width="100%">
        <tr>          
            <td width="20%" >
                &nbsp;&nbsp;
            </td>  
            <td width="80%" >
                วันที่ &nbsp;&nbsp;{{DateThai($informrepair_indexs->REPAIR_DATE)}} &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ผู้รับ&nbsp;&nbsp;{{$informrepair_indexs->OUTSIDE_EMP}}           
            </td>          
        </tr>  
    </table>  
    <table  width="100%">
        <tr>          
            <td width="15%" >
                &nbsp;&nbsp;
            </td>  
            <td width="85%" >
                3. (  ) รอจัดซื้อวัสดุ          
            </td>          
        </tr>  
    </table>   
    <table  width="100%">
        <tr>          
            <td width="15%" >
                &nbsp;&nbsp;
            </td>  
            <td width="85%" >
                4. (  ) รอจำหน่ายเนื่องจาก.................................................................................................................................          
            </td>          
        </tr>  
    </table>  
    <table  width="100%">
        <tr>          
            <td width="18%" >                
            </td>  
            <td width="20%" >
                ช่างแจ้งหน่วยงานที่แจ้ง        
            </td> 
            <td width="30%" >
                วันที่.....................................      
            </td> 
            <td width="30%" >
                ผู้รับเรื่อง........................................      
            </td>          
        </tr> 
    </table> 
    <br>    
    <table  width="100%">
        <tr>          
            <td width="50%" >                
            </td> 
            <td width="50%" >
                @if ($informrepair_indexs->TECH_RECEIVE_NAME == '' )
                    ( &nbsp;...............................................&nbsp;)
                 @else
                    ( &nbsp;{{$informrepair_indexs->TECH_RECEIVE_NAME}} &nbsp;)
                @endif
                 <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ตรวจสอบ/ซ่อมบำรุง     
            </td>                    
        </tr> 
    </table>  

    <br><br>

    <table  width="100%">
        <tr>  
            <td width="50%" >
                ( &nbsp;&nbsp; ) เพื่อโปรดพิจารณา      <br>
                ( &nbsp;&nbsp; ) อื่น ๆ ระบุ................................
            </td>  
            <td width="50%" > <br>
                &nbsp;&nbsp;&nbsp;( &nbsp;&nbsp; ) อนุมัติ &nbsp;&nbsp;  ( &nbsp;&nbsp; ) ไม่อนุมัติ......................
            </td>         
        </tr> 
    </table>  
    <table  width="100%">
        <tr>  
            <td width="5%" >               
            </td> 
            <td width="45%" >
                <br> <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ...............................................)
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp; {{$headbigdeps->HR_FNAME}} &nbsp;&nbsp; {{$headbigdeps->HR_LNAME}} &nbsp;) <br>
               นายแพทย์ชำนาญการพิเศษ รักษาการในตำแหน่ง  <br>
               &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;หัวหน้ากลุ่มงานบริหารทั่วไป
           </td> 
           <td width="50%" >   <br> <br>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( ...............................................) <br>          
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;( &nbsp; {{$info_orgs->HR_FNAME}} &nbsp;&nbsp; {{$info_orgs->HR_LNAME}} &nbsp; ) <br>
            &nbsp;&nbsp;&nbsp;&nbsp;นายแพทย์ชำนาญการพิเศษ  รักษาการในตำแหน่ง<br>
            ผู้อำนวยการ {{$info_orgs->ORG_NAME}} 
       </td>         
        </tr> 
    </table> 
    <br>    
    <hr>
    <table  width="100%">
        <tr>          
            <td width="100%" >
                ส่วนที่ 3 ส่งมอบงาน
            </td>          
        </tr>           
    </table> 
    <table  width="100%">
        <tr>          
            <td width="6%" >
            </td> 
            <td width="94%" >
                &nbsp;ช่างได้รับเครื่อง/อุปกรณ์/อะไหล่ พร้อมทำการตรวจซ่อมและส่งคืนหน่วยงาน ......................................................................
            </td>          
        </tr>   
        <tr>          
            <td width="6%" >
            </td> 
            <td width="94%" >
                &nbsp;วันที่ .............................................. ผู้รับเครื่องอุปกรณ์คืน ..............................................................................
            </td>          
        </tr> 
        <br><br>             
    </table> 
    <br><br><br>
    <table  width="100%">       
        <tr>          
            <td width="6%" >
            </td> 
            <td width="94%" >
                @if ($informrepair_indexs->TECH_RECEIVE_NAME == '' )
                        ( &nbsp;...............................................&nbsp;)
                @else
                        ( &nbsp;{{$informrepair_indexs->TECH_RECEIVE_NAME}} &nbsp;)
                @endif
              
            </td>          
        </tr>  
        <tr>          
            <td width="6%" >
            </td> 
            <td width="94%" >
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ผู้ตรวจสอบ/ซ่อมบำรุง
            </td>          
        </tr>        
    </table> 

    </body>
    </html>
 