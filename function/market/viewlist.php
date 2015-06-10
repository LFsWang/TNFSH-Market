<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tgoodlist = SQL::tname('goodlist');
$tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
$tgoods = SQL::tname('goods');

// it should check user access!
$lid = safe_get('id');
if( !is_numeric($lid) )
{
    Render::render('viewlist_user_denied','market');
}
$lid = (int)$lid;

$sql_select = "SELECT * from `$tgoodlist` WHERE `lid` = ?";
$res = SQL::prepare($sql_select);
if( !SQL::execute($res,array($lid)) )
{
    Render::render('viewlist_user_denied','market');
}

$data = $res->fetch();

$sql_select = "SELECT `gid` FROM `$tgoodlist_goodstable` WHERE `lid` = ?";
$res = SQL::prepare($sql_select);
if( !SQL::execute($res,array($lid)) )
{
    Render::render('viewlist_user_denied','market');
}
$t_gidlist = $res->fetchAll();
$gidlist = array(); 
foreach($t_gidlist as $row)
{
    $gidlist[] = $row['gid'];
}
$gidlist = array_unique($gidlist);
$gidnum = count($gidlist);
$goodinfo = array();
if( $gidnum !== 0 )
{
    $questionmark = str_repeat("?,",$gidnum-1) . "?";
    $sql_select = "SELECT *,`defaultnum` * `price` AS `total` FROM `$tgoods` WHERE `gid` IN ($questionmark)";
    $res = SQL::prepare($sql_select);
    if( !SQL::execute($res,$gidlist) )
    {
        Render::errormessage('SQL ERROR');
        Render::render('viewlist_user_denied','market');
    }
    while( $row = $res->fetch() )
    {
        $goodinfo[ $row['gid'] ] = $row;
    }
}

#time
$timeflag = GetTimeFlag($data['starttime'],$data['endtime']);
//Render::errormessage($timeflag);
//Render::errormessage($data);

$_E['template']['listinfo'] = $data;
$_E['template']['goodinfo'] = $goodinfo;
Render::render('viewlist','market');