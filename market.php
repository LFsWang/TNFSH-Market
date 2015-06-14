<?php
require_once('GlobalSetting.php');

if( $_G['usertype'] != 1 )
{
    header("Location:index.php");
}
require_once("function/market/market.lib.php");
$allow_page = array('index','check');
$page = 'index';
if( isset($_REQUEST['page']) )
{
    $page = $_REQUEST['page'];
}
require_once("function/market/panel.php");
if( in_array($page,$allow_page) )
{
    if( file_exists("function/market/$page.php") )
    {
        require_once("function/market/$page.php");
    }
    else
    {
        Render::render($page,'market');
    }
    exit(0);
}


Render::render('index','market');