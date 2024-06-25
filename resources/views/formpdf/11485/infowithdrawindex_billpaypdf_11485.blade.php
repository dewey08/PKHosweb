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
                font-size: 12.5px;
                line-height: 0.8;
              
           
            }
    
    
    .text-pedding{
        padding-left:10px;
        padding-right:10px;
    }   
    /* table, th, td {
         border: 1px solid #000;
    }
    .non-table{
         border: px solid #000;
    } */
    table{
         border-collapse: collapse;  //กรอบด้านในหายไป
    }
    .th{
        font-family: 'THSarabunNew', sans-serif;
                font-size: 10px;
    }
            
        </style>
        
    <?php
    
    
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
        <table  width="100%">
            <tr>  
                <td width="100%" > 
                    <?php
                $generator = new \Picqer\Barcode\BarcodeGeneratorJPG();
                $Pi = '<img src="data:image/jpeg;base64,' . base64_encode($generator->getBarcode($inforwarehouserequests->WAREHOUSE_REQUEST_CODE, $generator::TYPE_CODE_128,8,30)) . '" height="12px" width="20%" > ';
                echo $Pi;
            ?>
                </td>     
            </tr>           
        </table>
        <table  width="100%">
            <tr>  
                <td width="75%" > 
                    <p style="text-transform: lowercase;font-size: 10px;"> ผู้พิมพ์เอกสาร {{$inforpersonuser->HR_FNAME }} &nbsp;{{$inforpersonuser->HR_LNAME }}
                </td> 
               
                <td width="25%" > 
                    <p style="text-transform: lowercase;font-size: 10px;">วันที่พิมพ์เอกสาร : {{DateThai($date)}}
                </td>             
            </tr>           
        </table>
    <table style="border: 1px solid black; width: 100%;"> <!-- only added this -->
        <tr>
            <th style="width: 50px; border: 1px solid black;text-align: center;" colspan="6">ใบเบิก</th>
            <th style="width: 50px; border: 1px solid black;text-align: left;" colspan="4">แผ่นที่ : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;ในจำนวน: </th>
        </tr>
        <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 10px;"  rowspan="2">จาก</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 50px;"  colspan="2" rowspan="2">หน่วยจ่าย : {{$inforwarehouserequests->INVEN_NAME}}</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 30px;"  colspan="3" rowspan="2">ที่:</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 50px;"  colspan="4">สายงานที่ควบคุม:</th>
        </tr>
        <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 50px;;" colspan="4">ประเภทสิ่งอุปกรณ์:</th>
        </tr>
        <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 10px;" rowspan="3">ถึง</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 50px;"  colspan="2" rowspan="3">หน่วยเบิก : {{$inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME}}
            </br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<p style="white-space: pre;">เบิกให้ : {{$inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME}}</P></th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 45px;"  colspan="3">เบิกใบกรณี :</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 50px;"  colspan="4">ประเภทเงิน : &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; บาท</th>
        </tr>
        <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 15px;">ขึ้นต้น</th>
            <th style="word-break:break-all; word-wrap:break-word; border: 1px solid black;text-align: center; width: 15px;">ทดแทน</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 15px;">พิเศษ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;;text-align: left; width: 50px;"  rowspan="2" colspan="4">เลขที่งาน : </th>
        </tr>
        <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 10px;">&nbsp;&nbsp;&nbsp;</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 10px;">&nbsp;&nbsp;&nbsp;</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 10px;">&nbsp;&nbsp;&nbsp;</th>
        </tr>
       <tr>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 10px;">ลำดับ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 25px;">หมายเลข <br>สิ่งอุปกรณ์</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 95px;">รายการ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 20px;">จำนวน อนุมัติ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 20px;">คงคลัง คงค้าง คงจ่าย</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;">หน่วยนับ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;">จำนวน เบิก</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;">ราคา หน่วยละ</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;">ราคารวม</th>
            <th style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;">จ่ายจริง/ ค้างจ่าย</th>
        </tr>
        <?php $number = 0; ?>
        @foreach ($warehouserequests as $warehouserequest)  
            <?php $number++;?>
        <tr>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 10px;font-size: 12px;"><center>{{$number}}</center></td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 50px;font-size: 12px;">{{ $warehouserequest->SUP_FSN_NUM }} </td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: left; width: 70px;font-size: 12px;">{{ $warehouserequest->SUP_NAME}}</td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 20px;font-size: 12px;"></td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center;width: 20px;font-size: 12px;"></td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;font-size: 12px;">{{$warehouserequest->SUP_UNIT_NAME}} </td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;font-size: 12px;"> {{ $warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT }}</td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: right; width: 20px;font-size: 12px;" class="text-font text-pedding">{{ number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_PRICE,2)}}</td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: right; width: 20px;font-size: 12px;" class="text-font text-pedding">{{number_format( $warehouserequest->WAREHOUSE_REQUEST_SUB_SUM_PRICE,2)}}</td>
            <td style="word-break:break-all; word-wrap:break-word;border: 1px solid black;text-align: center; width: 20px;font-size: 12px;">{{$warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }}</td>
        </tr>
        @endforeach 
        <tr>
            <td style="border: 1px solid black;text-align: right;" colspan="8" class="text-font text-pedding">ราคารวม</td>
            <td style="width: 20px; border: 1px solid black;text-align: right;">{{number_format($warehouserequest_sum,2)}}</td>
            <td style="width: 20px; border: 1px solid black;text-align: right;" ></td>
        </tr>
    </table>
    <p style="text-transform: lowercase;font-size: 10px;">หลักฐานที่ใช้เบิก: -หนังสือ ด่วนมาก ที่ กห 0401/0352 ลง 1 ก.ย. 63 เรื่องการเบิกรับ สป. สาย ส. รายการเครื่องอ่านข้อมูลบัตรประชาชน Smartcard Reader</p>
