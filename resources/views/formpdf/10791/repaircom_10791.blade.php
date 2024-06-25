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
                @page {
                        margin: 0cm 0cm;
                            }
                body {
                    font-family: 'THSarabunNew', sans-serif;
                        font-size: 13px;
                    line-height: 0.9;  
                    margin-top:    0.2cm;
                    margin-bottom: 0.2cm;
                    margin-left:   1cm;
                    margin-right:  1cm; 
                }
                #watermark {     
                    position: fixed;
                            bottom:   0px;
                            left:     0px;                   
                            width:    29.5cm;
                            height:   21cm;
                            z-index:  -1000;
                }
                table,td {
                    /* border: 1px solid rgb(255, 255, 255); */
                    }   
                    .text-pedding{
                    /* padding-left:10px;
                    padding-right:10px; */
                    }                     
                    table{
                        border-collapse: collapse;  //กรอบด้านในหายไป
                    }
                    table.one{
                    border: 0.2px solid rgb(5, 5, 5);
                    /* height: 800px; */
                    /* padding: 15px; */
                    }
                    td {
                        margin: .2rem;
                    /* height: 3px; */
                    /* padding: 5px; */
                    /* text-align: left; */
                    }
                    td.o{
                        border: 0.2px solid rgb(5, 5, 5); 
                    }
                    td.b{
                        border: 0.2px solid rgb(255, 255, 255); 
                    }
                    td.d{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 170px;
                    }
                    td.e{
                        border: 0.2px solid rgb(255, 255, 255);
                        
                    }
                    td.h{
                        border: 0.2px solid rgb(5, 5, 5); 
                        height: 10px;
                    }
                    .page-break {
                        page-break-after: always;
                    } 
                    
                    input {
                        margin: .3rem;
                    }
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
    <br>
    <table width="100%">        
        <tr>
          <td rowspan="2" width = "15%">
               <img src="{{ asset('image/Garuda.png') }}" width="50" height="50"> 
          </td>
          <td colspan="5" width = "70%">
            
        </td>
          <td colspan="2" rowspan="2" width = "15%">
           
          </td>
        </tr>
        <tr>
          <td colspan="2" >  <label for="" style="font-size: 19px"><b></b></label>  </td>   
          <td colspan="3" >  <label for="" style="font-size: 19px"><b>บันทึกข้อความ</b></label></td> <br>    
        </tr> 
                   
    </table>
    <table  width="100%">
        <tr>
            <td width="7%"><label for="" style="font-size: 14px"><b>ส่วนราชการ </b></label> </td>
            <td width="30%"><label for="" style="font-size: 13px">&nbsp;&nbsp;&nbsp;{{$informcomrepair->HR_DEPARTMENT_SUB_SUB_NAME}} </label> </td>
            <td width="53%"><label for="" style="font-size: 13px">&nbsp;&nbsp;{{$info_orgs->ORG_NAME}}&nbsp;&nbsp;&nbsp;&nbsp;เบอร์โทร : &nbsp;{{$informcomrepair->HR_PHONE}}</label> </td>
        </tr>       
    </table> 
 <table  width="100%">
    <tr>          
        <td width="2%" >
          <label for="" style="font-size: 14px"><b>ที่</b></label>
        </td>
        <td width="50%" >
            .....................................................................................................................
        </td>
        <td width="20%" >
            &nbsp;&nbsp;วันที่ :&nbsp;&nbsp;&nbsp;{{DateThai($informcomrepair->DATE_SAVE)}}
        </td>
       
        <td width="25%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="50%" >
            <label for="" style="font-size: 14px"><b>เรื่อง </b></label>
            :&nbsp;&nbsp;ขออนุมัติซ่อมแซมครุภัณฑ์คอมพิวเตอร์ 
        </td>
        <td width="50%" >
        </td>
    </tr> 
    <tr>          
        <td width="50%" >
        </td>        
    </tr>  
    <tr>          
        <td width="50%" >
        </td>        
    </tr>          
</table> 
<table  width="100%">
    <tr>          
        <td width="50%" >
           เรียน &nbsp;&nbsp;&nbsp; ผู้อำนวยการ{{$info_orgs->ORG_NAME}}(ผ่านหัวหน้ากลุ่มงาน)      
        </td>
        <td width="50%" >
           
        </td>
    </tr> 
    <tr>          
        <td width="50%" >
         
        </td>        
    </tr>  
    <tr>          
        <td width="50%" >
         
        </td>        
    </tr>          
</table> 

<table  width="100%">
    <tr>          
        <td width="10%" >          
        </td>
        <td width="60%" >
           ด้วยงาน......................................................................................................................
        </td>
        <td width="30%" >
            มีความประสงค์ขอซ่อมแซม ดังนี้
         </td>
    </tr>                 
</table>  

