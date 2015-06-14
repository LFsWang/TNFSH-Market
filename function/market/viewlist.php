<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tgoodlist = SQL::tname('goodlist');
$tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
$tgoodlist_accountgroup =SQL::tname('goodlist_accountgroup');
$tgoods = SQL::tname('goods');

// it should check user access!
$lid = safe_get('id');
if( !is_numeric($lid) )
{
    Render::render('viewlist_user_denied','market');
}
$lid = (int)$lid;

if( !SQL::fetch("SELECT `lid` FROM $tgoodlist_accountgroup WHERE `lid` = ? AND `gpid`=?",array($lid,$_G['gpid'])) )
{
    Render::errormessage('權限不足');
    Render::render('viewlist_user_denied','market');
}

#Get all goodlist info
$sql_select = "SELECT * from `$tgoodlist` WHERE `lid` = ?";
if(!( $data = SQL::fetch($sql_select ,array($lid)) ))
{
    Render::errormessage('SQL ERROR');
    Render::render('viewlist_user_denied','market');
}

#Get all goods info
$sql_select = "SELECT *,`defaultnum` * `price` AS `total` FROM `$tgoods` WHERE `gid` IN (SELECT `gid` FROM `$tgoodlist_goodstable` WHERE `lid` = ?)";
if( $res = SQL::query($sql_select,array($lid)) )
{
    while( $row = $res->fetch() )
    {
        $goodinfo[ $row['gid'] ] = $row;
    }
}
else
{
    Render::errormessage('SQL ERROR');
    Render::render('viewlist_user_denied','market');
}

#time
$timeflag = GetTimeFlag($data['starttime'],$data['endtime']);
//Render::errormessage($timeflag);
//Render::errormessage($data);
$_E['template']['listinfo'] = $data;
$_E['template']['goodinfo'] = $goodinfo;
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
    Render::render('viewlist','market');
}
