<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
$system_announcement = getsysvalue('system_announcement');
if( $system_announcement === false )
    $system_announcement = '';

$_E['template']['system_announcement'] = $system_announcement;

Render::render('index','admin');