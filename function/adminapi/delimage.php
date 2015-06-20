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

$imgid = safe_post('imgid');
//get image local path
if( !makeint($imgid) )
{
    throwjson('error','imgid error');
}
$res = GetImageNameById( $imgid );

if( !SQL::query('DELETE FROM `image` WHERE `imgid` = ?',array($imgid)) )
{
    throwjson('error',"SQL delete error!");
}

$url = $_E['ROOT'].'/image/'.$res ;
if( is_writable ( $url ) && unlink( $url ) )
{
    SQL::log('delimg','del file : '.$url);
}
else
{
    SQL::log('delimg','fail to del file : '.$url);
}

throwjson('SUCC',"deleted");
