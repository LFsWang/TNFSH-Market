<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<!DOCTYPE html>
<head>
    <meta charset='utf-8'>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if( isset($tmpl['title'] ) ): ?>
    <title><?=$tmpl['title']?></title>
    <?php else: ?>
    <title><?=$_E['site']['name']?></title>
    <?php endif; ?>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/css.css">
    <style>
    body{
        background-image: url('src/index-background.jpg');
        background-size: cover;
        background-repeat:no-repeat;
        background-attachment:fixed;
    }
    </style>
    <!--[if lt IE 9]>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/js.js"></script>
    <script>
    var getLocation = function(href) {
        var l = document.createElement("a");
        l.href = href;
        return l;
    };
    var host = getLocation("https://sp.tnfsh.tn.edu.tw").hostname;
    if ((host == window.location.host) && (window.location.protocol != "https:"))
        window.location.protocol = "https";
    </script>
    <script>
        $('.dropdown-toggle').dropdown();
    </script>
</head>
<noscript style="color:#FFF;font-size:100px">我要JAVASCRIPT~ QQ</noscript>