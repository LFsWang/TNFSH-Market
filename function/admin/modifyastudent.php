<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

if( !$_G['root'] )
{
    Render::errormessage('權限不足');
    Render::render('index','admin');
    exit(0);
}
$tsaccount_group = SQL::tname('saccount_group');
$tstudent_account = SQL::tname('student_account');
$suid = safe_get('suid');
if( !makeint($suid) )
{
    Render::errormessage('SUID錯誤');
    Render::render('index','admin');
    exit(0);
}
$user = SQL::fetch("SELECT * FROM $tstudent_account WHERE `suid` = ?",array($suid));
if( !$user )
{
    Render::errormessage('無此帳號');
    Render::render('index','admin');
    exit(0);
}


$sql_select = "SELECT * FROM $tsaccount_group";
if(!( $groups = SQL::fetchAll($sql_select) ))
{
    $groups = array();
}
$_E['template']['groups'] = $groups;
$_E['template']['user'] = $user;
Render::render('modifyastudent','admin');