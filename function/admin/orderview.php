<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tgoodlist = SQL::tname('goodlist');
$tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
$tgoodlist_accountgroup =SQL::tname('goodlist_accountgroup');
$tgoods = SQL::tname('goods');
$torderlist = SQL::tname('orderlist');
$torderlist_detail = SQL::tname('orderlist_detail');
$tstudent_account = SQL::tname('student_account');

$odid = safe_get('odid');
if( !makeint($odid) )
{
    Render::errormessage("編號錯誤","goods");
    Render::render('index','admin');
    exit(0);
}
$order = SQL::fetch("SELECT * FROM `$torderlist` WHERE `odid` = ?",array($odid));
if( !$order )
{
    Render::errormessage("無此訂單","goods");
    Render::render('index','admin');
    exit(0);
}
$lid = (int)$order['lid'];
#Get all goodlist info
$data = GetGoodlistDetail($lid);
if( $data === false )
{
    Render::errormessage("無此訂單","goods");
    Render::render('index','admin');
    exit(0);
}
$acct = SQL::fetch("SELECT * FROM `$tstudent_account` WHERE `suid` = ?",array($order['suid']));
if( !$acct ) $acct = array('name'=>'[REMOVED]');
//Render::errormessage($timeflag);
$_E['template']['acct'] = $acct;
$_E['template']['listinfo'] = $data;
$_E['template']['goodsinfo'] = $data['goodsinfo'];
$_E['template']['buy'] = $order;
$_E['template']['buyinfo'] = array();
$_E['template']['buyflag'] = false;

if( $res = SQL::fetchAll("SELECT * FROM `$torderlist_detail` WHERE `odid` = ?",array($odid)) )
{
    foreach( $res as $row )
    {
        $_E['template']['buyinfo'][$row['gid']] = $row;
    }
    if( safe_get('pdf') !== false )
    {
        Render::renderSingleTemplate('common_header_printable','common');
        Render::renderSingleTemplate('viewlist_passbuypdf','market');
        Render::renderSingleTemplate('common_footer_printable');
        exit(0);
    }
    else
    {
        Render::render('orderview','admin');
    }
    exit(0);
}
else
{
    Render::errormessage("取得清單時發生意外的錯誤","goods");
    Render::render('index','admin');
    exit(0);
}
