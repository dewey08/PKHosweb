<link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' /> 
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
<style>

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;   
        }

   
</style>
<?php

    use SimpleSoftwareIO\QrCode\Facades\QrCode;

    ?>
<body onload="window.print()">
    
    <table> 
        <tr >
            <td> 


                {!! QrCode::size(112)->encoding('UTF-8')
                ->generate(asset('/manager_asset/assetinfomation/'.$infoasset->ARTICLE_ID));
                !!}

            </td> 
            <td style="font-family: 'Kanit', sans-serif;font-size: 14px;font-style: nomal;">  
                {{ $infoasset->ARTICLE_NUM }}<br> 
                {{ $infoasset->ARTICLE_NAME }} <br>{{ number_format($infoasset->PRICE_PER_UNIT,2) }} ::  {{ formate($infoasset->RECEIVE_DATE) }}<br> 
                {{ $infoasset->HR_DEPARTMENT_SUB_SUB_NAME }} 
            </td> 
        </tr>
    </table>    
  
</body>
        
                     
