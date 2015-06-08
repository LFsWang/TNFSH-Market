<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    throwjson('error','Error:7122');
}
require_once($_E['ROOT'].'/function/admin/admin.lib.php');

//val by post
#action : editimg
#imgid  : (int)
#title  : (string)
#description : (string)

$imgid = safe_post('imgid');
$title = safe_post('title');
$description = safe_post('description');

$res = modifyImageInfo( array( 'title' => $title , 'description' => $description ) , $imgid );
if( $res === ERROR_NO )
{
    throwjson('SUCC',$imgid);
}
else
{
    throwjson('error',"error code : $res");
}