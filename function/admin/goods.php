<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
#status : 
# 1 : public to all admin (default)
# 0 : private

$allow_goodtype = array('normal','colthe');
$goodtype_to_zhtw = array( 'normal' => '一般商品' , 'colthe' => '衣服' );
$open_tab = false;

if( isset($_POST['method']) )
{
    //Render::errormessage($_FILES);
    //to do : token etc
    switch( $_POST['method'] )
    {
        case 'addnew':
        case 'modify':
        
            $open_tab = true;
            $data['name'] = safe_post('goodname',null);
            $data['type'] = safe_post('goodtype',null);
            $data['price'] = safe_post('goodprice',null);
            $data['goodprice']= safe_post('goodprice',null);
            $data['defaultnum']=safe_post('defaultnum',null);
            $data['maxnum']   = safe_post('maxnum',null);
            $data['description'] = safe_post('description','');
            
            $data['status']   = safe_post('status',null);
            $data['status'] = (int)$data['status'][0];
            
            $gid      = safe_post('gid','0');
            if( $gid == 0 ) $gid = null;
            
            if( isset($_FILES['goodgraph']) )
            {
                $image = $_FILES['goodgraph'] ;
            }
            
            $_imgid = upload_image($image);
            $data['image']= array();
            foreach($_imgid as $id)
                if( $id !== -1 )
                    $data['image'][]=$id;
            if( modify_good( $data , $gid  , $err ) )
            {
                Render::succmessage("修改成功!","Add new good");
            }
            else
            {
                Render::errormessage("修改失敗!","Add new good : error $err");
            }
            break;
        default :
            Render::errormessage("??","??");
    }
}

//$_E['template']['gtoken'] = UserAccess::SetToken('goodsadd',900,false);
//Render::errormessage($_E['template']['gtoken'],"AS");


#prepare list
$table = SQL::tname('goods');
$sql_select = "SELECT `gid`, `name`, `type`, `price`, `defaultnum` ,`status` FROM `$table` WHERE `owner`  = ?";
$res = SQL::prepare($sql_select);
if( !SQL::execute($res,array($_G['uid']) ) )
{
    $result = array();
    Render::errormessage("SQL ERROR WHEN GET LIST","goods");
}
else
{
    $result = $res->fetchAll();
}


foreach( $result as &$row )
{
    $row['type'] = $goodtype_to_zhtw[$row['type']];
}

$_E['template']['goodslist'] = $result;
$_E['template']['opentab'] = $open_tab;
Render::render('goods','admin');