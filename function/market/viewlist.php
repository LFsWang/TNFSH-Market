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
$_E['template']['market_panel_active'] = "mlist-$lid";


if( $timeflag == TF_NOTYET )
{
    Render::render('viewlist_notyet','market');
}
elseif( $timeflag == TF_PASS )
{
    Render::render('viewlist_pass','market');
}
else
{
    $_E['template']['token'] = UserAccess::SetHashToken('viewlist');
    Render::render('viewlist','market');
}
