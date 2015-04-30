<?php
require_once('GlobalSetting.php');

//addAdminAccount('admin','admin');
if( $_G['usertype'] != 2 )
{
    header("Location:index.php");
}
$allow_page = array('index','goods','edit_system_announcement');
$page = 'index';
if( isset($_REQUEST['page']) )
{
    $page = $_REQUEST['page'];
}

if( in_array($page,$allow_page) )
{
    if( file_exists("function/admin/$page.php") )
    {
        require_once("function/admin/$page.php");
    }
    else
    {
        Render::render($page,'admin');
    }
    exit(0);
}


Render::render('developing','admin');