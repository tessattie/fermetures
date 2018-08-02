
<?php require 'C:\wamp\www\caisses\app\views\header.php'; ?>

<?php require 'C:\wamp\www\caisses\app\views\menu.php'; ?>

<?php 
	if(!empty($data["reportType"])){
		include 'C:\wamp\www\caisses\app\views\reports/' . $data["reportType"] . '.php';
	}
?>

<?php require 'C:\wamp\www\caisses\app\views\footer.php'; ?>

