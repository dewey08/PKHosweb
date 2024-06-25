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
                <b>ชื่อหน่วยงาน</b> &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
            </td>
            <td width="40%">
                <b>ใบเบิกวัสดุเลขที่</b> &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_CODE }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="60%">
                <b>เรียน</b> &nbsp;
                @foreach ($info_orgs as $info_org)
                    {{ $info_org->ORG_LEADER_POSITION }}
                @endforeach
            </td>
            <td width="40%">
                <b>วันที่</b> &nbsp;{{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="10%">
            </td>
            <td width="40%">
                ด้วย &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
            </td>
            <td width="50%">
                มีความประสงค์ขอเบิกวัสดุ &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_BUY_COMMENT }}
            </td>
        </tr>
    </table>
    <table width="100%">
        <tr>
            <td width="100%">
                ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;
                {{ DateThaimount($inforwarehouserequests->WAREHOUSE_DATE_WANT) }} &nbsp;&nbsp; ตามรายการดังนี้
            </td>
        </tr>
    </table>

    <main>
        <table width="100%" class="one" style="margin-top: 7px;">
            <thead>
                <tr>
                    <td width="8%" class="o" rowspan="2">
                        <center>ที่</center>
                    </td>
                    <td width="44%" class="o" rowspan="2">
                        <center>รายการ</center>
                    </td>
                    <td width="30%" class="o" colspan="3">
                        <center>จำนวน</center>
                    </td>
                    <td width="16%" class="o" rowspan="2">
                        <center>ราคา / <br> หน่วย</center>
                    </td>
                    <td class="o" rowspan="2">
                        <center>ราคารวม</center>
                    </td>
                    <td class="o" rowspan="2">
                        <center>หมายเหตุ</center>
                    </td>
                </tr>
                <tr>
                    <td width="10%" class="o">
                        <center>หน่วย</center>
                    </td>
                    <td width="10%" class="o">
                        <center>เบิก</center>
                    </td>
                    <td width="10%" class="o">
                        <center>อนุมัติ</center>
                    </td>
                </tr>
            </thead>
            <tbody>

                <?php $i = 0; ?>
                @foreach ($warehouserequests as $warehouserequest)
                    <?php $i++; ?>

                    @if ($i % 20 == 0)
                        <tr height="1px">
                            <td class="o" width="8%">
                                <center>{{ $i }}</center>
                            </td>
                            <td class="o" width="47%">
                                &nbsp;{{ $warehouserequest->SUP_NAME }}
                            </td>
                            <td class="o" width="10%">
                                <center>{{ $warehouserequest->SUP_UNIT_NAME }}</center>
                            </td>
                            <td class="o" width="5%">
                                <center>{{ $warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                            </td>
                            <td class="o" width="5%">
                                <center> {{ $warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                            </td>
                            <td class="o" style="text-align: right" width="10%">
                                {{ number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                            </td>
                            <td class="o" style="text-align: right" width="10%">
                                {{ number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                            </td>
                            <td class="o" width="5%">
                                <center></center>
                            </td>
                        </tr> 
                        
                        <?php break; ?>

                   
                    @else
                        <tr height="1px">
                            <td class="o" width="8%">
                                <center>{{ $i }}</center>
                            </td>
                            <td class="o" width="47%">
                                &nbsp;{{ $warehouserequest->SUP_NAME }}
                            </td>
                            <td class="o" width="10%">
                                <center>{{ $warehouserequest->SUP_UNIT_NAME }}</center>
                            </td>
                            <td class="o" width="5%">
                                <center>{{ $warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                            </td>
                            <td class="o" width="5%">
                                <center> {{ $warehouserequest->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                            </td>
                            <td class="o" style="text-align: right" width="10%">
                                {{ number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                            </td>
                            <td class="o" style="text-align: right" width="10%">
                                {{ number_format($warehouserequest->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                            </td>
                            <td class="o" width="5%">
                                <center></center>
                            </td>
                        </tr>


                    @endif

                   

                    <?php 
                        $idcount =  $warehouserequest-> WAREHOUSE_REQUEST_SUB_ID; 
                        $idware = $warehouserequest-> WAREHOUSE_REQUEST_ID;  

                        // $countrow = 20;
                        // $sumpage = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                        // ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                        // ->sum();                                    
                        
                        $sumpage = DB::table('warehouse_request_sub')
                            ->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID') 
                            ->where('WAREHOUSE_REQUEST_ID','=', $idware)                         
                            ->sum('WAREHOUSE_REQUEST_SUB_SUM_PRICE');
                    ?>  
                @endforeach

                {{-- <tr>
                    <td nowrap style="overflow: hidden;">{{$name}}</td>
                      @foreach($months as $month)
                        <td>{{'£'.array_reduce($products, function ($previous, $product) use ($month) {
                            $value = $product['current']->has($month->format('m/Y')) ? intval($product['current'][$month->format('m/Y')]->sum('batch_total')) : 0;
                            return $previous + $value;
                        }, 0)}}</td>
                      @endforeach

                        <td>{{'£'.array_reduce($products, function ($previous, $product) {
                            return $previous + intval($product['on_hold']['total']);
                        }, 0);}}</td>
                        <td>{{'£'.array_reduce($products, function ($previous, $product) {
                            return $previous + intval($product['current']->flatten()->sum('batch_total') + $product['on_hold']['total']);
                        }, 0);}}</td>
                        <td>{{array_reduce($products, function ($previous, $product) {
                            return $previous + intval($product['last_year']->flatten()->sum('batch_total'));
                        }, 0);}}</td>
                  </tr> --}}


            
               
                @if($count < 20)
                    <tr>
                        <td width="5%" class="o" colspan="6">
                            <center></center>
                        </td>
                        <td width="20%" class="o" style="text-align: right">
                            {{ number_format($warehouserequest_sum, 2) }}&nbsp;
                        </td>
                        <td width="20%" class="o">
                        </td>
                    </tr>
                @endif  

            </tbody>
        </table>
    </main>    

    {{-- @if($count < 24) --}}
    {{-- @if($count == 21 || $count == 22 || $count == 23 || $count == 24 ) --}}
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
      
        <table width="100%" style="margin-top: 5px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp; {{ $inforwarehouserequests->WAREHOUSE_SAVE_HR_NAME }} &nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="9%"></td>
                <td width="31%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 2px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp; {{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                        &nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="5%"></td>
                <td width="35%">
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 40px">
            <tr>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้รับพัสดุ
                </td>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้สั่งจ่าย
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 5px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="9%"></td>
                <td width="31%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>    
    {{-- @endif  --}}


        {{-- {{$idcount +1 }}
        {{$idware}} --}}

        {{-- <p style="page-break-after: always;"></p> --}}

           
    @if($count > 20)

    <p style="page-break-after: always;"></p>


    <center><B style="font-size: 18px;">ใบเบิกวัสดุ</B></center><BR>
        <table width="100%">
            <tr>
                <td width="60%">
                    <b>ชื่อหน่วยงาน</b> &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                </td>
                <td width="40%">
                    <b>ใบเบิกวัสดุเลขที่</b> &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_CODE }}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="60%">
                    <b>เรียน</b> &nbsp;
                    @foreach ($info_orgs as $info_org)
                        {{ $info_org->ORG_LEADER_POSITION }}
                    @endforeach
                </td>
                <td width="40%">
                    <b>วันที่</b> &nbsp;{{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="10%">
                </td>
                <td width="40%">
                    ด้วย &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                </td>
                <td width="50%">
                    มีความประสงค์ขอเบิกวัสดุ &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_BUY_COMMENT }}
                </td>
            </tr>
        </table>
        <table width="100%">
            <tr>
                <td width="100%">
                    ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;
                    {{ DateThaimount($inforwarehouserequests->WAREHOUSE_DATE_WANT) }} &nbsp;&nbsp; ตามรายการดังนี้
                </td>
            </tr>
        </table>

    <main>
        <table width="100%" class="one" style="margin-top: 7px;">
                    <thead>
                        <tr>
                            <td width="8%" class="o" rowspan="2">
                                <center>ที่</center>
                            </td>
                            <td width="44%" class="o" rowspan="2">
                                <center>รายการ</center>
                            </td>
                            <td width="30%" class="o" colspan="3">
                                <center>จำนวน</center>
                            </td>
                            <td width="16%" class="o" rowspan="2">
                                <center>ราคา / <br> หน่วย</center>
                            </td>
                            <td class="o" rowspan="2">
                                <center>ราคารวม</center>
                            </td>
                            <td class="o" rowspan="2">
                                <center>หมายเหตุ</center>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" class="o">
                                <center>หน่วย</center>
                            </td>
                            <td width="10%" class="o">
                                <center>เบิก</center>
                            </td>
                            <td width="10%" class="o">
                                <center>อนุมัติ</center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                
                        <?php 
                        $idrequest = $idcount +2;$idrequest2 = $idcount +3;$idrequest3 = $idcount +4;$idrequest4 = $idcount +5;$idrequest5 = $idcount +6;$idrequest6 = $idcount +7;$idrequest7 = $idcount +8;$idrequest8 = $idcount +9;
                        $idrequest9 = $idcount +10;$idrequest10 = $idcount +11;$idrequest11 = $idcount +12;$idrequest12 = $idcount +13;$idrequest13 = $idcount +14;$idrequest14 = $idcount +15;$idrequest15 = $idcount +16;$idrequest16 = $idcount +17;
                        $idrequest17 = $idcount +18;$idrequest18 = $idcount +19;$idrequest19 = $idcount +20;$idrequest20 = $idcount +21;$idrequest21 = $idcount +22;$idrequest22 = $idcount +23;$idrequest23 = $idcount +24;
                        $idrequest24 = $idcount +25;$idrequest25 = $idcount +26;$idrequest26 = $idcount +27;$idrequest27 = $idcount +28;$idrequest28 = $idcount +29;$idrequest29 = $idcount +30;$idrequest30 = $idcount +31;
                        $idrequest31 = $idcount +32;$idrequest32 = $idcount +33;$idrequest33 = $idcount +34;$idrequest34 = $idcount +35;$idrequest35 = $idcount +36;$idrequest36 = $idcount +37;$idrequest37 = $idcount +38;
                        $idrequest38 = $idcount +39;$idrequest39 = $idcount +40;$idrequest40 = $idcount +41;$idrequest41 = $idcount +42;$idrequest42 = $idcount +43;$idrequest43 = $idcount +44;$idrequest44 = $idcount +45;
                         $warehouserequest_page = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                         ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                        ->get();                                    
                        ?>

                        <?php $i = 20; ?>
                        @foreach ($warehouserequest_page as $items)
                            <?php $i++; ?>                                                                    
                               
                                @if ($i == 21  )
                                        <?php 
                                        // if ($idrequest6 != '') {
                                            $getdata1 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest) 
                                                    ->first(); 
                                        // }                                      
                                          
                                        ?>
                                        @if ($getdata1 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>                                            
                                            <td class="o" width="47%">
                                             
                                                &nbsp;{{ $getdata1->SUP_NAME }}   
                                        
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata1->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata1->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata1->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right" width="10%">
                                                {{ number_format($getdata1->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right" width="10%">
                                                {{ number_format($getdata1->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                    }
                                        @endif
                              
                                @elseif ($i == 22)
                                        <?php 
                                            $getdata2 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest2) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata2 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata2->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata2->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata2->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata2->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right" width="10%">
                                                {{ number_format($getdata2->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right" width="10%">
                                                {{ number_format($getdata2->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                    }
                                    @endif
                                @elseif ($i == 23)
                                            <?php 
                                                $getdata3 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                        ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                        ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest3) 
                                                        ->first(); 
                                            ?>
                                            @if ($getdata3 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata3->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata3->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata3->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata3->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata3->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata3->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                        }
                                        @endif
                                @elseif ($i == 24)
                                        <?php 
                                            $getdata4 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest4) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata4 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata4->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata4->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata4->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata4->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata4->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata4->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif
                                @elseif ($i == 25)
                                        <?php 
                                            $getdata5 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest5) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata5 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata5->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata5->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata5->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata5->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata5->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata5->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif
                                @elseif ($i == 26)
                                        <?php 
                                            $getdata6 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest6) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata6 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata6->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata6->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata6->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata6->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata6->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata6->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif

                                @elseif ($i == 27)
                                        <?php 
                                            $getdata7 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest7) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata7 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata7->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata7->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata7->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata7->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata7->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata7->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif

                                @elseif ($i == 28)
                                        <?php 
                                            $getdata8 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest8) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata8 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata8->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata8->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata8->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata8->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata8->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata8->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif
                                @elseif ($i == 29)
                                        <?php 
                                            $getdata9 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                    ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                    ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest9) 
                                                    ->first(); 
                                        ?>
                                        @if ($getdata9 != '') {
                                            <tr height="1px">
                                                <td class="o" width="8%">
                                                    <center>{{ $i }}</center>
                                                </td>
                                                <td class="o" width="47%">
                                                    &nbsp;{{ $getdata9->SUP_NAME }}                                               
                                                </td> 
                                                <td class="o" width="10%">                                               
                                                    <center>{{ $getdata9->SUP_UNIT_NAME }}</center>   
                                                </td> 
                                                <td class="o" width="5%">                                                                                                          
                                                    <center>{{ $getdata9->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center> {{ $getdata9->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata9->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="10%" style="text-align: right" width="10%">
                                                    {{ number_format($getdata9->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                </td> 
                                                <td class="o" width="5%">
                                                    <center></center>
                                                </td> 
                                            </tr>
                                            }
                                        @endif
                                @elseif ($i == 30)
                                            <?php 
                                                $getdata10 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                        ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                        ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest10) 
                                                        ->first(); 
                                            ?>
                                            @if ($getdata10 != '') {
                                                <tr height="1px">
                                                    <td class="o" width="8%">
                                                        <center>{{ $i }}</center>
                                                    </td>
                                                    <td class="o" width="47%">
                                                        &nbsp;{{ $getdata10->SUP_NAME }}                                               
                                                    </td> 
                                                    <td class="o" width="10%">                                               
                                                        <center>{{ $getdata10->SUP_UNIT_NAME }}</center>   
                                                    </td> 
                                                    <td class="o" width="5%">                                                                                                          
                                                        <center>{{ $getdata10->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                    </td> 
                                                    <td class="o" width="5%">
                                                        <center> {{ $getdata10->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                    </td> 
                                                    <td class="o" width="10%" style="text-align: right" width="10%">
                                                        {{ number_format($getdata10->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                    </td> 
                                                    <td class="o" width="10%" style="text-align: right" width="10%">
                                                        {{ number_format($getdata10->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                    </td> 
                                                    <td class="o" width="5%">
                                                        <center></center>
                                                    </td> 
                                                </tr>
                                                }
                                            @endif
                                @elseif ($i == 31)
                                                <?php 
                                                    $getdata11 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest11) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata11 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata11->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata11->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata11->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata11->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata11->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata11->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 32)
                                                <?php 
                                                    $getdata12 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest12) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata12 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata12->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata12->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata12->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata12->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata12->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata12->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif

                                @elseif ($i == 33)
                                                <?php 
                                                    $getdata13 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest13) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata13 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata13->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata13->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata13->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata13->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata13->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata13->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 34)
                                                <?php 
                                                    $getdata14 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest14) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata14 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata14->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata14->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata14->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata14->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata14->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata14->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 35) 
                                                <?php 
                                                    $getdata15 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest15) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata15 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata15->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata15->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata15->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata15->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata15->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata15->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 36) 
                                                <?php 
                                                    $getdata16 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest16) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata16 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata16->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata16->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata16->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata16->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata16->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata16->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 37) 
                                                <?php 
                                                    $getdata17 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest17) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata17 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata17->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata17->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata17->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata17->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata17->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata17->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 38) 
                                                <?php 
                                                    $getdata18 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest18) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata18 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata18->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata18->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata18->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata18->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata18->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata18->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 39) 
                                                <?php 
                                                    $getdata19 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest19) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata19 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata19->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata19->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata19->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata19->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata19->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata19->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                @elseif ($i == 40) 
                                                <?php 
                                                    $getdata20 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest20) 
                                                            ->first(); 
                                                ?>
                                                @if ($getdata20 != '') {
                                                    <tr height="1px">
                                                        <td class="o" width="8%">
                                                            <center>{{ $i }}</center>
                                                        </td>
                                                        <td class="o" width="47%">
                                                            &nbsp;{{ $getdata20->SUP_NAME }}                                               
                                                        </td> 
                                                        <td class="o" width="10%">                                               
                                                            <center>{{ $getdata20->SUP_UNIT_NAME }}</center>   
                                                        </td> 
                                                        <td class="o" width="5%">                                                                                                          
                                                            <center>{{ $getdata20->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center> {{ $getdata20->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata20->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="10%" style="text-align: right" width="10%">
                                                            {{ number_format($getdata20->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                                        </td> 
                                                        <td class="o" width="5%">
                                                            <center></center>
                                                        </td> 
                                                    </tr>
                                                    }
                                                @endif
                                
                               
                                                               
                                 @else
                                @endif
                                                                                                
                        @endforeach                        
                        @if($count < 40 ) 
                            <tr>
                                <td width="5%" class="o" colspan="6">
                                    <center></center>
                                </td>
                                <td width="20%" class="o" style="text-align: right">
                                    {{ number_format($warehouserequest_sum, 2) }}&nbsp;
                                </td>
                                <td width="20%" class="o">
                                </td>
                            </tr>  
                            @endif                      
                    </tbody>
        </table>
    </main>
    @endif

    @if($count > 20 ) 
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
  
    <table width="100%" style="margin-top: 5px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp; {{ $inforwarehouserequests->WAREHOUSE_SAVE_HR_NAME }} &nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="9%"></td>
            <td width="31%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 2px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp; {{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                    &nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="5%"></td>
            <td width="35%">
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 40px">
        <tr>
            <td width="5%"></td>
            <td width="35%">
                ลงชื่อ.............................................................
            </td>
            <td width="10%">
                ผู้รับพัสดุ
            </td>
            <td width="5%"></td>
            <td width="35%">
                ลงชื่อ.............................................................
            </td>
            <td width="10%">
                ผู้สั่งจ่าย
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 5px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="9%"></td>
            <td width="31%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>    

    @endif
   

        @if($count > 41)

        <p style="page-break-after: always;"></p> 

            <center><B style="font-size: 18px;">ใบเบิกวัสดุ</B></center><BR>
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <b>ชื่อหน่วยงาน</b> &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                        </td>
                        <td width="40%">
                            <b>ใบเบิกวัสดุเลขที่</b> &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_CODE }}
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="60%">
                            <b>เรียน</b> &nbsp;
                            @foreach ($info_orgs as $info_org)
                                {{ $info_org->ORG_LEADER_POSITION }}
                            @endforeach
                        </td>
                        <td width="40%">
                            <b>วันที่</b> &nbsp;{{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="10%">
                        </td>
                        <td width="40%">
                            ด้วย &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                        </td>
                        <td width="50%">
                            มีความประสงค์ขอเบิกวัสดุ &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_BUY_COMMENT }}
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td width="100%">
                            ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;
                            {{ DateThaimount($inforwarehouserequests->WAREHOUSE_DATE_WANT) }} &nbsp;&nbsp; ตามรายการดังนี้
                        </td>
                    </tr>
                </table>
            <main>
                <table width="100%" class="one" style="margin-top: 7px;">
                    <thead>
                        <tr>
                            <td width="8%" class="o" rowspan="2">
                                <center>ที่</center>
                            </td>
                            <td width="44%" class="o" rowspan="2">
                                <center>รายการ</center>
                            </td>
                            <td width="30%" class="o" colspan="3">
                                <center>จำนวน</center>
                            </td>
                            <td width="16%" class="o" rowspan="2">
                                <center>ราคา / <br> หน่วย</center>
                            </td>
                            <td class="o" rowspan="2">
                                <center>ราคารวม</center>
                            </td>
                            <td class="o" rowspan="2">
                                <center>หมายเหตุ</center>
                            </td>
                        </tr>
                        <tr>
                            <td width="10%" class="o">
                                <center>หน่วย</center>
                            </td>
                            <td width="10%" class="o">
                                <center>เบิก</center>
                            </td>
                            <td width="10%" class="o">
                                <center>อนุมัติ</center>
                            </td>
                        </tr>
                    </thead>
                    <tbody>
                
                        <?php 
                                $idrequest21 = $idcount +22;$idrequest22 = $idcount +23;$idrequest23 = $idcount +24;$idrequest24 = $idcount +25;
                                $idrequest26 = $idcount +27;$idrequest27 = $idcount +28;$idrequest28 = $idcount +29;$idrequest29 = $idcount +30;$idrequest30 = $idcount +31;
                                $idrequest31 = $idcount +32;$idrequest32 = $idcount +33;$idrequest33 = $idcount +34;$idrequest34 = $idcount +35;$idrequest35 = $idcount +36;$idrequest36 = $idcount +37;$idrequest37 = $idcount +38;
                                $idrequest38 = $idcount +39;$idrequest39 = $idcount +40;$idrequest40 = $idcount +41;
                                $warehouserequest_page = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                ->get();                                    
                        ?>

                        <?php $i = 40; ?>
                        @foreach ($warehouserequest_page as $items)
                            <?php $i++; ?>  
                            
                            @if ($i == 41) 
                                    <?php 
                                        $getdata21 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest21) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata21 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata21->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata21->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata21->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata21->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata21->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata21->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif             
                            @elseif ($i == 42) 
                                    <?php 
                                        $getdata22 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest22) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata22 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata22->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata22->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata22->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata22->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata22->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata22->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif              
                            @elseif ($i == 43) 
                                    <?php 
                                        $getdata23 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest23) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata23 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata23->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata23->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata23->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata23->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata23->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata23->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 44) 
                                <?php 
                                    $getdata24 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest24) 
                                            ->first(); 
                                ?>
                                @if ($getdata24 != '') {
                                    <tr height="1px">
                                        <td class="o" width="8%">
                                            <center>{{ $i }}</center>
                                        </td>
                                        <td class="o" width="47%">
                                            &nbsp;{{ $getdata24->SUP_NAME }}                                               
                                        </td> 
                                        <td class="o" width="10%">                                               
                                            <center>{{ $getdata24->SUP_UNIT_NAME }}</center>   
                                        </td> 
                                        <td class="o" width="5%">                                                                                                          
                                            <center>{{ $getdata24->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                        </td> 
                                        <td class="o" width="5%">
                                            <center> {{ $getdata24->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                        </td> 
                                        <td class="o" width="10%" style="text-align: right">
                                            {{ number_format($getdata24->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                        </td> 
                                        <td class="o" width="10%" style="text-align: right">
                                            {{ number_format($getdata24->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                        </td> 
                                        <td class="o" width="5%">
                                            <center></center>
                                        </td> 
                                    </tr>
                                    }
                                @endif 
                            @elseif ($i == 45) 
                                    <?php 
                                        $getdata25 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest25) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata25 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata25->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata25->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata25->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata25->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata25->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata25->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 46) 
                                    <?php 
                                        $getdata26 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest26) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata26 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata26->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata26->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata26->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata26->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata26->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata26->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 47) 
                                    <?php 
                                        $getdata27 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest27) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata27 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata27->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata27->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata27->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata27->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata27->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata27->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 48) 
                                    <?php 
                                        $getdata28 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest28) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata28 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata28->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata28->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata28->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata28->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata28->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata28->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 49) 
                                    <?php 
                                        $getdata29 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest29) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata29 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata29->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata29->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata29->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata29->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata29->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata29->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 50) 
                                    <?php 
                                        $getdata30 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest30) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata30 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata30->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata30->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata30->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata30->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata30->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata30->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 51) 
                                    <?php 
                                        $getdata31 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest31) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata31 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata31->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata31->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata31->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata31->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata31->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata31->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 52) 
                                    <?php 
                                        $getdata32 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest32) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata32 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata32->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata32->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata32->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata32->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata32->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata32->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 53) 
                                    <?php 
                                        $getdata33 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest33) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata33 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata33->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata33->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata33->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata33->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata33->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata33->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif

                            @elseif ($i == 54) 
                                    <?php 
                                        $getdata34 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest34) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata34 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata34->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata34->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata34->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata34->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata34->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata34->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 55) 
                                    <?php 
                                        $getdata35 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest35) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata35 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata35->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata35->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata35->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata35->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata35->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata35->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 56) 
                                    <?php 
                                        $getdata36 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest36) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata36 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata36->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata36->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata36->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata36->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata36->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata36->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 57) 
                                    <?php 
                                        $getdata37 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest37) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata37 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata37->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata37->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata37->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata37->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata37->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata37->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 58) 
                                    <?php 
                                        $getdata38 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest38) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata38 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata38->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata38->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata38->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata38->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata38->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata38->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 59) 
                                    <?php 
                                        $getdata39 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest39) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata39 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata39->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata39->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata39->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata39->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata39->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata39->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 60) 
                                    <?php 
                                        $getdata40 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest40) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata40 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata40->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata40->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata40->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata40->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata40->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata40->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif


                            @else
                            @endif
                                                                                            
                        @endforeach                        
                        @if($count < 60 ) 
                            <tr>
                                <td width="5%" class="o" colspan="6">
                                    <center></center>
                                </td>
                                <td width="20%" class="o" style="text-align: right">
                                    {{ number_format($warehouserequest_sum, 2) }}&nbsp;
                                </td>
                                <td width="20%" class="o">
                                </td>
                            </tr>    
                        @endif                    
                    </tbody>
                </table>
            </main>
        @endif
      
        @if($count > 41)

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
        <table width="100%" style="margin-top: 5px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp; {{ $inforwarehouserequests->WAREHOUSE_SAVE_HR_NAME }} &nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="9%"></td>
                <td width="31%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 2px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp; {{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                        &nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="5%"></td>
                <td width="35%">
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 40px">
            <tr>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้รับพัสดุ
                </td>
                <td width="5%"></td>
                <td width="35%">
                    ลงชื่อ.............................................................
                </td>
                <td width="10%">
                    ผู้สั่งจ่าย
                </td>
            </tr>
        </table>
        <table width="100%" style="margin-top: 5px">
            <tr>
                <td width="8%"></td>
                <td width="32%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
                <td width="9%"></td>
                <td width="31%" style="text-align: center">
                    <label for="">(&nbsp;.............................................................&nbsp;)</label>
                </td>
                <td width="10%">
                </td>
            </tr>
        </table>     

        @endif

    </main>

    @if($count > 60)

    <p style="page-break-after: always;"></p> 

        <center><B style="font-size: 18px;">ใบเบิกวัสดุ</B></center><BR>
            <table width="100%">
                <tr>
                    <td width="60%">
                        <b>ชื่อหน่วยงาน</b> &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                    </td>
                    <td width="40%">
                        <b>ใบเบิกวัสดุเลขที่</b> &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_CODE }}
                    </td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="60%">
                        <b>เรียน</b> &nbsp;
                        @foreach ($info_orgs as $info_org)
                            {{ $info_org->ORG_LEADER_POSITION }}
                        @endforeach
                    </td>
                    <td width="40%">
                        <b>วันที่</b> &nbsp;{{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                    </td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="10%">
                    </td>
                    <td width="40%">
                        ด้วย &nbsp;{{ $inforwarehouserequests->HR_DEPARTMENT_SUB_SUB_NAME }}
                    </td>
                    <td width="50%">
                        มีความประสงค์ขอเบิกวัสดุ &nbsp;{{ $inforwarehouserequests->WAREHOUSE_REQUEST_BUY_COMMENT }}
                    </td>
                </tr>
            </table>
            <table width="100%">
                <tr>
                    <td width="100%">
                        ผู้ป่วยที่เข้ามารับบริการของโรงพยาบาล ประจำเดือน &nbsp;
                        {{ DateThaimount($inforwarehouserequests->WAREHOUSE_DATE_WANT) }} &nbsp;&nbsp; ตามรายการดังนี้
                    </td>
                </tr>
            </table>
        <main>
            <table width="100%" class="one" style="margin-top: 7px;">
                <thead>
                    <tr>
                        <td width="8%" class="o" rowspan="2">
                            <center>ที่</center>
                        </td>
                        <td width="44%" class="o" rowspan="2">
                            <center>รายการ</center>
                        </td>
                        <td width="30%" class="o" colspan="3">
                            <center>จำนวน</center>
                        </td>
                        <td width="16%" class="o" rowspan="2">
                            <center>ราคา / <br> หน่วย</center>
                        </td>
                        <td class="o" rowspan="2">
                            <center>ราคารวม</center>
                        </td>
                        <td class="o" rowspan="2">
                            <center>หมายเหตุ</center>
                        </td>
                    </tr>
                    <tr>
                        <td width="10%" class="o">
                            <center>หน่วย</center>
                        </td>
                        <td width="10%" class="o">
                            <center>เบิก</center>
                        </td>
                        <td width="10%" class="o">
                            <center>อนุมัติ</center>
                        </td>
                    </tr>
                </thead>
                <tbody>
            
                    <?php 
                        $idrequest41 = $idcount +42;$idrequest42 = $idcount +43;$idrequest43 = $idcount +44;$idrequest44 = $idcount +45;$idrequest45 = $idcount +46;
                        $idrequest46 = $idcount +47;$idrequest47 = $idcount +48;$idrequest48 = $idcount +49;$idrequest49 = $idcount +50;$idrequest50 = $idcount +51;
                        $idrequest51 = $idcount +52;$idrequest52 = $idcount +53;$idrequest53 = $idcount +54;$idrequest54 = $idcount +55;$idrequest55 = $idcount +56;
                        $idrequest56 = $idcount +57;$idrequest57 = $idcount +58;$idrequest58 = $idcount +59;$idrequest59 = $idcount +60;$idrequest60 = $idcount +61;
                        $idrequest61 = $idcount +62;$idrequest62 = $idcount +63;$idrequest63 = $idcount +64;$idrequest64 = $idcount +65;$idrequest65 = $idcount +66;
                        $warehouserequest_page = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                        ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                        ->get();                                    
                    ?>

                    <?php $i = 60; ?>
                    @foreach ($warehouserequest_page as $items)
                        <?php $i++; ?>  
                        
                            @if ($i == 61) 
                                <?php 
                                    $getdata41 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest41) 
                                            ->first(); 
                                ?>
                                    @if ($getdata41 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata41->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata41->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata41->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata41->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata41->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata41->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif             
                            @elseif ($i == 62) 
                                    <?php 
                                        $getdata42 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest42) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata42 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata42->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata42->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata42->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata42->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata42->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata42->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif              
                            @elseif ($i == 63) 
                                    <?php 
                                        $getdata43 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest43) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata43 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata43->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata43->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata43->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata43->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata43->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata43->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 64) 
                                <?php 
                                    $getdata44 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                            ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                            ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest44) 
                                            ->first(); 
                                ?>
                                @if ($getdata44 != '') {
                                    <tr height="1px">
                                        <td class="o" width="8%">
                                            <center>{{ $i }}</center>
                                        </td>
                                        <td class="o" width="47%">
                                            &nbsp;{{ $getdata44->SUP_NAME }}                                               
                                        </td> 
                                        <td class="o" width="10%">                                               
                                            <center>{{ $getdata44->SUP_UNIT_NAME }}</center>   
                                        </td> 
                                        <td class="o" width="5%">                                                                                                          
                                            <center>{{ $getdata44->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                        </td> 
                                        <td class="o" width="5%">
                                            <center> {{ $getdata44->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                        </td> 
                                        <td class="o" width="10%" style="text-align: right">
                                            {{ number_format($getdata44->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                        </td> 
                                        <td class="o" width="10%" style="text-align: right">
                                            {{ number_format($getdata44->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                        </td> 
                                        <td class="o" width="5%">
                                            <center></center>
                                        </td> 
                                    </tr>
                                    }
                                @endif 
                            @elseif ($i == 65) 
                                    <?php 
                                        $getdata45 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest45) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata45 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata45->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata45->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata45->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata45->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata45->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata45->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 66) 
                                    <?php 
                                        $getdata46 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest46) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata46 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata46->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata46->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata46->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata46->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata46->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata46->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 67) 
                                    <?php 
                                        $getdata47 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest47) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata47 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata47->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata47->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata47->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata47->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata47->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata47->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif 
                            @elseif ($i == 68) 
                                    <?php 
                                        $getdata48 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest48) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata48 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata48->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata48->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata48->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata48->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata48->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata48->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 69) 
                                    <?php 
                                        $getdata49 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest49) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata49 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata49->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata49->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata49->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata49->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata49->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata49->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 70) 
                                    <?php 
                                        $getdata50 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest50) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata50 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata50->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata50->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata50->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata50->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata50->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata50->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 71) 
                                    <?php 
                                        $getdata51 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest51) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata51 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata51->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata51->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata51->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata51->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata51->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata51->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 72) 
                                    <?php 
                                        $getdata52 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest52) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata52 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata52->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata52->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata52->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata52->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata52->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata52->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 73) 
                                    <?php 
                                        $getdata53 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest53) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata53 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata53->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata53->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata53->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata53->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata53->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata53->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif

                            @elseif ($i == 74) 
                                    <?php 
                                        $getdata54 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest54) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata54 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata54->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata54->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata54->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata54->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata54->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata54->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 75) 
                                    <?php 
                                        $getdata55 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest55) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata55 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata55->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata55->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata55->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata55->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata55->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata55->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 76) 
                                    <?php 
                                        $getdata56 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest56) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata56 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata56->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata56->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata56->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata56->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata56->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata56->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 77) 
                                    <?php 
                                        $getdata57 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest57) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata57 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata57->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata57->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata57->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata57->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata57->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata57->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 78) 
                                    <?php 
                                        $getdata58 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest58) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata58 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata58->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata58->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata58->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata58->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata58->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata58->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 79) 
                                    <?php 
                                        $getdata59 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest59) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata59 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata59->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata59->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata59->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata59->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata59->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata59->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif
                            @elseif ($i == 80) 
                                    <?php 
                                        $getdata60 = DB::table('warehouse_request_sub')->leftJoin('supplies','warehouse_request_sub.WAREHOUSE_REQUEST_SUB_DETAIL_ID','=','supplies.ID')
                                                ->leftJoin('supplies_unit_ref','supplies.ID','=','supplies_unit_ref.SUP_ID')->where('supplies_unit_ref.SUP_TOTAL','=','1')->where('WAREHOUSE_REQUEST_ID','=', $idware) 
                                                ->where('WAREHOUSE_REQUEST_SUB_ID','=', $idrequest60) 
                                                ->first(); 
                                    ?>
                                    @if ($getdata60 != '') {
                                        <tr height="1px">
                                            <td class="o" width="8%">
                                                <center>{{ $i }}</center>
                                            </td>
                                            <td class="o" width="47%">
                                                &nbsp;{{ $getdata60->SUP_NAME }}                                               
                                            </td> 
                                            <td class="o" width="10%">                                               
                                                <center>{{ $getdata60->SUP_UNIT_NAME }}</center>   
                                            </td> 
                                            <td class="o" width="5%">                                                                                                          
                                                <center>{{ $getdata60->WAREHOUSE_REQUEST_SUB_AMOUNT }}</center>
                                            </td> 
                                            <td class="o" width="5%">
                                                <center> {{ $getdata60->WAREHOUSE_REQUEST_SUB_AMOUNT_PAY }} </center>
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata60->WAREHOUSE_REQUEST_SUB_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="10%" style="text-align: right">
                                                {{ number_format($getdata60->WAREHOUSE_REQUEST_SUB_SUM_PRICE, 2) }}&nbsp;
                                            </td> 
                                            <td class="o" width="5%">
                                                <center></center>
                                            </td> 
                                        </tr>
                                        }
                                    @endif


                            @else
                            @endif
                                                                                        
                    @endforeach                        
                    @if($count < 80 ) 
                        <tr>
                            <td width="5%" class="o" colspan="6">
                                <center></center>
                            </td>
                            <td width="20%" class="o" style="text-align: right">
                                {{ number_format($warehouserequest_sum, 2) }}&nbsp;
                            </td>
                            <td width="20%" class="o">
                            </td>
                        </tr>    
                    @endif                    
                </tbody>
            </table>
        </main>
    @endif

    @if($count > 60)

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
    <table width="100%" style="margin-top: 5px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp; {{ $inforwarehouserequests->WAREHOUSE_SAVE_HR_NAME }} &nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="9%"></td>
            <td width="31%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 2px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp; {{ DateThai($inforwarehouserequests->WAREHOUSE_DATE_WANT) }}
                    &nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="5%"></td>
            <td width="35%">
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 40px">
        <tr>
            <td width="5%"></td>
            <td width="35%">
                ลงชื่อ.............................................................
            </td>
            <td width="10%">
                ผู้รับพัสดุ
            </td>
            <td width="5%"></td>
            <td width="35%">
                ลงชื่อ.............................................................
            </td>
            <td width="10%">
                ผู้สั่งจ่าย
            </td>
        </tr>
    </table>
    <table width="100%" style="margin-top: 5px">
        <tr>
            <td width="8%"></td>
            <td width="32%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
            <td width="9%"></td>
            <td width="31%" style="text-align: center">
                <label for="">(&nbsp;.............................................................&nbsp;)</label>
            </td>
            <td width="10%">
            </td>
        </tr>
    </table>     

    @endif
   

  


</body>

</html>
