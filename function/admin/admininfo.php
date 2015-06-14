<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

if( isset($_SESSION['admineditflag'] ) )
{
    unset($_SESSION['admineditflag']);
    Render::succmessage('修改成功');
}

$id = safe_get('uid',null);
if( $id == null )
    $id = safe_post('uid',null);
if( !$_G['root'] && $_G['uid'] != $id )
{
    Render::errormessage('權限不足');
    Render::render('index','admin');
    exit(0);
}

if( !is_numeric($id) )
{
    Render::errormessage('UID錯誤');
    Render::render('index','admin');
    exit(0);
}
$id =(int) $id;

$taccount = SQL::tname('account');
$sql_select = "SELECT `uid`,`username`,`title`,`root` FROM $taccount WHERE `uid` = ?";
if( $res = SQL::query($sql_select,array($id)) )
{
    if(!( $users = $res->fetch() ))
    {
        Render::errormessage('不存在的使用者');
        Render::render('index','admin');
        exit(0);
    }
}
else
{
    Render::errormessage('SQL ERROR');
    Render::render('index','admin');
    exit(0);
}
//Render::errormessage($users);
$_E['template']['users'] = $users;
Render::render('admininfo','admin');