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


    <link rel="apple-touch-icon" sizes="57x57" href="/caisses/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="/caisses/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="/caisses/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="/caisses/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="/caisses/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="/caisses/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="/caisses/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="/caisses/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/caisses/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="/caisses/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/caisses/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="/caisses/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/caisses/favicon-16x16.png">
    <link rel="manifest" href="/caisses/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/caisses/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

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