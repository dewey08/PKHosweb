<?php 
include('../connect/connect.php');
include('../session/session_claim.php');

$sql = "SELECT image FROM patient_image WHERE hn='".$_GET['hn']."' "; 

$result = mysqli_query($con_hos, $sql) or die(mysqli_error($con_hos));
$images = mysqli_fetch_assoc($result);

#echo $images['image'];

if(empty($images['image'])){
	echo include("nopic.jpg");
}elseif (isset($images['image'])) {
	echo $images['image'];
}
?>