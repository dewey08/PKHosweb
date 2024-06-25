<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>Laravel QR Code Example</title>
</head>
<body>

<div class="text-center" style="margin-top: 50px;">
    <h3>Laravel QR Code Example</h3>

    {!! QrCode::size(300)->generate('7440-001-0006/63.01 <br>DATE 15/01/1993 '); !!}

    <p>MyNotePaper12345641231</p>
</div>

</body>
</html>