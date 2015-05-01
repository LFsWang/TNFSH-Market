<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
$allow_goodtype = array('normal','colthe');
$goodtype_to_zhtw = array( 'normal' => '一般商品' , 'colthe' => '衣服' );
if( isset($_POST['method']) )
{
    
}

//$_E['template']['gtoken'] = UserAccess::SetToken('goodsadd',900,false);
//Render::errormessage($_E['template']['gtoken'],"AS");
//Render::errormessage($_SESSION,"AS");

#prepare list
$table = SQL::tname('goods');
$sql_select = "SELECT `gid`, `name` FROM `goods` WHERE `status` = 1";
$res = SQL::prepare($sql_select);
$res->execute();

$result = $res->fetchAll();

//Render::errormessage($result);
$_E['template']['goodslist'] = $result;
Render::render('goodlists','admin');