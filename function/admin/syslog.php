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

$tsyslog = SQL::tname('syslog');
if( $arr = SQL::fetchAll("SELECT * FROM `$tsyslog` ORDER by `id` DESC LIMIT 20") )
{
}
else
{
    $arr = array();
}
$_E['template']['syslog'] = $arr;
Render::render('syslog','admin');