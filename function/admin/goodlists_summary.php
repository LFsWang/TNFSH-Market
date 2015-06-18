<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tstudent_account = SQL::tname('student_account');
$tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
$torderlist_detail = SQL::tname('orderlist_detail');

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

#人數
$data['totaluser'] = 0;
$cusers = SQL::fetch("SELECT COUNT(`suid`) FROM `$tstudent_account` WHERE `gpid` IN (SELECT `gpid` FROM `$tgoodlist_accountgroup` WHERE `lid` = ?)",array($lid));
if( $cusers )
{
    $data['totaluser'] = (int)$cusers[0];
}

$goods = array();
$totalgnum = array();
$totalguser = array();
foreach( $data['goods'] as $gid )
{
    $goods[$gid] = GetGoodByGID($gid);
    $totalgnum[$gid] = 0;
    $totalguser[$gid] = 0;
    if( $goods[$gid]['type'] == 'clothe' )
    {
        //need a mask
        $goods[$gid]['sz'] = array();
    }
}

#取得所有細節加以統計
$orderlist_detail = SQL::fetchAll("SELECT * FROM `$torderlist_detail` WHERE `lid` = ?",array($lid));
if( !$orderlist_detail ) $orderlist_detail = array();

$totalbuyuser = array();
foreach( $orderlist_detail as $row )
{
    $totalbuyuser[$row['odid']]=1;
    $totalgnum[ $row['gid'] ] += $row['num'];
    $totalguser[$row['gid'] ] ++;
  
    if( !isset( $goods[$gid]['sz'][ $row['lpants'] ] ) )
        $goods[$gid]['sz'][ $row['lpants'] ] = 0;
    $goods[$gid]['sz'][ $row['lpants'] ] += $row['num'];
}

$_E['template']['totalbuyuser'] = count($totalbuyuser);
$_E['template']['totalgnum'] = $totalgnum;
$_E['template']['totalguser'] = $totalguser;
//Render::errormessage($result);
$_E['template']['goodlist'] = $data;
$_E['template']['goods'] = $goods;
//total user

Render::render('goodlists_summary','admin');