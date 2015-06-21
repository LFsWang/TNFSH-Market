<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8'>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if( isset($tmpl['title'] ) ): ?>
    <title><?=$tmpl['title']?></title>
    <?php else: ?>
    <title><?=$_E['site']['name']?></title>
    <?php endif; ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <style>
    body { height:297mm; width:210mm; margin-left:auto; margin-right:auto; }
    </style>
</head>
<body>
    <div class = "containor">
        <div class = "row">