<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

//if can view in public...
//todo

$gid = safe_get('gid','1');
if( !is_numeric($gid) )
{
    $gid = '1';
}
$gid = (int)$gid;

$table = SQL::tname('goods');
$sql_select = "SELECT * FROM `$table` WHERE `gid` = ?";
$res = SQL::prepare($sql_select);
if( !SQL::execute($res,array($gid)) )
{
    Render::errormessage('SQL Error');
    Render::render('nonedefined');
    exit(0);
}

$data = $res->fetch();
if(!$data)
{
    header("HTTP/1.0 404 Not Found");
    Render::errormessage('No such item');
    Render::render('nonedefined');
    exit(0);
}
$_E['template']['data'] = $data;

$_E['template']['img'] = array();
$imglist = unserialize($data['image']);
if(!is_array($imglist))
{
    $imglist = array();
}
foreach($imglist as $id)
{
    if( $res = GetImageNameById($id) )
    {
        $_E['template']['img'][] = array(
            'url' => 'image/'.$res ,
        );
    }
}
//Render::errormessage($_E['template']['img']);
//Render::errormessage($_E['template']['data']);
Render::render('viewgood','index');
//header("HTTP/1.0 404 Not Found");
