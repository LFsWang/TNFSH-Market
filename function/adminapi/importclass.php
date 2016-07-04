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
$tstudent_account = SQL::tname('student_account');
$excelpage = safe_post('excelpage','1');
$gpid = safe_post('gpid');
$acct = safe_post('acct');
$grade= safe_post('grade','');
$class= safe_post('class','');
$number = safe_post('number','');
$try = safe_post('try');
//var_dump($_POST);
if( !isset($_FILES['xlsxIC']) )
{
    throwjson('error','File missing');
}

if( !makeint($excelpage) ){
    throwjson('error','excel page error');
}

$file = $_FILES['xlsxIC'];
try {
    $objPHPExcel = PHPExcel_IOFactory::load($file['tmp_name']);
    $objPHPExcel->setActiveSheetIndex($excelpage-1);
} catch(Exception $e) {
    throwjson('error','Error loading file '.$e->getMessage());
}

$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

//deal with data 
$pre = array('acct','grade','class','number');
$convert = array();
foreach( $pre as $i )
{
    if( !empty( $$i ) )
        $convert [] = $i;
    else
        continue;
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
    //gen string
    $user = array();
    foreach( $convert as $v )
        $user[$v] = '';
        
    foreach( $user as $k => &$v )
    {
        foreach( $$k as $i )
        {
            if( isset( $data[$i-1] ) )
                $v.=$data[$i-1];
        }
    }
    //var_dump($user);
    //get old data
    
    $old = $new = SQL::fetch("SELECT `suid`,`username`,`grade`,`class`,`number` FROM `$tstudent_account` WHERE `username` =? OR `username` =?",array( NEWBIE_PRE.$user['acct'],$user['acct'] ) );
    if( !$old )
    {
        throwjson('error',"找不到使用者{$user['acct']}");
    }
    //var_dump($user);
    foreach( $user as $k => &$v )
    {
        if( $k == 'acct' ) continue;
        $new[$k] = $v;
    }
    throwjson('SUCC',"修改帳號:{$old['username']}\n原始資料:{$old['grade']}年{$old['class']}班{$old['number']}號 \n新資料:{$new['grade']}年{$new['class']}班{$new['number']}號");
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
        //gen string
        $user = array();
        foreach( $convert as $v )
            $user[$v] = '';
            
        foreach( $user as $k => &$v )
        {
            foreach( $$k as $i )
            {
                if( isset( $data[$i-1] ) )
                    $v.=$data[$i-1];
            }
        }
        //var_dump($user);
        //get old data
        $tstudent_account = SQL::tname('student_account');
        $old = $new = SQL::fetch("SELECT `suid`,`username`,`grade`,`class`,`number` FROM `$tstudent_account` WHERE `username` =? OR `username` =?",array( NEWBIE_PRE.$user['acct'],$user['acct'] ) );
        if( !$old )
        {
            $log .= "修改{$user['acct']}發生錯誤:找不到使用者<br>";
            $flag = false;
            continue;
        }
        //var_dump($user);
        foreach( $user as $k => &$v )
        {
            if( $k == 'acct' ) continue;
            $new[$k] = $v;
        }
        if( !SQL::query("UPDATE $tstudent_account SET `grade`=?,`class`=?,`number`=? WHERE `suid`=?",array($new['grade'],$new['class'],$new['number'],$old['suid'])) )
        {
            $flag = false;
            $log .= "修改{$user['acct']}發生錯誤:SQL error,原始資料:{$old['grade']}年{$old['class']}班{$old['number']}號,新資料:{$new['grade']}年{$new['class']}班{$new['number']}號<br>";
        }
        else
        {
            $succnum++;
        }
    }
    if( $flag )
    {
        throwjson('SUCC',"匯入成功，共修改{$succnum}/{$allnum}筆帳號<br>".$log);
    }
    else
    {
        throwjson('error',"匯入失敗，共修改{$succnum}/{$allnum}筆帳號<br>".$log);
    }
    
}
