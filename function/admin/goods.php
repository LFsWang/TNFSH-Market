<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
$allow_goodtype = array('normal','colthe');
$goodtype_to_zhtw = array( 'normal' => '一般商品' , 'colthe' => '衣服' );
$open_tab = false;
if( isset($_POST['method']) )
{
    //token etc
    switch( $_POST['method'] )
    {
        case 'addnew':
        case 'modify':
            //Render::errormessage($_POST,"AS");
            $open_tab = true;
            //Render::errormessage($_FILES,"??");
            $goodname = safe_post('goodname',null);
            $goodtype = safe_post('goodtype',null);
            $goodprice= safe_post('goodprice',null);
            $defaultnum=safe_post('defaultnum',null);
            $maxnum   = safe_post('maxnum',null);
            $gid      = safe_post('gid','0');
            $description = safe_post('description','');
            if( !isset($goodname) || !isset($goodtype) || !isset($goodprice) || !isset($defaultnum) || !isset($maxnum) )
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
            
            //Warning
            if( $goodprice <= 0 )
            {
                Render::errormessage("價格低於0!","Add new good");
            }
            
            $table = SQL::tname('goods');
            
            if( $gid !=0 )
            {
                if( !is_numeric($gid) )
                {
                    Render::errormessage("GID 錯誤","Add new good");
                    break;
                }
                $gid = (int)$gid;
                $sql_select = "SELECT `gid` FROM `goods` WHERE `gid` = ?";
                $res = SQL::prepare($sql_select);
                $res->execute(array($gid));
                $res = $res->fetch();
                if( !$res )
                {
                    Render::errormessage("不存在的 GID","Add new good");
                    break;
                }
                #Ok update to SQL
                $sql_update="UPDATE `goods` SET `name`=?,`type`=?,`price`=?,`defaultnum`=?,`maxnum`=?,`description`=?,`graph`='' WHERE `gid` = ?";
                $res = SQL::prepare($sql_update);
                $res->execute(array($goodname,$goodtype,$goodprice,$defaultnum,$maxnum,$description,$gid));
                Render::succmessage("修改成功!","Add new good");
            }
            else
            {
                $gid = null;
                #Ok insert to SQL
                $sql_insert = "INSERT INTO `goods`(`gid`, `name`, `type`, `price`, `defaultnum`, `maxnum`,`description`, `graph`, `status`) VALUES (?,?,?,?,?,?,?,'',1)";

                $res = SQL::prepare($sql_insert);
                $res->execute( array($gid,$goodname,$goodtype,$goodprice,$defaultnum,$maxnum,$description) );
                //var_dump($res->errorInfo ());
                //Render::errormessage($res->errorInfo(),"??");
                Render::succmessage("新增成功!","Add new good");
                
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
$sql_select = "SELECT `gid`, `name`, `type`, `price`, `defaultnum` FROM `goods` WHERE `status` = 1";
$res = SQL::prepare($sql_select);
$res->execute();

$result = $res->fetchAll();
foreach( $result as &$row )
{
    $row['type'] = $goodtype_to_zhtw[$row['type']];
}
//Render::errormessage($result);
$_E['template']['goodslist'] = $result;
$_E['template']['opentab'] = $open_tab;
Render::render('goods','admin');