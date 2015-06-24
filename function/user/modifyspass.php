<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
require_once('user.lib.php');

#$action is in api.php
$oldpass = safe_post('passwordold');
$newpass = safe_post('passwordnew');

$tstudent_account = SQL::tname('student_account');
$row = SQL::fetch("SELECT `password` FROM `$tstudent_account` WHERE `suid` = ?",array($_G['suid']));
if( !$row )
{
    throwjson('error','系統錯誤');
}
if( !password_verify( $oldpass , $row['password'] ) )
{
    throwjson('error','舊密碼錯誤');
}
if( !checkPasswordFormat($newpass) )
{
    throwjson('error','新密碼格式錯誤');
}
if( !SQL::query("UPDATE `$tstudent_account` SET `password`=? WHERE `suid` = ?",array(GetPasswordHash($newpass),$_G['suid'])) )
{
    throwjson('error','系統修改錯誤');
}
throwjson('SUCC','Developing');