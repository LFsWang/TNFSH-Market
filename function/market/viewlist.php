<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
require_once('panel.php');
$tgoodlist = SQL::tname('goodlist');
$tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
$tgoodlist_accountgroup =SQL::tname('goodlist_accountgroup');
$tgoods = SQL::tname('goods');

// it should check user access!
$lid = safe_get('id');
if( !is_numeric($lid) )
{
    Render::render('viewlist_user_denied','market');
    exit(0);
}
$lid = (int)$lid;

if( !CheckUserListAccess($lid,$_G['suid'] ) )
{
    Render::errormessage('權限不足');
    Render::render('viewlist_user_denied','market');
}

#Get all goodlist info
$data = GetGoodlistDetail($lid);
if( $lid === false )
{
    Render::errormessage('SQL ERROR');
    Render::render('viewlist_user_denied','market');
}
#time
$timeflag = GetTimeFlag($data['starttime'],$data['endtime']);
//Render::errormessage($timeflag);
//Render::errormessage($data);
$_E['template']['listinfo'] = $data;
$_E['template']['goodsinfo'] = $data['goodsinfo'];
$_E['template']['buy'] = array();
$_E['template']['buyinfo'] = array();
$_E['template']['market_panel_active'] = "mlist-$lid";
$_E['template']['buyflag'] = false;

#buy?
$torderlist = SQL::tname('orderlist');
$torderlist_detail = SQL::tname('orderlist_detail');
if( $row = SQL::fetch("SELECT * FROM `$torderlist` WHERE `suid` = ? AND `lid` =? ",array($_G['suid'],$lid)))
{
    $_E['template']['buy'] = $row;
    $_E['template']['buyflag'] = true;
    if( $res = SQL::fetchAll("SELECT * FROM `$torderlist_detail` WHERE `odid` = ?",array($row['odid'])) )
    {
        foreach( $res as $row )
        {
            $_E['template']['buyinfo'][$row['gid']] = $row;
        }
    }
    else
    {
        Render::errormessage('取得清單時發生意外的錯誤');
        Render::render('viewlist_user_denied','market');
    }
}
if( $_E['template']['buyflag'] )
{
    Render::render('viewlist_passbuy','market');
}
elseif( $timeflag == TF_NOTYET )
{
    Render::render('viewlist_notyet','market');
}
elseif( $timeflag == TF_PASS )
{
    Render::render('viewlist_pass','market');
}
else
{
    $_E['template']['token'] = UserAccess::SetHashToken('viewlist-'.$lid);
    Render::render('viewlist','market');
}
