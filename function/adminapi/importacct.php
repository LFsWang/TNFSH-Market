<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
set_time_limit(0);
if( $_G['usertype'] !== USER_ADMIN )
{
    throwjson('error','Error:7122');
}
if( !$_G['root'] )
{
    throwjson('error','Error:'.ERROR_PREMISSION_DENIED);
}
require_once($_E['ROOT'].'/function/user/user.lib.php');
require_once($_E['ROOT'].'/function/admin/admin.lib.php');
require_once($_E['ROOT'].'/function/Classes/PHPExcel.php');
//require_once($_E['ROOT'].'/function/Classes/PHPExcel/IOFactory.php');

$gpid = safe_post('gpid');
$acct = safe_post('acct');
$pass = safe_post('pass');
$name = safe_post('name');
$try  = safe_post('try');
//var_dump($_POST);
if( !isset($_FILES['xlsxIA']) )
{
    throwjson('error','File missing');
}

$file = $_FILES['xlsxIA'];
try {
    $objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
} catch(Exception $e) {
    throwjson('error','Error loading file '.$e->getMessage());
}
$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

$data = $sheetData[2];

//deal with data 
$convert = array('acct','pass','name');
foreach( $convert as $i )
{
    $$i = explode( ',', $$i );
    foreach( $$i as &$d )
    {
        if( !is_numeric($d) )
        {
            throwjson('error','File format error :'.$i.":{$d}");
        }
        $d = (int)$d;
    }
}

if( $try )
{
    $_data = $sheetData[2];
    $data = array();
    foreach($_data as $a)$data[]=$a;
    $user = array('acct'=>'','pass'=>'','name'=>'');
    foreach( $user as $k => &$v )
    {
        foreach( $$k as $i )
        {
            if( isset( $data[$i-1] ) )
                $v.=$data[$i-1];
        }
    }
    throwjson('SUCC',"帳號:{$user['acct']} 密碼:{$user['pass']} 名稱:{$user['name']}");
}
else
{
    $log = '';
    $flag = true;
    $allnum = 0;
    $succnum= 0;
    $ignorefirst = true;
    foreach( $sheetData as $row )
    {
        if( $ignorefirst )
        {
            $ignorefirst = false;
            continue;
        }
        $allnum++;
        $data = array();
        foreach($row as $a)$data[]=$a;
        
        $user = array('acct'=>'','pass'=>'','name'=>'');
        foreach( $user as $k => &$v )
        {
            foreach( $$k as $i )
            {
                if( isset( $data[$i-1] ) )
                    $v.=$data[$i-1];
            }
        }
        $res = addUserAccount($user['acct'],$user['pass'],$gpid,true,array('name'=>$user['name']));
        if( $res != ERROR_NO )
        {
            $flag = false;
            $log.= "匯入:{$user['acct']}/{$user['pass']}/{$user['name']} 發生錯誤: {$res} <br>";
        }
        else
        {
            $succnum++;
        }
    }
    if( $flag )
    {
        throwjson('SUCC',"匯入成功，共新增{$succnum}/{$allnum}筆帳號");
    }
    else
    {
        throwjson('error',"匯入失敗，共新增{$succnum}/{$allnum}筆帳號<br>".$log);
    }
    
}
