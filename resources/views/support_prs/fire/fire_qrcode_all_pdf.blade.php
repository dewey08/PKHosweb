 <!doctype html>
    <html lang="en">
      <head>
        {{-- <meta charset="utf-8"> --}}
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>QrCode All</title>

    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css' />
    <link href='https://fonts.googleapis.com/css?family=Kanit&subset=thai,latin' rel='stylesheet' type='text/css'>
    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
</head>
<style>
    body {
        font-family: 'Kanit', sans-serif;
        font-size: 14px;
    }

    /* border-radius: 2em 2em 2em 2em;
     box-shadow: 0 0 10px rgb(250, 128, 124);
     border:solid 1px #80acfd; */
</style>
<?php
use SimpleSoftwareIO\QrCode\Facades\QrCode;
?>

<body>

    <div class="container-fluid text-center">

        <div class="row ">
            <?php $i = 1; ?>
            @foreach ($dataprint as $item)
                <?php $i++; ?>

                <div class="col-md-2">
                    
                    <div class="card mb-3"
                        style="width:10rem;border-color:rgb(114, 187, 5);background-color:rgb(250, 241, 210);border-radius: 2em 2em 2em 2em">
                        <div class="card-body">
                            <br>
                            <?php $qrcode = base64_encode(
                                QrCode::format('svg')
                                    ->size(90)
                                    ->generate($item->fire_id),
                            ); ?>
                            {{-- {!!QrCode::size(112)->generate(" $item->fire_id ")!!}   --}}
                            <img src="data:image/png;base64, {!! $qrcode !!}">
                            <hr style="color:rgb(6, 172, 108)">
                            <p style="font-size: 17px;color:rgb(6, 172, 108)"> รหัส {{ $item->fire_num }} <br>
                                แสกนตรวจสอบ<br>
                                สำหรับเจ้าหน้าที่</p>
                        </div>
                    </div>

                </div>
            @endforeach
     
        </div>

    </div>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script> --}}

</body>

</html>
