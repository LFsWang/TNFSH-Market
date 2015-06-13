<?php
require_once('GlobalSetting.php');

$allow_page = array('viewgood','develop');
$page = 'index';
if( isset($_REQUEST['page']) )
{
    $page = $_REQUEST['page'];
}

if( in_array($page,$allow_page) )
{
    if( file_exists("function/index/$page.php") )
    {
        require_once("function/index/$page.php");
    }
    else
    {
        Render::render($page,'index');
    }
    exit(0);
}

$system_announcement = getsysvalue('system_announcement');
if( $system_announcement === false )
    $system_announcement = '';
$_E['template']['system_announcement'] = $system_announcement;
Render::render('index','index');