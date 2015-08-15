<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    throwjson('error','Error:7122');
}
if( !$_G['root'] )
{
    throwjson('error','Error:'.ERROR_PREMISSION_DENIED);
}

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
            $v.=$data[$i-1];
        }
    }
    throwjson('SUCC',"帳號:{$user['acct']} 密碼:{$user['pass']} 名稱:{$user['name']}");
}
else
{
    throwjson('error','not yet');
}
