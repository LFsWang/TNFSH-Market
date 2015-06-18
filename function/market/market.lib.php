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