<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    throwjson('error','Error:7122');
}
if( !$_G['root'] )
{
    throwjson('error','Error:'.ERROR_PREMISSION_DENIED);
}
require_once($_E['ROOT'].'/function/admin/admin.lib.php');
require_once($_E['ROOT'].'/function/user/user.lib.php');
$gid = safe_post('gid');
$odid= safe_post('odid');
$num = safe_post('num');

$tsaccount_group = SQL::tname('saccount_group');
$tstudent_account= SQL::tname('student_account');

if( !makeint($gid) || !makeint($odid) || !makeint($num) )
{
    throwjson('error',"數值錯誤");
}
$good = GetGoodByGID($gid);
if( !$good )
{
    throwjson('error',"無此商品");
}
if( $num < 0 ||  $good['maxnum'] < $num )
{
    throwjson('error',"數量錯誤 需介於0~".$good['maxnum']);
}
$torderlist_detail = SQL::tname('orderlist_detail');
if( !SQL::query("SELECT `odid` FROM `$torderlist_detail` WHERE `odid`=? AND `gid`=?",array($odid,$gid)) )
{
    throwjson('error',"無此訂單");
}

if( !SQL::query("UPDATE `$torderlist_detail` SET `num`=? WHERE `odid`=? AND `gid`=?",array($num,$odid,$gid)) )
{
    throwjson('error',"SQL error");
}
throwjson('SUCC',"SUCC");
