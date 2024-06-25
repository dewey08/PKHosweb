<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <!-- Styles -->

</head>

<body>

  <?php

    $output_filename = "xxx.zip";

    // $host = "http://127.0.0.1:81/gtw/api/download/63.10.26.zip"; /// old
    $host = "http://127.0.0.1/gtw/api/download/63.10.26.zip";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $host);
    curl_setopt($ch, CURLOPT_VERBOSE, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_AUTOREFERER, false);
    curl_setopt($ch, CURLOPT_REFERER, "http://127.0.0.1"); //"http://127.0.0.1:81"
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    $result = curl_exec($ch);
    curl_close($ch);

    // print_r($result); // prints the contents of the collected file before writing..


    // // the following lines write the contents to a file in the same directory (provided permissions etc)
    $fp = fopen($output_filename, 'w');
    fwrite($fp, $result);
    fclose($fp);
?>
  <?php
  
//   $url = "http://127.0.0.1:8080/back.zip";
//   $zip_file = "folder/downloadfile.zip";

// // $zip_resource = fopen($zipFile, "w");

// $ch_start = curl_init();
// curl_setopt($ch_start, CURLOPT_URL, $url);
// // curl_setopt($ch_start, CURLOPT_FAILONERROR, true);
// // curl_setopt($ch_start, CURLOPT_HEADER, 0);
// // curl_setopt($ch_start, CURLOPT_FOLLOWLOCATION, true);
// // curl_setopt($ch_start, CURLOPT_AUTOREFERER, true);
// // curl_setopt($ch_start, CURLOPT_BINARYTRANSFER,true);
// // curl_setopt($ch_start, CURLOPT_TIMEOUT, 10);
// // curl_setopt($ch_start, CURLOPT_SSL_VERIFYHOST, 0);
// // curl_setopt($ch_start, CURLOPT_SSL_VERIFYPEER, 0); 
// // curl_setopt($ch_start, CURLOPT_FILE, $zip_resource);
// // $page = curl_exec($ch_start);
// // if(!$page)
// // {
// //  echo "Error :- ".curl_error($ch_start);
// // }
// // curl_close($ch_start);

// $zip = new ZipArchive;
// $extractPath = "./";
// // if($zip->open($zipFile) != "true")
// // {
// //  echo "Error :- Unable to open the Zip File";
// // } 

// $zip->extractTo($extractPath);
// $zip->close();


  ?>

</body>
</html>
