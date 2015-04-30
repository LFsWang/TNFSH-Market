<?php
require_once('GlobalSetting.php');
//api only return json format data

function throwjson($status,$data)
{
    exit( json_encode( array( 'status' => $status , 'data' => $data ) ) );
}
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
throwjson('error','Error:7122');