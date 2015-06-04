<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

$allow_goodtype = array('normal','colthe');
$goodtype_to_zhtw = array( 'normal' => '一般商品' , 'colthe' => '衣服' );


if( isset($_POST['method']) )
{
    switch($_POST['method'])
    {
        case 'addnew' :
        case 'modify' :
            $data = array();
            $lid  = safe_post('lid','-1');
            $data['name'] = safe_post('listname',null);
            $data['starttime'] = safe_post('starttime',null);
            $data['endtime'] = safe_post('endtime',null);
            
            $usergroups = '';//usergroup;
            $data['description'] = safe_post('detail','');
            $data['goods'] = safe_post('goods',null);
            //Render::errormessage($_POST);
            if( $lid == 0 )$lid = null;
            modify_goodlist($data,$lid,$errcode);
            Render::errormessage($errcode);
            Render::errormessage($data);
            break;
    }
}

//$_E['template']['gtoken'] = UserAccess::SetToken('goodsadd',900,false);
//Render::errormessage($_E['template']['gtoken'],"AS");
//Render::errormessage($_SESSION,"AS");

#prepare goods
#prepare list
$table = SQL::tname('goods');
$sql_select = "SELECT `gid`,`name`,`price`,`defaultnum` FROM `goods` WHERE `status` = 1 OR `owner` = ?";
$res = SQL::prepare($sql_select);
$result = array();
if( SQL::execute($res,array($_G['uid'])) )
{
    $result = $res->fetchAll();
}
$_E['template']['goodslist'] = $result;

$goodprice = array();
$goodname  = array();
foreach($result as $row)
{
    $goodprice[ (int)$row['gid'] ] = $row['price'] * $row['defaultnum'];
    $goodname [ (int)$row['gid'] ] = htmlspecialchars($row['name']);
}

#prepare goodlists
$table = SQL::tname('goodlist');
$sql_select = "SELECT `lid`,`name`,`starttime`,`endtime` FROM `$table` WHERE `status` = 1";
$res = SQL::prepare($sql_select);
$result = array();
if( SQL::execute($res) )
{
    $result = $res->fetchAll();
}

$tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
$sql_select = "SELECT `lid`,`gid` FROM `$tgoodlist_goodstable` WHERE 1";
$res = SQL::prepare($sql_select);
$goods_tmp = array();
$goods = array();
if( SQL::execute($res) )
{
    $goods_tmp = $res->fetchAll();
}
foreach($goods_tmp as $row)
{
    $goods[$row['lid']][]=$row['gid'];
}

foreach($result as &$row)
{
    $row['goods'] = array();
    if( isset($goods[$row['lid']]) )
        $row['goods'] = $goods[$row['lid']];
    $row['sum'] = 0;
    $row['liststr'] = '';
    foreach( $row['goods'] as $gid )
    {
        if( isset( $goodprice[$gid] ) )
        {
            $row['sum'] += $goodprice[$gid];
            $row['liststr'] .= ( $goodname[$gid] . "<br>" );
        }
    }
}

//Render::errormessage($result);
$_E['template']['goodlists'] = $result;
Render::render('goodlists','admin');