<table  width="100%">
    <tr>          
        <td width="85%" >
            <u><b>หมวดซ่อมครุภัณฑ์คอมพิวเตอร์</b></u>
        </td>      
        <td width="15%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>  
        <td width="15%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">Computer</label>      
        </td>      
        <td width="13%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">Printer</label>
       
        </td>
        <td width="17%" >            
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">เครื่องสำรองไฟ</label>           
        </td>
        <td width="15%" > 
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">จอ Monitor</label>
        </td>  
        <td width="20%" > 
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">เพิ่มจุดสัญญาณ Lan</label>
        </td> 
        <td width="15%" > 
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ระบบ HOSxP</label>
        </td>     
        <td width="5%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>          
        <td width="100%" >          
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">อื่น ฯ....................................................................................................................................................................................................</label>      
           
           {{-- รายละเอียดการตรวจซ่อมที่พบ/ความเห็นของช่าง : {{$informcomrepair->REPAIR_COMMENT}} --}}
        </td> 
    </tr> 
    <tr>          
        <td width="100%" >
            หมายเลขครุภัณฑ์ :&nbsp;{{$informcomrepair->ARTICLE_NUM}}
        </td> 
    </tr>  
</table> 
<table width="100%">
    <tr>          
        <td width="100%" >
           สาเหตุ/อาการที่เสีย &nbsp;&nbsp;&nbsp;{{$informcomrepair->SYMPTOM}}
        </td>        
    </tr>    
</table>
<br><br>
<table  width="100%">
    <tr>          
        <td width="20%" ></td>
        <td width="10%" >....................................................</td>
        <td width="20%"></td>       
        <td width="10%" >....................................................</td>
        <td width="40%" ></td>
    </tr> 
    <tr>          
        <td width="20%" ></td>
        <td width="10%" >(....................................................)</td>
        <td width="20%"></td>       
        <td width="10%" >(....................................................)</td>
        <td width="40%" ></td>
    </tr> 
</table> 
<table width="100%">
    <tr>          
        <td width="27%" ></td>
        <td width="10%" >หัวหน้างาน</td>
        <td width="28%"></td>       
        <td width="10%" >หัวหน้ากลุ่ม</td>
        <td width="15%" ></td>
    </tr> 
</table>
<hr>
<table  width="100%">
    <tr>          
        <td width="70%" >
           <b>เรียน หัวหน้างานซ่อมแซมครุภัณฑ์คอมพิวเตอร์</b>
        </td>   
        <td width="30%" ></td>       
    </tr> 
</table> 
<table  width="100%">
    <tr>   
        <td width="10%" ></td>        
        <td width="90%" >
            งานซ่อมครุภัณฑ์คอมพิวเตอร์ ได้ดำเนินการตรวจสอบตามรายการที่ขออนุมัติซ่อมแล้วผลปรากฏว่า
        </td>  
    </tr> 
</table> 
<table  width="100%">
    <tr>  
        <td width="10%" ></td> 
        <td width="13%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ซ่อมได้</label>      
        </td>      
        <td width="15%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ไม่ใช้อะไหล่</label>
       
        </td>
        <td width="17%" >            
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">เบิกวัสดุในคลัง</label>           
        </td>
        <td width="15%" > 
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">ขอจัดซื้อวัสดุ</label>
        </td> 
        <td width="30%" >            
        </td>
    </tr>           
</table> 
<table  width="100%">
    <tr>  
        <td width="10%" ></td> 
        <td width="13%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">ซ่อมไม่ได้</label>      
        </td>      
        <td width="15%">           
            <input type="checkbox" id="scales" name="scales">
            <label for="scales">แทงจำหน่าย</label>
       
        </td>
        <td width="62%" >            
                <input type="checkbox" id="scales" name="scales">
                <label for="scales">จ้างเอกชน/ส่งบริษัท...................................................................................</label>           
        </td>        
       
    </tr>           
</table> 
<table  width="100%">    
    <tr>          
        <td width="100%" >
           <label for="scales">บันทึกการซ่อมแซม/เหตุผล ..........................................................................................................................................................................</label>  
        </td>  
    </tr> 
</table> 
<br><br>
<table  width="100%">   
    <tr>   
        <td width="10%" ></td>         
        <td width="40%" >
           ลงชื่อ .......................................................................
        </td>  
        <td width="5%" ></td>         
        <td width="45%" >
           ลงชื่อ .......................................................................
        </td>    
    </tr>            
</table> 


<table  width="100%">
    <tr>   
        <td width="15%" ></td>    
        <td width="30%" >
            ผู้ดำเนินการตรวจสอบและซ่อมแซม
        </td>  
        <td width="15%" ></td>    
        <td width="40%" >
            หัวหน้างานซ่อมแซมครุภัณฑ์คอมพิวเตอร์
        </td>         
    </tr>     
</table> 

</body>
</html>