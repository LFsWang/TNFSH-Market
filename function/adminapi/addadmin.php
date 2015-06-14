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
#username  : (int)
#password  : (string)
#root : (string)

$username = safe_post('username');
$password = safe_post('password');
$root = safe_post('root',false);
if( $root != false ) $root = 1;
else $root = 0;
$res = addAdminAccount($username,$password,$root);
if( $res === ERROR_NO )
{
    throwjson('SUCC','');
}
else
{
    throwjson('error',"error code : $res");
}