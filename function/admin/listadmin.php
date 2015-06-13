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
$res = SQL::prepare($sql_select);

if( SQL::execute($res) )
{
    $users = $res->fetchAll();
}
else
{
    $users = array();
}
$_E['template']['users'] = $users;
Render::render('listadmin','admin');