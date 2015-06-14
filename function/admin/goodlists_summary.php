<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tstudent_account = SQL::tname('student_account');
$tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');

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

$data['totaluser'] = 0;
$cusers = SQL::fetch("SELECT COUNT(`suid`) FROM `$tstudent_account` WHERE `gpid` IN (SELECT `gpid` FROM `$tgoodlist_accountgroup` WHERE `lid` = ?)",array($lid));
if( $cusers )
{
    $data['totaluser'] = (int)$cusers[0];
}

$goods = array();
foreach( $data['goods'] as $gid )
{
    $goods[$gid] = GetGoodByGID($gid);
}
//Render::errormessage($result);
$_E['template']['goodlist'] = $data;
$_E['template']['goods'] = $goods;
//total user

Render::render('goodlists_summary','admin');