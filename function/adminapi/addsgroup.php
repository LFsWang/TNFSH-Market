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
//val by post
#action : addadmin
#title  : (string)
#hidden  : (string)

$title = safe_post('title');
$hidden = safe_post('hidden',false);
if( $hidden != false ) $hidden = 1;
else $hidden = 0;

$tsaccount_group = SQL::tname('saccount_group');
if( SQL::query("INSERT INTO `$tsaccount_group`(`gpid`, `title`, `hidden`) VALUES (NULL,?,?)" , array($title,$hidden)) )
{
    throwjson('SUCC','');
}
else
{
    throwjson('error',"SQL error! 不能有相同名子的群組");
}