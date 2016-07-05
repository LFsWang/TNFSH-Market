<?php
require_once('GlobalSetting.php');
//api only return json format data


//UserAccess::SetToken('api',900);
UserAccess::CheckToken('api');
$action = @$_REQUEST['action'];

$case = array('login' , 'logout' , 'modifyspass','delsorder');


if( in_array($action,$case) )
{
    if( file_exists("function/user/$action.php") )
    {
        require_once("function/user/$action.php");
        exit(0);
    }
}


//ADMIN API
if( $_G['usertype'] != 2 )
{
    throwjson('error','Access denied!');
}

$case = array( 'getgoodinfo' , 'getgoodlist' , 'editimage', 'delimage' , 'addadmin' ,'addsgroup','addsastudent','modifyastudent','delorder','cg-num','modifysgroup','importacct','importclass','delgroup');
if( in_array($action,$case) )
{
    if( file_exists("function/adminapi/$action.php") )
    {
        require_once("function/adminapi/$action.php");
        exit(0);
    }
}
throwjson('error','Error:No such action');