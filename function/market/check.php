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
$tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
if( !CheckUserListAccess($lid,$_G['suid'] ) )
{
    Render::errormessage('權限不足');
    Render::render('viewlist_user_denied','market');
}
if( !UserAccess::CheckHashToken('viewlist') )
{
    Render::errormessage('CLRF token error');
    Render::render('viewlist_user_denied','market');
}

#Get all goods info
$data = GetGoodlistDetail($lid);
if( $data === false )
{
    Render::errormessage('GetGoodlistDetail Fail');
    Render::render('viewlist_user_denied','market');
}

#Chech user input num
$userin = array();
$userin['gid'] = array();
$acflag = true;
$colthe = false;
foreach( $data['goodsinfo'] as $row )
{
    if( $row['type'] == 'colthe' )
    {
        $colthe = true;
    }
    $num = safe_post( 'gid-'.$row['gid'] , 0 );
    if( empty($num) || !is_numeric($num) ){
        $num = 0;
    }
    $num = (int) $num;
    if( $num < 0 ||  $row['maxnum'] < $num ){
        $acflag = false;
        continue;
    }
    $userin['gid'][$row['gid']] = $num;
}
if( $colthe )
{
    $bust = safe_post('bust');
    $waistline = safe_post('waistline');
    $lpants = safe_post('lpants');
    //lalala
    
    $userin['bust'] = $bust;
    $userin['waistline'] = $waistline;
    $userin['lpants'] = $lpants;
    
}
$userin['lid'] = $lid;
$userin['timestamp'] = time();
//Render::errormessage($userin);
if( !$acflag )
{
    Render::errormessage('輸入錯誤');
    Render::render('viewlist_user_denied','market');
}
$_E['template']['token'] = $token = UserAccess::SetHashToken('checklist-'.$lid);
$_E['template']['listinfo'] = $data;
$_E['template']['goodsinfo'] = $data['goodsinfo'];
$_E['template']['userin'] = $userin;
$_E['template']['colthe'] = $colthe ;
$_SESSION[$token] = $userin;
Render::render('check','market');