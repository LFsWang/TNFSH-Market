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
if( !UserAccess::CheckHashToken('viewlist-'.$lid) )
{
    Render::errormessage('驗證碼失效，請重新填寫表單。');
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
$clothe = $data['needclothe'];
foreach( $data['goodsinfo'] as $row )
{
    $num = safe_post( 'gid-'.$row['gid'] , 0 );
    if( empty($num) || !makeint($num) ){
        $num = 0;
    }
    if( $num < 0 ||  $row['maxnum'] < $num ){
        $acflag = false;
        continue;
    }
    $userin['gid'][$row['gid']] = $num;
}
if( $clothe )
{
    $bust = safe_post('bust');
    $waistline = safe_post('waistline');
    $lpants = safe_post('lpants');
    //lalala
    
    //bust 34 ~ 60 % 2 = 0 
    //waistline 27 ~ 46
    //lpants 38 ~ 46 % 2 = 0 
    if( !makeint($bust) || !makeint($waistline) || !makeint($lpants) )
    {
        Render::errormessage('尺寸輸入錯誤');
        Render::render('viewlist_user_denied','market');
    }

    if( $bust < 34 || 60 < $bust || $bust % 2 != 0 
      ||$waistline < 27 || 46 < $waistline
      ||$lpants < 38 || 46 < $lpants || $lpants % 2 != 0 )
    {
        Render::errormessage('衣物尺寸輸入錯誤');
        Render::render('viewlist_user_denied','market');
    }
    
    $userin['bust'] = $bust;
    $userin['waistline'] = $waistline;
    $userin['lpants'] = $lpants;
    
}
else
{
    $userin['bust'] = 0;
    $userin['waistline'] = 0;
    $userin['lpants'] = 0;
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
$_E['template']['clothe'] = $clothe ;
$_SESSION[$token] = $userin;
$_SESSION[$token.'hash'] = md5(serialize($userin));
Render::render('check','market');