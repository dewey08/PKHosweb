<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <style>
        @font-face {
            font-family: 'THSarabunNew';  
            font-style: normal;
            font-weight: normal;  
            src: url("{{ asset('fonts/THSarabunNew.ttf') }}") format('truetype');
        }

  
 
        body {
            font-family: "THSarabunNew";
            font-size: 18px;
            line-height: 1;
            padding: 28.3465pt 7.1732pt 7.1732pt 56.6929pt;
       
        }

        .text-pedding{
            padding-left:10px;
            padding-right:10px;
                }
            .text-right{
                padding-right:50px;   
            }    
    </style>
    <?php

    function RemovethainumDigit($num){
        return str_replace(array( '0' , '1' , '2' , '3' , '4' , '5' , '6' ,'7' , '8' , '9' ),array( "o" , "๑" , "๒" , "๓" , "๔" , "๕" , "๖" , "๗" , "๘" , "๙" ),$num);
    }

    function Removeconvert($number){ 
        $txtnum1 = array('ศูนย์','หนึ่ง','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า','สิบ'); 
        $txtnum2 = array('','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน','สิบ','ร้อย','พัน','หมื่น','แสน','ล้าน'); 
        $number = str_replace(",","",$number); 
        $number = str_replace(" ","",$number); 
        $number = str_replace("บาท","",$number); 
        $number = explode(".",$number); 
        if(sizeof($number)>2){ 
        return ''; 
        exit; 
        } 
        $strlen = strlen($number[0]); 
        $convert = ''; 
        for($i=0;$i<$strlen;$i++){ 
            $n = substr($number[0], $i,1); 
            if($n!=0){ 
                if($i==($strlen-1) AND $n==1){ $convert .= 'เอ็ด'; } 
                elseif($i==($strlen-2) AND $n==2){  $convert .= 'ยี่'; } 
                elseif($i==($strlen-2) AND $n==1){ $convert .= ''; } 
                else{ $convert .= $txtnum1[$n]; } 
                $convert .= $txtnum2[$strlen-$i-1]; 
            } 
        } 
        
        $convert .= 'บาท'; 
        if($number[1]=='0' OR $number[1]=='00' OR 
        $number[1]==''){ 
        $convert .= 'ถ้วน'; 
        }else{ 
        $strlen = strlen($number[1]); 
        for($i=0;$i<$strlen;$i++){ 
        $n = substr($number[1], $i,1); 
            if($n!=0){ 
            if($i==($strlen-1) AND $n==1){$convert 
            .= 'เอ็ด';} 
            elseif($i==($strlen-2) AND 
            $n==2){$convert .= 'ยี่';} 
            elseif($i==($strlen-2) AND 
            $n==1){$convert .= '';} 
            else{ $convert .= $txtnum1[$n];} 
            $convert .= $txtnum2[$strlen-$i-1]; 
            } 
        } 
        $convert .= 'สตางค์'; 
        } 
        return $convert; 
            } 


                function DateThaifrom($strDate)
            {
            $strYear = date("Y",strtotime($strDate))+543;
            $strMonth= date("n",strtotime($strDate));
            $strDay= date("j",strtotime($strDate));

            $strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤษจิกายน","ธันวาคม");
            $strMonthThai=$strMonthCut[$strMonth];
            return $strDay.' '.$strMonthThai.'  พ.ศ. '.$strYear;
            }
    ?>

<style>
     @page {
                margin: 0cm 0cm;
            }
     body {
                margin-top:    1cm;
                margin-bottom: 1cm;
                margin-left:   1cm;
                margin-right:  1cm;
            }
    /* #watermark { position: fixed;top:0px; bottom: 0px; right: 10px; left:0px; width: 1100px; height: 800px; opacity: .1; } */
    #watermark {     
        position: fixed;
                bottom:   0px;
                left:     0px;
                /** The width and height may change 
                    according to the dimensions of your letterhead
                **/
                width:    29.5cm;
                height:   21cm;
                /* width:    21.8cm;
                height:   28cm; */

                /** Your watermark should be behind every content**/
                z-index:  -1000;
    }
    /* body {
        background-image: url(image/Pngtree.png); /* Path to background image */
        /* width="100%"; */
} */
  </style>
