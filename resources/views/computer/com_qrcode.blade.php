{{-- <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />  --}}
    {{-- <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'> --}}
<style>

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;   
        }   
</style>
<?php
    use SimpleSoftwareIO\QrCode\Facades\QrCode;

        // แปลงวันที่ภาษาไทย
        function DateThailand($strDate)
        {
            if($strDate == '' || $strDate == null || $strDate == '0000-00-00'){
                $datethai = '';
            }else{
                $strYear = date("Y",strtotime($strDate))+543;
                $strMonth= date("n",strtotime($strDate));
                $strDay= date("j",strtotime($strDate));
                $strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
                $strMonthThai=$strMonthCut[$strMonth];
                $datethai = $strDate ? ($strDay.' '.$strMonthThai.' '.$strYear) : '-';
            }
            return $datethai;
        }
?>
<body onload="window.print()">
    
    <table> 
        <tr >
            <td >  
            {!! QrCode::size(70)->encoding('UTF-8')->generate(asset('computer/com_repair_add/'.$data_article->article_id)); !!}  
            </td> 
            <td></td>
            <td style="font-family: 'Kanit', sans-serif;font-size: 13px;font-style: nomal;">  
                {{$data_article->article_recieve_date}}<br>
                {{$data_article->article_num }}<br> 
                {{$data_article->article_name }}<br> 
                ราคา {{number_format($data_article->article_price,2)}} บาท  
            </td> 
           
        </tr>
    </table>    
  
</body>
     
                     
