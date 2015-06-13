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

$tgoods_image = SQL::tname('goods_image');
$sql_select = "SELECT `imgid` FROM `$tgoods_image` WHERE `gid` = ?";
$res = SQL::prepare($sql_select);
if( SQL::execute($res,array($gid)) )
{
    while( $row = $res->fetch() )
    {
        $id = $row['imgid'];
        $info = array();
        if( $dat = GetImageNameById($id,$info) )
        {
            $_E['template']['img'][] = array(
                'url'           => 'image/'.$dat ,
                'title'         => $info['title'],
                'description'   => $info['description'],
            );
        }
    }
}
$taccount = SQL::tname('account');
$title = SQL::fetch("SELECT `title` FROM `$taccount` WHERE `uid` = ?",array($data['owner']) );
if( $title )
{
    $_E['template']['ownername'] = $title['title'];
}
else
{
    $_E['template']['ownername'] = 'DATA NOT SUPPORT';
}
Render::render('viewgood','index');
//header("HTTP/1.0 404 Not Found");
