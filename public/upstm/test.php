<html>
<body>
<style>
.myDiv {
	width: 700px;
	height: 200px;
  border: 1px;
  margin: 0 auto;
  background-color: lightblue;    
  text-align: center;
  font-size:36;
}
</style>
<?php
$range = range("A", "Z");
//for ($i=A; $i<N; $i++) {
    foreach ($range as $letter) {
 //     print("$i$letter\n");
    	echo "A".$letter."<BR>";
    }
//echo $range;
//}
?>

</body>
</html>