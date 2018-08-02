<?php include_once 'C:\wamp\www\caisses\app\views\header.php'; ?>

<?php include_once 'C:\wamp\www\caisses\app\views\menu.php'; ?>

<div class="error"><?php echo $data['error']; ?></div>
<?php  
	include "changePassword.php";

	include "editUsersEdit.php";
?>

<?php include_once 'C:\wamp\www\caisses\app\views\footer.php'; ?>