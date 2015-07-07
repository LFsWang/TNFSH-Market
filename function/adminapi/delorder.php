<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    exit('Access denied (T)');
}
$odid = safe_post('odid');
if( !makeint($odid) )
{
    throwjson('error','odid error!');
}
$torderlist = SQL::tname('orderlist');

if( !SQL::query("DELETE FROM `$torderlist` WHERE `odid` = ?",array($odid)) )
{
    throwjson('error','SQL錯誤');
}
SQL::log('del order','DEL orderlist : '.$odid);
throwjson('SUCC','');


