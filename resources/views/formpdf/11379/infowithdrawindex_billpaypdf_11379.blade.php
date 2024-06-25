
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
                font-size: 13.5px;
               line-height: 1;     
           
            }
    
          
        table, th, td {
        border: 1px solid black;
        }
    
    
        .text-pedding{
        padding-left:10px;
        padding-right:10px;
    }   
                  
    table{
         border-collapse: collapse;  //กรอบด้านในหายไป
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
    
        ?>
    
    </head>
    
    <body>
    
    <center><B style="font-size: 24px;">ใบเบิกวัสดุ</B></center><BR>
    <br>
    <label for=""> ชื่อหน่วยงาน &nbsp;&nbsp; {{$inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME}}</label>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
 
    <label for="">ใบเบิกวัสดุเลขที่ :&nbsp;&nbsp; {{$inforwarehouserequests->WAREHOUSE_REQUEST_CODE}}</label>
    <br>
    @foreach ($info_orgs as $info_org) 
    <label for=""> เรียน &nbsp;&nbsp; {{$info_org-> ORG_LEADER_POSITION}}</label>
    @endforeach 
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    &nbsp;&nbsp;&nbsp;
    
    <label for="">วันที่ : &nbsp;&nbsp;{{DateThaifrom($inforwarehouserequests->WAREHOUSE_DATE_WANT)}} </label>
    <br>
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <label for="">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ด้วย &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; {{$inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME}}
        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    มีความประสงค์ขอเบิกวัสดุ {{$inforwarehouserequests->WAREHOUSE_REQUEST_BUY_COMMENT}}</label><br>
    <label for=""> ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;&nbsp; {{DateThaimount($inforwarehouserequests->WAREHOUSE_DATE_WANT)}} &nbsp;&nbsp; ตามรายการดังนี้</label>
    <br>
    
    <table style="width: 800px"> 
        <tr>
            <th style="width: 7px" rowspan="2"><center>ที่</center></th>
           
            <th style="width: 140px" rowspan="2"><center>รายการ</center></th>
    
            <th style="width: 30px" colspan="3"><center>จำนวน</center></th>  
    
            <th style="width: 100px" rowspan="2"><center>ราคา/ <br> หน่วย</center></th>  
            <th style="width: 120px" rowspan="2"><center>ราคารวม</center></th>
            <th style="width: 90px" rowspan="2"><center>หมายเหตุ</center></th>
        </tr>
        <tr>
            <th style="width: 10px"><center>หน่วย</center></th>
            <th style="width: 10px"><center>เบิก</center></th>
            <th style="width: 10px"><center>อนุมัติ</center></th>
        </tr>
    
           <?php $number = 0; ?>
                @foreach ($warehouserequests as $warehouserequest)  
                    <?php $number++;?>
    
        <tr>
            <td style="width: 7px; word-break:break-all; word-wrap:break-word;" class="text-font text-pedding"><center>{{thainumDigit($number)}}</center></td>
            <td style="width: 140px; word-break:break-all; word-wrap:break-word;" class="text-font text-pedding"> {{ thainumDigit($warehouserequest->SUP_NAME )}}  </td>
    
        <td style="width: 20px; word-break:break-all; word-wrap:break-word;text-align: center" class="text-font text-pedding">{{$warehouserequest->SUP_UNIT_NAME}}</td>           
            <td style="width: 20px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding">{{ thainumDigit($warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT )}}  </td>
            <td style="width: 20px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding">{{thainumDigit($warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY )}}  </td>
    
            <td style="width: 20px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding">{{ thainumDigit(number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_PRICE,2))}}  </td>
            <td style="width: 40px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding">{{thainumDigit(number_format( $warehouserequest->WAREHOUSE_REQUEST_SUB_SUM_PRICE,2))}}</td>
            <td style="width: 20px; word-break:break-all; word-wrap:break-word;text-align: right" class="text-font text-pedding"></td>
          @endforeach 
             
        </tr>
        <tr>
            <th style="width: 500px; word-break:break-all; word-wrap:break-word;text-align: right" colspan="6">ราคารวม&nbsp;&nbsp;</th> 
        <th style="width: 20px;word-wrap:break-word;text-align: right" class="text-font text-pedding">{{thainumDigit(number_format($warehouserequest_sum,2))}}</th> 
            <th style="width: 20px"></th> 
            
        </tr>
    
    </table>
    <table style="border: none; width:100%;">
        <tr>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: center;">
        
                <p style="text-align: center;">ลงชื่อ:................................................หัวหน้างาน/ผู้อนุมัติเห็นชอบ</P>
                <p style="text-align: center;">
                (&nbsp;&nbsp;&nbsp;&nbsp;{{$inforwarehouserequests->HR_PREFIX_NAME}}{{$inforwarehouserequests->HR_FNAME}}&nbsp;{{$inforwarehouserequests->HR_LNAME}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p> 
                <p style="text-align: center;">หัวหน้างาน/หัวหน้าฝ่าย</p>
                <p style="text-align: center;">{{DateThaifrom($inforwarehouserequests->WAREHOUSE_DATE_WANT)}}</p>
            </td>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: center;">
                <p style="text-align: center;">ลงชื่อ:..................................................ผู้อนุมัติจ่ายพัสดุ</P>
                    <p style="text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p> 
                <p style="text-align: center;">หัวหน้าเจ้าหน้าที่พัสดุ/ผู้ที่ได้รับมอบหมาย</p>
                <p style="text-align: center;">ลงบัญชีจ่ายเรียบร้อยแล้ว</p>
            </td>
        </tr>
        <tr>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: left; width: 100px;">
        
                <p style="text-align: center;">ลงชื่อ:..................................................ผู้รับพัสดุ</P>
                <p style="text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p> 
                <p style="text-align: center;">ผู้รับพัสดุ</p>
                <p style="text-align: center;">{{DateThaifrom($inforwarehouserequests->WAREHOUSE_DATE_WANT)}}</p>
            </td>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: left; width: 100px;">
                <p style="text-align: center;">ลงชื่อ:..................................................เจ้าหน้าที่พัสดุ</P>
                <p style="text-align: center;">(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)</p> 
                <p style="text-align: center;">เจ้าหน้าที่พัสดุ</p>
                <p style="text-align: center;">{{DateThaifrom($inforwarehouserequests->WAREHOUSE_DATE_WANT)}}</p>
            
            </td>
        </tr>
    </table>
    </body>
    </html>