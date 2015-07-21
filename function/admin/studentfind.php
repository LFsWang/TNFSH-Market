<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

$_E['template']['res'] = array();

$fd = safe_get('name','');
$ct = safe_get('acct','');
if( $fd!=='' || $ct!=='' )
{
    $tstudent_account = SQL::tname('student_account');
    $res = SQL::fetchAll("
SELECT *
FROM `$tstudent_account` 
WHERE `name` LIKE ? AND `username` LIKE ? 
ORDER BY `suid`",
    array( '%'.$fd.'%' , '%'.$ct.'%' ) );
    if( $res === false )
    {
        Render::errormessage('SQL Error!');
    }
    else
    {
        $_E['template']['res'] = $res;
    }
}
Render::render('studentfind','admin');