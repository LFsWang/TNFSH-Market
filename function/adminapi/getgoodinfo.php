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

unset($data['image']);
$data['image'] = array();
$tgoods_image = SQL::tname('goods_image');
$sql_select = "SELECT `imgid` FROM `$tgoods_image` WHERE `gid` = ?";

$res = SQL::prepare($sql_select);
if( SQL::execute($res,array($data['gid'])) )
{
    while( $row = $res->fetch() )
    {
        $id = $row['imgid'];
        if( $name = GetImageNameById($id) )
        {
            $data['image'][] = array($id,$name);
        }
    }
}

throwjson('SUCC',$data);
