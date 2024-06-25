<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

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
            margin: 40px;
            margin-bottom: 1px;
            margin-left: 15px;
            margin-right: 15px;
        }

        body {
            font-family: 'THSarabunNew', sans-serif;
            font-size: 12.5px;
            line-height: 0.7;
            /* margin-top: 1cm; */
            margin-bottom: 1.5cm;
            margin-left: 2cm;
            margin-right: 2cm;
        }

        header {
            position: fixed;
            top: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        footer {
            position: fixed;
            bottom: -20px;
            left: 0px;
            right: 0px;
            height: 20px;
            font-size: 20px !important;

            /** Extra personal styles **/
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
        }

        table,
        td {
            border-collapse: collapse; //กรอบด้านในหายไป
        }

        td.o {
            border: 0.1px solid rgb(5, 5, 5);
        }

        table.one {
            border: 0.1px solid rgb(5, 5, 5);
        }

    </style>

    <?php
    
    function DateThaimount($strDate)
    {
        $strYear = date('Y', strtotime($strDate)) + 543;
        $strMonth = date('n', strtotime($strDate));
        $strDay = date('j', strtotime($strDate));
    
        $strMonthCut = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤษจิกายน', 'ธันวาคม'];
        $strMonthThai = $strMonthCut[$strMonth];
        return thainumDigit($strMonthThai);
    }
    
    function DateThaifrom($strDate)
    {
        $strYear = date('Y', strtotime($strDate)) + 543;
        $strMonth = date('n', strtotime($strDate));
        $strDay = date('j', strtotime($strDate));
    
        $strMonthCut = ['', 'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน', 'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'];
        $strMonthThai = $strMonthCut[$strMonth];
        return thainumDigit($strDay . ' ' . $strMonthThai . '  พ.ศ. ' . $strYear);
    }
    
    $date = date('Y-m-d');
    function timefor($strtime)
    {
        $H = substr($strtime, 10, 6);
        return $H;
    }
    ?>
</head>

<body>
    <center><B style="font-size: 18px;">ใบเบิกวัสดุ</B></center><BR>
    <table width="100%">
        <tr>
            <td width="60%">
                <b>ชื่อหน่วยงาน</b> &nbsp; 
            </td>
            <td width="40%">
                <b>ใบเบิกวัสดุเลขที่</b> &nbsp; 
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="60%">
                <b>เรียน</b> &nbsp;
                
            </td>
            <td width="40%">
                <b>วันที่</b> &nbsp; 
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="10%">
            </td>
            <td width="40%">
                ด้วย &nbsp; 
            </td>
            <td width="50%">
                มีความประสงค์ขอเบิกวัสดุ &nbsp; 
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="100%">
                ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;
               
            </td>
        </tr>
    </table>

    <main>

        <table width="100%" style="margin-top: 50px">
            <tr>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้เบิก
                </td>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้จ่ายพัสดุ
                </td>
            </tr>
        </table>
      
    
  
</body>

</html>
