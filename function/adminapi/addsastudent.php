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
#account : addadmin
#password  : (string)
#group  : (string)

$account = safe_post('account');
$password = safe_post('password');
$group = safe_post('group');

$data = array();
$data['name'] = safe_post('name',null);
$data['grade'] = safe_post('grade',0);
$data['class'] = safe_post('class',0);
$data['number'] = safe_post('number',0);
$res = addUserAccount($account,$password,$group,false,$data) ;
if( $res === ERROR_NO )
{
    throwjson('SUCC',"");
}
else
{
    throwjson('error',"SQL error! $res");
}
