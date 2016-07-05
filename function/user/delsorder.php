<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}

$lid = safe_post('lid');
if( !makeint($lid) ){
    throwjson('error','LID ERROR!');
}
if(!($data = GetGoodlistDetail($lid))){
    throwjson('error','No Such List!');
}
if( GetTimeFlag($data['starttime'],$data['endtime']) === TF_NOW )
{
    $torderlist = SQL::tname('orderlist');
    if(!($row = SQL::fetch("SELECT `odid` FROM `$torderlist` WHERE `suid` = ? AND `lid` =? ",array($_G['suid'],$lid)))){
        throwjson('error','無此訂單');
    }
    if( !SQL::query("DELETE FROM `$torderlist` WHERE `odid` = ?",array($row['odid'])) )
    {
        throwjson('error','SQL錯誤');
    }
    SQL::log('del order','user '.$_G['suid'].' DEL orderlist : '.$row['odid']);
    throwjson('SUCC','GG');
}
throwjson('error','只有在訂購時間內可以刪除');