<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>QrCode All</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<style>
    @page {
        margin: 40px;
        margin-bottom: 1px;
        margin-left: 15px;
        margin-right: 15px;
    }

    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
        /* line-height: 0.7; */
        /* margin-top: 1cm; */
        /* margin-bottom: 1.5cm;
        margin-left: 2cm;
        margin-right: 2cm; */
    }



    /* @media all {
        .page-break {
            display: none;
        }

        .page-break-no {
            display: none;
        }
    } */

    /* @media print {
        .page-break {
            display: block;
            height: 1px;
            page-break-before: always;
        }

        .page-break-no {
            display: block;
            height: 1px;
            page-break-after: avoid;
        }
    } */
</style>
<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>

<body>
    {{-- <?php break; ?> --}}
    <body onload="window.print()">
        {{-- <body>  --}}
        <div class="container">
            <div class="row mt-5">

                {{-- @for($count = 1; $count <= $dataprint_main->lastPage(); $count++ ) --}}
                        <?php $i = 0; ?>
                        @foreach ($dataprint_main as $key => $item)
                        <?php $i++; ?>
                                <div class="col-md-2 text-center">
                                    <div class="card mb-3"
                                        style="max-width: 25rem;border-color:rgb(193, 20, 236);background-color:rgb(218, 250, 248);border-radius: 2em 2em 2em 2em">
                                        <div class="body"><br>
                                            {!! QrCode::size(112)->style('round')->generate('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/fire_detail/' . $item->fire_num) !!}
                                            <hr style="color:rgb(193, 20, 236)">
                                            <p style="font-size: 17px;color:rgb(193, 20, 236)"> รหัส {{ $item->fire_num }} <br>
                                                แสกนดูผลตรวจสอบ</p>
                                        </div>
                                    </div>
                                </div>
                               
                            @if ($i === 12) 
                           
                                <?php break; ?>  
                            @endif  
                            
                        @endforeach
                        {{-- @if($count <$dataprint_main->lastPage())
                            <div style="page-break-after:always;"></div>
                        @endif --}}
                {{-- @endfor --}}
                {{-- {{ $dataprint_main->links() }} --}}
            </div>
            <br>  <br>  <br>  <br>  <br>  <br>  <br>  <br>  
                {{-- <div class="row mt-5"> 
                <?php $ii = 12; ?>
                @foreach ($dataprint_main as $key => $item2)
                <?php $ii++; ?>
                        <div class="col-md-2 text-center">
                            <div class="card mb-3"
                                style="max-width: 25rem;border-color:rgb(193, 20, 236);background-color:rgb(218, 250, 248);border-radius: 2em 2em 2em 2em">
                                <div class="body"><br>
                                    {!! QrCode::size(112)->style('round')->generate('http://smarthos-phukieohos.moph.go.th/pkbackoffice/public/fire_detail/' . $item2->fire_num) !!}
                                    <hr style="color:rgb(193, 20, 236)">
                                    <p style="font-size: 17px;color:rgb(193, 20, 236)"> รหัส {{ $item2->fire_num }} <br>
                                        แสกนดูผลตรวจสอบ</p>
                                </div>
                            </div>
                        </div>
                    @if ($ii === 24) 
                        <?php break; ?>  
                    @endif  
                    
                @endforeach


            </div> --}}

        </div>  

        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
            integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous">
        </script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
            integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous">
        </script>
    </body>

</html>
