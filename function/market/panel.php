<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}


$tgroup = SQL::tname('goodlist_accountgroup');
$tlist  = SQL::tname('goodlist');

$sql_select = "SELECT `$tgroup`.`lid`,`name` FROM `$tgroup` INNER JOIN `$tlist` ON `$tlist`.`lid` = `$tgroup`.`lid` WHERE `$tgroup`.`gpid` = ?";

$result = SQL::fetchAll($sql_select,array($_G['gpid']));
if( !$result )
{
    $result  = array();
}

$_E['template']['panel_list'] = $result;