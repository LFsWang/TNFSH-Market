<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}

//Check user can use this list
$lid = safe_post('lid');
if( !is_numeric($lid) )
{
    Render::render('viewlist_user_denied','market');
    exit(0);
}
$lid = (int)$lid;

$token = safe_post('token');
if( !UserAccess::CheckHashToken('checklist-'.$lid,$token) )
{
    UserAccess::RemoveHashToken('checklist-'.$lid);
    Render::errormessage('驗證碼失效，請重新填寫表單。');
    Render::render('viewlist_user_denied','market');
}
UserAccess::RemoveHashToken('checklist-'.$lid);
UserAccess::RemoveHashToken('viewlist-'.$lid);
if( !isset($_SESSION[$token]) || !isset($_SESSION[$token.'hash']))
{
    Render::errormessage('閒置過久! 請重新選擇。');
    Render::render('viewlist_user_denied','market');
}

$userin = $_SESSION[$token];
$userinhash = $_SESSION[$token.'hash'];

unset($_SESSION[$token]);
unset($_SESSION[$token.'hash']);

if( $userin['lid'] != $lid || md5(serialize($userin)) !== $userinhash )
{
    Render::errormessage('代號遭到異常更動，請重新選擇。');
    Render::render('viewlist_user_denied','market');
}

#OK insert to SQL 
$torderlist = SQL::tname('orderlist');
$torderlist_detail = SQL::tname('orderlist_detail');
if( !SQL::query("INSERT INTO `$torderlist` (`odid`, `suid`, `gpid`, `lid`, `bust`, `waistline`, `lpants`, `timestamp`, `orderhash`) VALUES (NULL,?,?,?,?,?,?,NULL,?)",array($_G['suid'],$_G['gpid'],$lid,$userin['bust'],$userin['waistline'],$userin['lpants'],$userinhash)) )
{
    Render::errormessage('SQL 發生錯誤，交易已被取消');
    Render::render('viewlist_user_denied','market');
}
$odid = SQL::lastInsertId();

//Murphy's Law
$acceptflag = true;
foreach( $userin['gid'] as $gid => $num )
{
    if( !SQL::query("INSERT INTO `$torderlist_detail`(`odid`, `lid`, `gid`, `num`, `bust`, `waistline`, `lpants`) VALUES (?,?,?,?,?,?,?)",array($odid,$lid,$gid,$num,$userin['bust'],$userin['waistline'],$userin['lpants'])) )
    {
        $acceptflag = false;
        break;
    }
}
if( !$acceptflag )
{
    //remove all data
    SQL::query("DELETE FROM `$torderlist_detail` WHERE `odid` = ?",array($odid));
    SQL::query("DELETE FROM `$torderlist` WHERE `odid` = ?",array($odid));
    Render::errormessage('發生錯誤，交易已被取消');
    Render::render('viewlist_user_denied','market');
}

//Yooooooooooooooo!
header('Location:market.php?id='.$lid);
exit(0);