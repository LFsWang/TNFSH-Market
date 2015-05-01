<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}

$gid = safe_get('gid');
if( !is_numeric($gid) )
{
    throwjson('error','gid error!');
}
$gid = (int)$gid;
$table = SQL::tname('goods');
$sql_select = "SELECT * FROM `goods` WHERE `gid` = ?";
$res = SQL::prepare($sql_select);
$res->execute(array($gid));

$data = $res->fetch();
if( !$data )
{
    throwjson('error','Empty!');
}
throwjson('SUCC',$data);
