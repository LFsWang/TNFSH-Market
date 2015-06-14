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
$sql_select = "SELECT * FROM $tsaccount_group";
if(!( $groups = SQL::fetchAll($sql_select) ))
{
    $groups = array();
}
$_E['template']['groups'] = $groups;
Render::render('addastudent','admin');