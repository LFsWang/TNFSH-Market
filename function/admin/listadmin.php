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

$taccount = SQL::tname('account');
$sql_select = "SELECT `uid`,`username`,`title`,`root` FROM $taccount";
if(!( $users = SQL::fetchAll($sql_select) ))
{
    $users = array();
}
$_E['template']['users'] = $users;
Render::render('listadmin','admin');