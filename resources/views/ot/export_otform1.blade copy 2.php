<?php
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="โอที.xls"'); //ชื่อไฟล์ 
 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table style="border-color:black" width="100%">  
        {{-- <thead style="background-color: #FFEBCD;border-color: black">  --}}
            <tr height="5px" style="border-color:black">
                <td width="5%" style="font-family: 'Kanit', sans-serif;">ลำดับ</td> 
                <td width="15%" style="font-family: 'Kanit', sans-serif;">ชื่อ-นามสกุล</td> 
                <td width="10%" style="font-family: 'Kanit', sans-serif;">รายมือชื่อ</td>   
                <td width="10%" style="font-family: 'Kanit', sans-serif;">เวลามา</td> 
                <td width="10%" style="font-family: 'Kanit', sans-serif;">รายมือชื่อ</td> 
                <td width="10%" style="font-family: 'Kanit', sans-serif;">เวลากลับ</td>  
                <td width="40%" style="font-family: 'Kanit', sans-serif;">หน้าที่ที่ปฎิบัติ</td>     
            </tr>  
            
        {{-- </thead>   --}}
        {{-- <tbody>
            <?php $i = 1; ?>
            @foreach ($ot_one as $item) 
                <tr>
                    <td style="font-family: 'Kanit', sans-serif;">{{ $i++ }}</td> 
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->prefix_name }} {{ $item->fname }} {{ $item->lname }}</td>
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->ot_one_sign }} </td>
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->ot_one_starttime }}</td>
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->ot_one_sign2 }} </td>
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->ot_one_endtime }} </td> 
                    <td style="font-family: 'Kanit', sans-serif;">{{ $item->ot_one_detail }}</td> 
                </tr>
            @endforeach
        </tbody>   --}}
    </table>
    
</body>
</html>
  
 
   
   