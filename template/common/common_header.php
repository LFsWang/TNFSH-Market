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
    <title><?=$_E['site']['name']?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script>
        $('.dropdown-toggle').dropdown();
    </script>
    <style>
        body{
            background-image: url('src/index-background.jpg');
            background-size: cover;
            background-repeat:no-repeat;
            background-attachment:fixed
        }
    </style>
</head>