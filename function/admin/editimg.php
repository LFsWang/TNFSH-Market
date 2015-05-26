<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

if( !safe_get('imgid') )
{
    Render::render('nonedefined');
    exit(0);
}

$imgid = safe_get('imgid');
$info  = array();
$dataurl = GetImageNameById($imgid,$info);
if( $dataurl === false )
{
    Render::errormessage('No Such Photo!');
    Render::render('nonedefined');
    exit(0);
}

if( $info['owner'] != $_G['uid'] )
{
    Render::errormessage('Access denied!');
    Render::render('nonedefined');
    exit(0);
}
$info['url'] = 'image/'.$info['hashname'];
$_E['template']['imgdata']=$info;
Render::render('editimg','admin');
