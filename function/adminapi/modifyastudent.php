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

$tsaccount_group = SQL::tname('saccount_group');
$tstudent_account= SQL::tname('student_account');

$suid = safe_post('suid');
$password = safe_post('password');
$group = safe_post('group');
$name = safe_post('name','');
$grade = safe_post('grade',0);
$class = safe_post('class',0);
$number = safe_post('number',0);

if( !makeint($suid) )
{
    throwjson('error',"SUID錯誤");
}

if( !SQL::fetch("SELECT `gpid` FROM `$tsaccount_group` WHERE `gpid` = ?",array($group)) )
{
    throwjson('error',"群組錯誤");
}

if( !empty($password) )
{
    if( !checkPasswordFormat($password) )
    {
        throwjson('error',"新密碼格式錯誤");
    }
    $password = GetPasswordHash($password);
}
else
{
    $password = null;
}

if(!SQL::query("UPDATE `$tstudent_account` SET `gpid`=?,`name`=?,`grade`=?,`class`=?,`number`=? WHERE `suid`=?",array($group,$name,$grade,$class,$number,$suid)))
{
    throwjson('error',"SQL錯誤");
}
if( isset($password) )
{
    if(!SQL::query("UPDATE `$tstudent_account` SET `password`=? WHERE `suid`=?",array($password,$suid)))
    {
        throwjson('error',"修改密碼失敗");
    }
}


throwjson('SUCC',"SUCC");
