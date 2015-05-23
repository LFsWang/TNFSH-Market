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
            $goodname = safe_post('goodname',null);
            $goodtype = safe_post('goodtype',null);
            $goodprice= safe_post('goodprice',null);
            $defaultnum=safe_post('defaultnum',null);
            $maxnum   = safe_post('maxnum',null);
            $gid      = safe_post('gid','0');
            $owner    = $_G['uid'];
            $description = safe_post('description','');
            $status   = safe_post('status',array('0'));
            $image = array();
            if( isset($_FILES['goodgraph']) )
            {
                $image = $_FILES['goodgraph'] ;
            }
            if( !isset($goodname) || !isset($goodtype) || !isset($goodprice) || !isset($defaultnum) || !isset($maxnum) || !isset($status) )
            {
                Render::errormessage("欄位不得為空","Add new good");
                break;
            }
            
            if( !in_array($goodtype,$allow_goodtype) )
            {
                Render::errormessage("商品型態錯誤","Add new good");
                break;
            }
            
            if( !is_numeric($goodprice) || !is_numeric($defaultnum) )
            {
                Render::errormessage("價格/預設數量需為數字","Add new good");
                break;
            }
            $goodprice = (int)$goodprice;
            $defaultnum= (int)$defaultnum;
            if( $defaultnum < 0 || $maxnum < 0)
            {
                Render::errormessage("預設數量不得低於0","Add new good");
                break;
            }
            
            if( !is_numeric($status[0]) )
            {
                Render::errormessage("屬性錯誤","Add new good");
                break;
            }
            $status = (int)$status[0];
            if( $status !== 0 && $status !== 1)
            {
                Render::errormessage("屬性錯誤!","Add new good");
                break;
            }
            
            //Warning
            if( $goodprice <= 0 )
            {
                Render::errormessage("價格低於0!","Add new good");
            }
            
            $table = SQL::tname('goods');
            
            //Render::errormessage($image);
            $imgid = upload_image($image);
            //Render::errormessage($imgid);
            if( $gid !=0 )
            {
                if( !is_numeric($gid) )
                {
                    Render::errormessage("GID 錯誤","Add new good");
                    break;
                }
                $gid = (int)$gid;
                $sql_select = "SELECT `gid` FROM `goods` WHERE `gid` = ? AND `owner` = ?";
                $res = SQL::prepare($sql_select);
                if( !SQL::execute($res,array($gid,$owner) ) )
                {
                    Render::errormessage("SQL 錯誤","Add new good");
                    break;
                }
                $res = $res->fetch();
                if( !$res )
                {
                    Render::errormessage("不存在的 GID","Add new good");
                    break;
                }
                #Ok update to SQL
                $sql_update="UPDATE `goods` SET `name`=?,`type`=?,`price`=?,`defaultnum`=?,`maxnum`=?,`description`=?,`graph`='',`status`=? WHERE `gid` = ?";
                $res = SQL::prepare($sql_update);
                if( SQL::execute( $res , array($goodname,$goodtype,$goodprice,$defaultnum,$maxnum,$description,$status,$gid) ) )
                {
                    Render::succmessage("修改成功!","Add new good");
                }
                else
                {
                    Render::errormessage("修改失敗!","Add new good");
                }             
            }
            else
            {
                $gid = null;
                #Ok insert to SQL
                $sql_insert = "INSERT INTO `goods`(`gid`, `owner`, `name`, `type`, `price`, `defaultnum`, `maxnum`,`description`, `graph`, `status`) VALUES (?,?,?,?,?,?,?,?,'',?)";

                $res = SQL::prepare($sql_insert);
                if( SQL::execute($res,array($gid,$owner,$goodname,$goodtype,$goodprice,$defaultnum,$maxnum,$description,$status)))
                {
                    Render::succmessage("新增成功!","Add new good");
                }
                else
                {
                    Render::errormessage("新增失敗!","Add new good");
                }    
            }
            break;
            //End of Addnew
        default :
            Render::errormessage("??","??");
    }
}

//$_E['template']['gtoken'] = UserAccess::SetToken('goodsadd',900,false);
//Render::errormessage($_E['template']['gtoken'],"AS");


#prepare list
$table = SQL::tname('goods');
$sql_select = "SELECT `gid`, `name`, `type`, `price`, `defaultnum` ,`status` FROM `goods` WHERE `owner`  = ?";
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