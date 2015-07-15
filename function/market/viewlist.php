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
$tstudent_account = SQL::tname('student_account');
$torderlist = SQL::tname('orderlist');
$torderlist_detail = SQL::tname('orderlist_detail');

// it should check user access!
$lid = safe_get('id');
if( !makeint($lid) )
{
    Render::render('viewlist_user_denied','market');
    exit(0);
}

if( !CheckUserListAccess($lid,$_G['suid'] ) )
{
    Render::errormessage('權限不足');
    Render::render('viewlist_user_denied','market');
    exit(0);
}

#Get all goodlist info
$data = GetGoodlistDetail($lid);
if( $data === false )
{
    Render::errormessage('SQL ERROR');
    Render::render('viewlist_user_denied','market');
    exit(0);
}
#time
$timeflag = GetTimeFlag($data['starttime'],$data['endtime']);
$acct = SQL::fetch("SELECT * FROM `$tstudent_account` WHERE `suid` = ?",array($_G['suid']));
if( !$acct ) $acct = array('name'=>'[REMOVED]');
//Render::errormessage($timeflag);
$_E['template']['acct'] = $acct;
$_E['template']['listinfo'] = $data;
$_E['template']['goodsinfo'] = $data['goodsinfo'];
$_E['template']['buy'] = array();
$_E['template']['buyinfo'] = array();
$_E['template']['market_panel_active'] = "mlist-$lid";
$_E['template']['buyflag'] = false;

#buy?
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
        exit(0);
    }
}
if( $_E['template']['buyflag'] )
{
    if( safe_get('pdf') !== false )
    {
        Render::renderSingleTemplate('common_header_printable','common');
        Render::renderSingleTemplate('viewlist_passbuypdf','market');
        Render::renderSingleTemplate('common_footer_printable');
        exit(0);
    }
    else
    {
        Render::render('viewlist_passbuy','market');
        exit(0);
    }
}
elseif( $timeflag == TF_NOTYET )
{
    Render::render('viewlist_notyet','market');
    exit(0);
}
elseif( $timeflag == TF_PASS )
{
    Render::render('viewlist_pass','market');
    exit(0);
}
else
{
    $_E['template']['token'] = UserAccess::SetHashToken('viewlist-'.$lid);
    Render::render('viewlist','market');
    exit(0);
}
