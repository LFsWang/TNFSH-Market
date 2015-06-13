<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
if( $_G['usertype'] !== USER_ADMIN )
{
    exit('Access denied (T)');
}
/*Goods*/
define( 'GD_PRIVATE' , 0 );
define( 'GD_PUBLIC'  , 1 );
function modify_good( $data , $gid = null , &$error = null )
{
    global $_G;
    $tgoods = SQL::tname('goods');
    $tgoods_image = SQL::tname('goods_image');
    #deta format
    /*
        $data   =>  name
                =>  type
                =>  price
                =>  defaultnum
                =>  maxnum
                =>  description
                =>  status
                =>  array of image
    */
    
    #check data
    if( $gid === null ){
    }
    else if( is_numeric($gid) )
    {
        $gid = (int) $gid;
        if( $gid <= 0 )
        {
            $error = ERROR_INT_FORMAT;
            return false;
        }
    }
    else
    {
        $error = ERROR_DATA_MISSING;
        return false;
    }
    
    $args_str = array('name','type','price','defaultnum','maxnum','description','status','image');
    foreach( $args_str as $var )
    {
        if( !isset( $data[$var] ) )
        {
            //Render::errormessage($data);
            $error = ERROR_DATA_MISSING.$var;
            return false;
        }
    }
    if( empty($data['name']) )
    {
        $error = ERROR_DATA_MISSING;
        return false;
    }
    
    if( $data['type'] != GD_PRIVATE && $data['type'] != GD_PUBLIC )
    {
        $error = ERROR_INT_FORMAT."type";
        return false;
    }
    
    if( !is_numeric($data['price']) || !is_numeric($data['defaultnum']) || !is_numeric($data['maxnum']) )
    {
        $error = ERROR_INT_FORMAT."$";
        return false;
    }
    $data['price'] = (int) $data['price'];
    $data['defaultnum'] = (int) $data['defaultnum'];
    $data['maxnum'] = (int) $data['maxnum'];
    if( $data['price'] < 0 || $data['defaultnum'] < 0 || $data['maxnum'] < 0 || $data['defaultnum'] > $data['maxnum'] )
    {
        $error = ERROR_INT_FORMAT."ZERO";
        return false;
    }
    
    if( $data['status'] != 0 && $data['status'] != 1 )
    {
        $error = ERROR_INT_FORMAT."status";
        return false;
    }
    
    if( !is_array($data['image']) )
    {
        $error = ERROR_ARRAY_FORMAT;
        return false;
    }
    foreach( $data['image'] as $imgid )
    {
        if( !is_numeric($imgid) )
        {
            $error = ERROR_INT_FORMAT;
            return false;
        }
    }        
    if( isset($gid) )
    {
        $sql_select = "SELECT `gid` FROM `$tgoods` WHERE `gid` = ? AND `owner` = ? OR ?";
        $res = SQL::prepare($sql_select);
        if( !SQL::execute($res,array($gid,$_G['uid'],$_G['root'])) )
        {
            $error = ERROR_SQL_EXEC;
            return false;
        }
        if( !$res->fetch() )
        {
            $error = ERROR_PREMISSION_DENIED;
            return false;
        }
    }
    $sql_insert="
    INSERT INTO `$tgoods`(`gid`, `owner`, `name`, `type`, `price`, `defaultnum`, `maxnum`, `description`, `status`) VALUES (?,?,?,?,?,?,?,?,?) 
    ON DUPLICATE KEY UPDATE
    `name` = ? ,
    `type` = ? ,
    `price` = ?,
    `defaultnum` = ?,
    `maxnum` = ?,
    `description`=?,
    `status`=?;";
    
    $res = SQL::prepare($sql_insert);
    if( !SQL::execute($res,array($gid,$_G['uid'],$data['name'],$data['type'],$data['price'],$data['defaultnum'],$data['maxnum'],$data['description'],$data['status'],$data['name'],$data['type'],$data['price'],$data['defaultnum'],$data['maxnum'],$data['description'],$data['status'])) )
    {
        $error = ERROR_SQL_EXEC;
        return false;
    }
    
    if( $gid === null )
    {
        $gid = SQL::lastInsertId();
    }
    
    //add goods image
    $sql_insert = "INSERT INTO $tgoods_image (`gid`, `imgid`) VALUES (?,?)";
    foreach( $data['image'] as $imgid )
    {
        $res = SQL::prepare($sql_insert);
        if(!SQL::execute($res,array($gid,$imgid)))
        {
            $error = ERROR_SQL_EXEC;
            //return false;
        }
    }
    return true;
}
/*Good List*/
function modify_goodlist( $data , $lid = null , &$error = null )
{
    global $_G;
    $tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
    $tgoodlist = SQL::tname('goodlist');
    #deta format
    /*
        $data   => name
                => starttime
                => endtime
                => description
                => array of goods
    */
    #Check data
    
    if( $lid === null ){
    }
    else if( is_numeric($lid) )
    {
        $lid = (int) $lid;
        if( $lid <= 0 )
        {
            $error = ERROR_INT_FORMAT;
            return false;
        }
    }
    else
    {
        $error = ERROR_DATA_MISSING;
        return false;
    }
    
    $args_str = array('name','starttime','endtime','description','goods');
    foreach( $args_str as $var )
    {
        if( !isset( $data[$var] ) )
        {
            $error = ERROR_DATA_MISSING;
            return false;
        }
    }
    
    if( !checkdateformat($data['starttime']) || !checkdateformat($data['endtime']) )
    {
        $error = ERROR_TIME_FORMAT;
        return false;
    }
    
    $date1 = new DateTime($data['starttime']);
    $date2 = new DateTime($data['endtime']);
    if( $date1 > $date2 )
    {
        $error = ERROR_TIME_FORMAT;
        return false;
    }
    
    if( !is_array($data['goods']) )
    {
        $error = ERROR_ARRAY_FORMAT;
        return false;
    }
    foreach( $data['goods'] as &$id )
    {
        if( !is_numeric($id) )
        {
            $error = ERROR_INT_FORMAT;
            return false;
        }
        $id = (int) $id;
        if( $id <= 0 )
        {
            $error = ERROR_INT_FORMAT;
            return false;
        }
    }
    $data['goods'] = array_unique($data['goods']);
    //Check owner?
    //First insert into goodlist
    $sql_insert="
    INSERT INTO `$tgoodlist`(`lid`, `owner`, `name`, `starttime`, `endtime`, `description`, `status`) VALUES (?,?,?,?,?,?,?) 
    ON DUPLICATE KEY UPDATE
    `name` = ? ,
    `starttime` = ? ,
    `endtime` = ?,
    `description` = ?,
    `status` = ?;";
    $res = SQL::prepare($sql_insert);
    $var = array($lid,$_G['uid'],$data['name'],$data['starttime'],$data['endtime'],$data['description'],1,
    $data['name'],$data['starttime'],$data['endtime'],$data['description'],1,);
    if( !SQL::execute($res,$var) )
    {
        $error = ERROR_SQL_EXEC;
        return false;
    }
    
    //2.Get Lid
    if( $lid == null )
    {
        $lid = SQL::lastInsertId();
    }
    //3. del old data in $tgoodlist_goodstable
    $sql_delete = "DELETE FROM `$tgoodlist_goodstable` WHERE `lid` = ?";
    $res = SQL::prepare($sql_delete);
    if( !SQL::execute($res,array($lid)) )
    {
        $error = ERROR_SQL_EXEC;
        return false;
    }
    //4.add goods
    $sql_insert = "INSERT INTO $tgoodlist_goodstable (`lid`, `gid`) VALUES (?,?)";
    foreach( $data['goods'] as $gid )
    {
        $res = SQL::prepare($sql_insert);
        if(!SQL::execute($res,array($lid,$gid)))
        {
            $error = ERROR_SQL_EXEC;
            return false;
        }
    }
    return ERROR_NO;
}

