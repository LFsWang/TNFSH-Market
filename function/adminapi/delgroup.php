<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    exit('Access denied (T)');
}
$gpid = safe_post('gpid');
if( !makeint($gpid) )
{
    throwjson('error','gpid error!');
}
$tsaccount_group = SQL::tname('saccount_group');

if( !SQL::query("DELETE FROM `$tsaccount_group` WHERE `gpid` = ?",array($gpid)) )
{
    throwjson('error','SQL錯誤');
}
SQL::log('del group','DEL GROUP : '.$gpid);
throwjson('SUCC','');


