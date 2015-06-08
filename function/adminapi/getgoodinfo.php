<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    exit('Access denied (T)');
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
$unpack = unserialize($data['image']);
if(!is_array($unpack))
{
    $unpack = array();
}
unset($data['image']);
$data['image'] = array();
foreach($unpack as $id)
{
    if( $name = GetImageNameById($id) )
    {
        $data['image'][] = array($id,$name);
    }
}
throwjson('SUCC',$data);
