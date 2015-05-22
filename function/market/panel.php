<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}


$table = SQL::tname('goodlist');
$sql_select = "SELECT `lid`, `name` FROM `goodlist` WHERE 1";

$res = SQL::prepare($sql_select);
$res->execute();
$result = $res->fetchAll();

$_E['template']['panel_list'] = $result;