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
            $lid  = safe_post('lid','0');
            $name = safe_post('listname',null);
            $starttime = safe_post('starttime',null);
            $endtime = safe_post('endtime',null);
            
            $usergroups = '';//usergroup;
            $description = safe_post('detail','');
            $goodsarr = safe_post('goods',null);
            //Render::errormessage($_POST);
            if( !isset($name) || !isset($starttime) || !isset($endtime) || !isset($goodsarr) )
            {
                Render::errormessage("欄位不得為空","Add new list");
                Render::errormessage($endtime);
                break;
            }
            
            if( !checkdateformat($starttime) || !checkdateformat($endtime) )
            {
                Render::errormessage("時間錯誤","Add new list");
                break;
            }
            
            $date1 = new DateTime($starttime);
            $date2 = new DateTime($endtime);
            if( $date1 > $date2 )
            {
                Render::errormessage("開始時間晚於結束時間","Add new list");
                break;
            }
            
            if( !is_array($goodsarr) )
            {
                Render::errormessage("商品種類型態錯誤","Add new list");
                break;
            }
            
            foreach( $goodsarr as &$id )
            {
                if( !is_numeric($id) )
                {
                    Render::errormessage("商品型態數值錯誤","Add new list");
                    break;
                }
                $id = (int) $id;
                if( $id <= 0 )
                {
                    Render::errormessage("商品型態數值錯誤","Add new list");
                    break;
                }
            }
            $goodsarr = array_unique($goodsarr);
            if( empty($goodsarr) )
            {
                Render::errormessage("欄位不得為空","Add new list");
                break;
            }
            $goods = serialize($goodsarr);
            
            $table = SQL::tname('goodlist');
            
            if( $lid != '0')
            {
                //$sql_select = "SELECT `gid` FROM `goods` WHERE `gid` = ?";
            }
            else
            {
                #Ok insert to SQL
                $sql_insert = "INSERT INTO `$table`(`lid`, `name`, `starttime`, `endtime`, `description`, `goods`, `usergroups`, `status`) VALUES (NULL,?,?,?,?,?,?,1)";
                $res = SQL::prepare($sql_insert);
                $res->execute(array($name,$starttime,$endtime,$description,$goods,$usergroups));
            }
    }
}

//$_E['template']['gtoken'] = UserAccess::SetToken('goodsadd',900,false);
//Render::errormessage($_E['template']['gtoken'],"AS");
//Render::errormessage($_SESSION,"AS");

#prepare goods
#prepare list
$table = SQL::tname('goods');
$sql_select = "SELECT `gid`, `name` , `price` , `defaultnum` FROM `goods` WHERE `status` = 1";
$res = SQL::prepare($sql_select);
$res->execute();
$result = $res->fetchAll();

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
$sql_select = "SELECT `lid`,`name`,`starttime`,`endtime`,`goods` FROM `$table` WHERE `status` = 1";
$res = SQL::prepare($sql_select);
$res->execute();

$result = $res->fetchAll();

foreach($result as &$row)
{
    $row['goods'] = unserialize($row['goods']);
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