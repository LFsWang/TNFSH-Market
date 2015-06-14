<?php
require_once('GlobalSetting.php');
//api only return json format data


//UserAccess::SetToken('api',900);
#
UserAccess::CheckToken('api');
$action = @$_REQUEST['action'];

$case = array(
    'user' => array( 'login' , 'logout' ),
);

foreach( $case as $subpage => $act )
{
    if( in_array($action,$act) )
    {
        if( file_exists("function/$subpage/$subpage.php") )
        {
            require_once("function/$subpage/$subpage.php");
            exit(0);
        }
    }
}

//ADMIN API
$case = array( 'getgoodinfo' , 'getgoodlist' , 'editimage' , 'addadmin' ,'addsgroup','addsastudent');
if( in_array($action,$case) )
{
    if( $_G['usertype'] != 2 )
    {
        throwjson('error','Access denied!');
    }
    if( file_exists("function/adminapi/$action.php") )
    {
        require_once("function/adminapi/$action.php");
        exit(0);
    }
}
throwjson('error','Error:7122');