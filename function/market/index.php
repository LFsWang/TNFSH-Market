<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
require_once('panel.php');

if( safe_get('id') )
{
    require('viewlist.php');
    exit(0);
}
$system_announcement = getsysvalue('system_announcement');
if( $system_announcement === false )
    $system_announcement = '';

$_E['template']['system_announcement'] = $system_announcement;
Render::render('index','market');