<hr>
  <table style="border: none; width:100%;">
        <tr>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: left; width: 100px;">
        
                <p>ตรวจแล้วเห็นว่า......................................................
                ....................................................................................</P>
                         
            </td>
            <td style="word-break:break-all; word-wrap:break-word;border: none;text-align: left; width: 100px;">
        
                <p  style="text-transform: lowercase;">ขอเบิกสิ่งอุปกรณ์ตามที่ระบุไว้ในช่อง"จำนวนเบิก"และขอมอบให้ <br>
                    ............................................................................... เป็นผู้รับแทน
                </P>
                <!-- <p  style="text-transform: lowercase;">ขอเบิกสิ่งอุปกรณ์ตามที่ระบุไว้ในช่อง"จำนวนเบิก"และขอมอบให้ <br>
                    จ.ส.อ. มะปราง นิโรจน์,ส.ต. ฐิติวัฒน์ สีขาว เป็นผู้รับแทน</P> -->
                        
            </td>
        </tr>      
    </table>
    <table  width="100%">
        <tr>  
            <td width="25%" > 
                ................................................
            </td> 
            <td width="25%" >
                ................................................
            </td>
            <td width="25%" > 
                ................................................
            </td> 
            <td width="25%" >
                ................................................
            </td>
        </tr>           
    </table>
    <table  width="100%">
        <tr>  
            <td width="25%" align="center"> 
                (ลงนาม) ผู้ตรวจสอบ
            </td> 
            <td width="25%" align="center">
                วัน เดือน ปี
            </td>
            <td width="25%" align="center"> 
                (ลงนาม) ผู้เบิก
            </td> 
            <td width="25%" align="center">
                วัน เดือน ปี
            </td>
        </tr>           
    </table>
    <hr>
    <table  width="100%">
        <tr>  
            <td width="50%" > 
                อนุมัติให้จ่ายได้เฉพาะในรายการและจำนวนที่ ผู้ตรวจสอบเสนอ
            </td> 
            <td width="50%" >
                ได้รับสิ่งอุปกรณ์ตามรายการและจำนวนที่แจ้งไว้
            </td>
            
        </tr>           
    </table>
    <br>
    <table  width="100%">
        <tr>  
            <td width="25%" > 
                ................................................
            </td> 
            <td width="25%" >
                ................................................
            </td>
            <td width="25%" > 
                ................................................
            </td> 
            <td width="25%" >
                ................................................
            </td>
        </tr>           
    </table>
    <table  width="100%">
        <tr>  
            <td width="25%" align="center"> 
                (ลงนาม) ผู้สั่งจ่าย
            </td> 
            <td width="25%" align="center">
                วัน เดือน ปี
            </td>
            <td width="25%" align="center"> 
                (ลงนาม) ผู้เบิก
            </td> 
            <td width="25%" align="center">
                วัน เดือน ปี
            </td>
        </tr>           
    </table>
    <hr>
    <table  width="100%">
        <tr>  
            <td width="100%" > 
                ได้จ่ายตามรายการและจำนวนที่แจ้งไว้ใน"จ่ายจริง"แล้ว
            </td>                        
        </tr>           
    </table>
    <br>
    <table  width="100%">
        <tr>  
            <td width="25%" > 
                ................................................
            </td> 
            <td width="25%" >
                ................................................
            </td>
            <td width="50%" > 
                ทะเบียนหน่วยจ่าย : .....................................................................
            </td>             
        </tr>           
    </table>
    <table  width="100%">
        <tr>  
            <td width="25%" align="center"> 
                (ลงนาม) ผู้จ่าย
            </td> 
            <td width="25%" align="center">
                วัน เดือน ปี
            </td>
            <td width="25%" align="center"> 
               
            </td> 
            <td width="25%" align="center">
                
            </td>
        </tr>           
    </table>
    <table  width="100%">
        <tr>  
            <td width="100%" > 
                <p style="text-transform: lowercase;font-size: 10px;text-align:center">(พิมพ์ตามระเบียบกองทัพว่าด้วยการส่งกำลังสิ่งอุปกรณ์ประเภท 2 และ 4 พ.ศ. 2534)</p>
            </td>                        
        </tr>           
    </table>
  

    </body>
</html>