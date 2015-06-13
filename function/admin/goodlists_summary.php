<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

$lid = safe_get('lid');
if( !is_numeric($lid) )
{
    Render::errormessage('ERROR LID');
    Render::render('index','admin');
    exit(0);
}
$lid = (int)$lid;
$data = GetGoodlistByLID($lid);

if( !$data )
{
    Render::errormessage('GET DATA ERROR');
    Render::render('index','admin');
    exit(0);
}

$goods = array();
foreach( $data['goods'] as $gid )
{
    $goods[$gid] = GetGoodByGID($gid);
}
//Render::errormessage($result);
$_E['template']['goodlist'] = $data;
$_E['template']['goods'] = $goods;
Render::render('goodlists_summary','admin');