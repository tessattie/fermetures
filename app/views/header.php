<!DOCTYPE html>
<html>
<head>
	<title>CARIBBEAN - CAISSES</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" href="/caisses/public/bootstrap/css/bootstrap.min.css">
	<link rel="stylesheet" href="/caisses/public/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css">
	<link rel="stylesheet" href="/caisses/public/bootstrap/css/bootstrap-theme.css">
	<link rel="stylesheet" href="/caisses/public/bootstrap/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="/caisses/public/css/style.css">
	<link rel="stylesheet" href="/caisses/public/css/BootSideMenu.css">
    <link rel="stylesheet" href="/caisses/public/css/BootSideMenu.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<style type="text/css">
        .user {
            padding: 5px;
            margin-bottom: 5px;
            text-align: center;
        }
    </style>
    <?php if($_SESSION['caisses']['id'] == 15) : ?>
    	<script type="text/javascript">
    	var push = false;
    	var rem = false;
    	var autoc = true;
    	</script>
    <?php else : ?>
    	<script type="text/javascript">
    	var push = true;
    	var rem = true;
    	var autoc = false;
    	</script>
    <?php endif; ?>
</head>
<body>
<div class="container-fluid">