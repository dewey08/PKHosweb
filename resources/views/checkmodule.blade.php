
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <title>test</title>
</head>
<body>


<?php 



    $urlWithoutProtocol = "http://27.254.191.157:81/gtwapi/checkmodule_info";
    $request         = "";
    $isRequestHeader = false;
 
    $exHeaderInfoArr   = array();
    $exHeaderInfoArr[] = "Content-type: text/xml";
    $exHeaderInfoArr[] = "Authorization: "."Basic ".base64_encode("authen_user:authen_pwd");
 
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $urlWithoutProtocol);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $request);
    curl_setopt($ch, CURLOPT_HEADER, (($isRequestHeader) ? 1 : 0));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   
    $response = curl_exec($ch);
    curl_close($ch);
 
    echo $response;


    
?>

</body>
</html>