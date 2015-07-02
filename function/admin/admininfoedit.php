<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
require_once($_E['ROOT'].'/function/user/user.lib.php');

$id = safe_post('uid');
$passwordold = safe_post('passwordold','');
$password = safe_post('password','');
$root = safe_post('root')?1:0;
$title = safe_post('title','');
if( !makeint($id) )
{
    Render::errormessage('UID錯誤');
    Render::render('index','admin');
    exit(0);
}

if( !$_G['root'] && $_G['uid'] != $id )
{
    Render::errormessage('權限不足');
    Render::render('index','admin');
    exit(0);
}

$taccount = SQL::tname('account');
$flag = true;

if( $_G['uid'] == $id )
{
    //need check old pass
    if( $row = SQL::fetch("SELECT `password` FROM `$taccount` WHERE `uid` = ?",array($id)) )
    {
        if( !password_verify($passwordold , $row['password']) )
        {
            Render::errormessage('密碼錯誤');
            $flag = false;
        }
    }
    else
    {
        Render::errormessage('無此ID');
        $flag = false;
    }
}

if( $flag )
{
    if( !empty($password) )
    {
        if( !checkPasswordFormat($password) )
        {
            Render::errormessage('密碼格式錯誤');
            $flag = false;
        }
        else if( !SQL::query("UPDATE `$taccount` SET `password`= ? WHERE `uid`=?",array(GetPasswordHash($password),$id)) )
        {
            Render::errormessage('SQL錯誤');
            $flag = false;
        }
    }
    if( $_G['root'] && $_G['uid']!=$id )
    {
        if( !SQL::query("UPDATE `$taccount` SET `root`= ? WHERE `uid`=?",array($root,$id)) )
        {
            Render::errormessage('SQL錯誤');
            $flag = false;
        }
    }
    if( !SQL::query("UPDATE `$taccount` SET `title`= ? WHERE `uid`=?",array($title,$id)) )
    {
        Render::errormessage('SQL錯誤');
        $flag = false;
    }
    
}

if( $flag )
{
    $_SESSION['admineditflag'] = true ;
    header("location: admin.php?page=admininfo&uid=$id");
    exit(0);
}
include('admininfo.php');