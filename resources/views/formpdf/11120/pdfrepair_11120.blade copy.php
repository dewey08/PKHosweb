
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
        border: 1px solid rgb(253, 253, 253);
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
    
    <center>
        <B style="font-size: 14px;">ใบแจ้งซ่อม</B>
        <br>
        {{-- <B style="font-size: 13px;">{{$info_orgs->ORG_NAME}}</B> --}}
    </center><br>  
    <table  width="100%">
        <tr>          
            <td width="50%" >
                {{-- หน่วยงานผู้แจ้งซ่อม&nbsp; {{$informrepair_indexs->HR_DEPARTMENT_SUB_SUB_NAME}} --}}
            </td>
            <td width="40%" >
                {{-- เบอร์โทร&nbsp;{{$informrepair_indexs->HR_PHONE}} --}}
            </td>
        </tr>           
    </table>     
    <hr>    
    <br>
    <table  width="100%">
        <tr>          
            <td width="40%" >
                {{-- ส่วนที่ 1 ผู้แจ้ง	เลขที่ : &nbsp; {{$informrepair_indexs->HR_DEPARTMENT_SUB_SUB_NAME}} --}}
            </td>
            <td width="30%" >
                {{-- วันที่:&nbsp;{{$informrepair_indexs->HR_PHONE}} --}}
            </td>
            <td width="30%" >
                {{-- เวลา:&nbsp;{{$informrepair_indexs->HR_PHONE}} --}}
            </td>
        </tr>           
    </table>    
    
    <br>
    </body>
    </html>
    