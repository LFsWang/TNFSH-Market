<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

$_E['template']['res'] = array();

$fd = safe_get('name');
$ct = safe_get('acct');
if( !empty($fd) || !empty($ct) )
{
    $tstudent_account = SQL::tname('student_account');
    $torderlist = SQL::tname('orderlist');
    $tgoodlist = SQL::tname('goodlist');
    $res = SQL::fetchAll("
SELECT
    `$tstudent_account`.`suid`,
    `$tstudent_account`.`username`,
    `$tstudent_account`.`name`,
    `$tstudent_account`.`grade`,
    `$tstudent_account`.`class`,
    `$tstudent_account`.`number`,
    `$torderlist`.`odid`,
    `$torderlist`.`lid`,
    `$torderlist`.`timestamp`,
    `$torderlist`.`orderhash`,
    `$tgoodlist`.`name` AS `gname`
FROM `$tstudent_account` 
	RIGHT JOIN `$torderlist` ON `$tstudent_account`.`suid` = `$torderlist`.`suid`
    INNER JOIN `$tgoodlist`  ON `$torderlist`.`lid` = `$tgoodlist`.`lid`
WHERE `$tstudent_account`.`name` LIKE ? AND `$tstudent_account`.`username` LIKE ?
ORDER BY `timestamp`",
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

Render::render('orderfind','admin');