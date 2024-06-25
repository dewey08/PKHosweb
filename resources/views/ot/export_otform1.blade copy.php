<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="INFOMATION_ASSET.xls"'); //ชื่อไฟล์

?>


<!-- Advanced Tables -->
<br>
<br>
<br>
<center>
    <div class="block" style="width: 90%;">

        <!-- Dynamic Table Simple -->
        <div class="block block-rounded block-bordered">
            <div class="block-header block-header-default">
                <h3 class="block-title" style="font-family: 'Kanit', sans-serif;"><B>ทะเบียนครุภัณฑ์</B></h3>
                <div align="right">


                </div>
            </div>
            <div class="block-content block-content-full">


                <table class="gwt-table table-striped table-vcenter js-dataTable-simple" style="width: 100%;">
                    <thead style="background-color: #FFEBCD;">
                        <tr style="background-color: #FCFCE5;" height="40">
                            <th style="border-color:#F0FFFF;text-align: center;font-family: 'Kanit', sans-serif;"
                                width="5%">ลำดับ</th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;"
                                width="5%">วันที่</th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;"
                                width="10%">ชื่อ-นามสกุล</th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;"
                                width="5%">รายมือชื่อ</th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;"
                                width="18%">เวลามา</th>

                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;">
                                รายมือชื่อ
                            </th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;">
                                เวลากลับ
                            </th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;">
                                ชั่วโมง
                            </th>
                            <th class="text-font"
                                style="border-color:#050505;text-align: center;font-family: 'Kanit', sans-serif;">
                                หน้าที่ที่ปฎิบัติ
                            </th>
                        </tr>
                    </thead>
                    <tbody>


                    </tbody>
                </table>
            </div>
            <br>
            <div style="font-family: 'Kanit', sans-serif; font-size: 15px;font-size: 1.0rem;font-weight:normal;">จำนวน
                รายการ</div>
        </div>
    </div>
    </div>
