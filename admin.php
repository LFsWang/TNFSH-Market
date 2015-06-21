<?php
require_once('GlobalSetting.php');
//require_once('function/user/user.lib.php');
//addAdminAccount('admin','admin',true);
if( $_G['usertype'] != 2 )
{
    header("Location:index.php?login=adm");
}
require_once('/function/admin/admin.lib.php');

$allow_page = array('index','goods','edit_system_announcement','goodlists','editimg','admininfo','listadmin','goodlists_summary','good_summary','admininfoedit','syslog','saccount_groups','addastudent');
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