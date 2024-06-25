<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{$label}}</title>
</head>
<style>
body{

    font-family: 'Courier New', Courier,monospace;
    text-align:center;
}
</style>
<body onload="window.print()">
    <img src="data:image/png;base64,{{ base64_encode($barcode) }}">
    <br>{{ $label }}
</body>
</html>