#Image admin functions
function modifyImageInfo( $info , $imgid )
{
    #info format
    /*
    info => title
         => description
    */
    global $_G;
    if( !is_array($info) )
    {
        return ERROR_ARRAY_FORMAT;
    }
    if( !isset($info['title']) || !isset($info['description']) )
    {
        return ERROR_STRING_FORMAT;
    }
    if( !is_numeric($imgid) )
    {
        return ERROR_INT_FORMAT;
    }
    $imgid = (int)$imgid;
    $timage = SQL::tname('image');
    $sql_select = "SELECT `imgid` FROM `$timage` WHERE `owner` = ? AND `imgid` = ?";
    $res = SQL::prepare($sql_select);
    if( SQL::execute($res,array($_G['uid'],$imgid)) )
    {
        $res = $res->fetch();
        if( !$res )
        {
            return ERROR_PREMISSION_DENIED;
        }
    }
    else
    {
        return ERROR_SQL_EXEC;
    }
    $sql_update = "UPDATE `image` SET `title` = ?,`description` = ? WHERE `imgid` = ?";
    $res = SQL::prepare($sql_update);
    if( !SQL::execute($res,array($info['title'],$info['description'],$imgid)) )
    {
        return ERROR_SQL_EXEC;
    }
    return ERROR_NO;
}