</head>
<?php
use App\Models\Org; 
$org = Org::find(1);
?>
<body >
    <div id="watermark"><img src="{{ asset('image/bg_grob.png') }}" height="100%" width="100%"></div>
<center>
    @if ( $org->img_logo == Null )
    <img id="image_upload_preview" src="{{asset('img/pers.png')}}" height="80" width="80"> 
    @else
    <img id="image_upload_preview" src="data:img/png;base64,{{ chunk_split(base64_encode($org->img_logo)) }}" height="80" width="110"> 
    @endif   
    <br>
    <label for="" style="font-size:25px;"><b>ใบอนุโมทนาบัตร</b></label>
    <br>
    <label for="" style="font-size:17px;"><b>หนังสือฉบับนี้ไห้ไว้เพื่อแสดงว่า</b></label>
    <br>
    <label for="" style="font-size:22px;"><b>{{$infocongrat->DONATE_PERSON_NAME}}</b></label>
   
</center>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="" style="font-size:25px;">เป็นผู้มีจิตศรัทธาบริจาค  &nbsp;&nbsp;{{$infocongrat->PERSON_DONATE_SUB_DETAIL}}  &nbsp;&nbsp;เป็นจำนวน &nbsp;&nbsp;{{$infocongrat->PERSON_DONATE_SUB_QTY}}   &nbsp;&nbsp;  {{$infocongrat->DONATIONUNIT_NAME}}</label>     <br>
&nbsp;&nbsp;&nbsp;<label for="" style="font-size:25px;">เพื่อใช้สำหรับ : &nbsp;&nbsp;{{$infocongrat->PERSON_DONATE_SUB_COMENT}}</label>
<br>
&nbsp;&nbsp;&nbsp;<label for="" style="font-size:25px;">หน่วยรับบริจาค :&nbsp;&nbsp; {{$infoorg->ORG_NAME}}</label>
&nbsp;&nbsp;&nbsp;<label for="" style="font-size:25px;">ที่อยู่ &nbsp;&nbsp;{{$infoorg->ORG_ADDRESS}}</label>
&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;<label for="" style="font-size:25px;">อำเภอ/เขต &nbsp;&nbsp;{{$infoorg->DISTRICT}}</label>
&nbsp;&nbsp;
&nbsp;<label for="" style="font-size:25px;">จังหวัด &nbsp;&nbsp;{{$infoorg->PROVINCE}}</label>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="" style="font-size:25px;">ขอไห้อานิสงค์ส่วนนี้  &nbsp;&nbsp;จงดลบันดาลไห้ท่านและครอบครัว จงประสบแต่ความสุขความเจริญ ด้วยอายุ วรรณะ สุขะ พละ</label> <br>
<label for="" style="font-size:25px;">ปฎิภาณ ธนสารสมบัติ ลาภยศ สรรเสริญ ตลอดกาลนานเทอญ</label> <br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<label for="" style="font-size:25px;">ไห้ไว้ ณ วันที่ &nbsp;{{DateThaifrom(date('Y-m-d'))}}</label>
<br>
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<center>
    @if ($sig == '')
    ........................................
    @else
        @if($checksig == 1 && $sig !== null && $sig !== '')
        <img src="{{Storage::path('public/images/'.$sig)}}" width="100" height="50">
        @endif 
    @endif
<br>
<label for="" style="font-size:25px;">({{$orgname->HR_PREFIX_NAME}} {{$orgname->HR_FNAME}} {{$orgname->HR_LNAME}})</label>
<br>
<label for="" style="font-size:25px;">ผู้มีอำนวยการ {{$orgname->ORG_NAME}}</label>
<br>
</center>
{{-- <br>
<center>
<img src="image/Congrat2.jpg" width="400" height="50">
    </center> --}}
{{-- </div> --}}
</body>
</html>