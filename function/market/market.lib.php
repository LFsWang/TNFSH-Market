<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}

function CheckUserListAccess($lid,$suid)
{
    #1. get pgid
    $tstudent_account = SQL::tname('student_account');
    $tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
    
    if(!( $res = SQL::fetch("SELECT `gpid` FROM $tstudent_account WHERE `suid` = ?",array($suid)) ))
    {
        return false;
    }
    $gpid = $res['gpid'];
    
    #2.lookup goodlist_accountgroup
    if( !SQL::fetch("SELECT `lid` FROM $tgoodlist_accountgroup WHERE `lid` = ? AND `gpid`=?",array($lid,$gpid)) )
    {
        return false;
    }
    return true;
}

function GetGoodlistDetail($lid)
{
    $tgoodlist = SQL::tname('goodlist');
    $tgoods = SQL::tname('goods');
    $tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
    $sql_select = "SELECT * from `$tgoodlist` WHERE `lid` = ?";
    if(!( $data = SQL::fetch($sql_select ,array($lid)) ))
    {
        return false;
    }
    $sql_select = "SELECT *,`defaultnum` * `price` AS `total` FROM `$tgoods` WHERE `gid` IN (SELECT `gid` FROM `$tgoodlist_goodstable` WHERE `lid` = ?)";
    if( $res = SQL::query($sql_select,array($lid)) )
    {
        $data['goodsinfo'] = array();
        while( $row = $res->fetch() )
        {
            $data['goodsinfo'][ $row['gid'] ] = $row;
        }
    }
    else
    {
        return false;
    }
    return $data;
}