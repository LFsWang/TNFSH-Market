<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    exit('Access denied (T)');
}
require_once($_E['ROOT'].'/function/admin/admin.lib.php');

$lid = safe_get('lid');
if( !is_numeric($lid) )
{
    throwjson('error','lid error!');
}
$lid = (int)$lid;
$tgoodlist = SQL::tname('goodlist');
$sql_select = "SELECT `lid` FROM `$tgoodlist` WHERE `lid` = ? AND ( `owner` = ? OR ? )";
if( $res = SQL::fetch($sql_select,array($lid,$_G['uid'],$_G['root'])) )
{
    if( !$res['lid'] )
    {
        throwjson('error','Access Denied!');
    }
}
else
{
    throwjson('error','SQL ERROR');
}

$res = GetGoodlistByLID($lid);
if( !$res )
{
    throwjson('error','data error');
}

throwjson('SUCC',$res);
