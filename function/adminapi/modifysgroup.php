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

$gpid = safe_post('gpid');
$title = safe_post('title');
$hidden = safe_post('hidden');

if( !makeint($gpid) )
{
    throwjson('error','Error:gpid');
}
$hidden = $hidden?1:0;

$tsaccount_group = SQL::tname('saccount_group');
if( SQL::query("UPDATE $tsaccount_group SET `title`=?,`hidden`=? WHERE `gpid`=?",array($title,$hidden,$gpid)) )
{
    throwjson('SUCC','');
}
else
{
    throwjson('error','SQL error!');
}
