<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}

if( isset( $_POST['content'] ) )
{
    updatesysvalue('system_announcement', $_POST['content'] );
}

$system_announcement = getsysvalue('system_announcement');
if( $system_announcement === false )
    $system_announcement = '';
$_E['template']['system_announcement'] = $system_announcement;

Render::render('edit_system_announcement','admin');