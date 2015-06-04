<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
//Common Error Code
define('ERROR_NO',0);
define('ERROR_DATA_MISSING',1);

define('ERROR_TIME_FORMAT',2);
define('ERROR_ARRAY_FORMAT',3);
define('ERROR_INT_FORMAT',4);

define('ERROR_SQL_EXEC',100);

define('ERROR_OTHERS',9999);
function getsysvalue($id)
{
    $table = SQL::tname('system');
    $pdo = SQL::getpdo();
    $sql_select = "SELECT `value` FROM $table WHERE `id` = ?";
    
    $res = SQL::prepare($sql_select);
    $res->execute( array($id) );
    
    $row = $res->fetch();

    if(!$row)return false;
    return $row['value'];
}

function updatesysvalue($id,$value)
{
    $table = SQL::tname('system');
    $sql_update = "INSERT INTO $table (`id`, `value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value` = ?";
    //$sql_update = "UPDATE $table SET `value` = ? WHERE `id` = ?";
    
    $res = SQL::prepare($sql_update);
    SQL::execute( $res , array($id,$value,$value) );
    return $value;
}

function httpRequest( $url , $post = null , $usepost =true , $usessl = false )
{
    if( is_array($post) )
    {
        ksort( $post );
        //echo http_build_query( $post );
        $post = http_build_query( $post );
        
    }
    
    $ch = curl_init();
    curl_setopt( $ch , CURLOPT_URL , $url );
    curl_setopt( $ch , CURLOPT_ENCODING, "UTF-8" );
    if($usepost)
    {
        curl_setopt( $ch , CURLOPT_POST, true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $post );
    }
    if($usessl)
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    }
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER , true );
    
    $data = curl_exec($ch);
    curl_close($ch);
    if(!$data)
    {
        return false;
    }
    return $data;
}

function throwjson($status,$data)
{
    exit( json_encode( array( 'status' => $status , 'data' => $data ) ) );
}

function safe_post($name,$default = false)
{
    if( isset( $_POST[$name] ) )
        return $_POST[$name];
    return $default;
}

function safe_get($name,$default = false)
{
    if( isset( $_GET[$name] ) )
        return $_GET[$name];
    return $default;
}

function checkdateformat($datestr)
{
    if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$datestr))
    {
        return true;
    }else{
        return false;
    }
}

#return array of gid
# -1 : error
function upload_image($files)
{
    global $_E,$_G;
    if(!isset($files['name'])){
        return array();
    }
    $sz = count($files['name']);
    
    //$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_BMP);
    $allowedTypes = array(  IMAGETYPE_PNG  => ".png", 
                            IMAGETYPE_JPEG => ".jpg",
                            IMAGETYPE_BMP  => ".bmp");
    
    $savedir = $_E['ROOT'].'/image/';
    $gidlist = array();
    for( $i=0 ; $i<$sz ; ++$i )
    {
        $name = $files["name"][$i];
        $type = $files["type"][$i];
        $tmp  = $files["tmp_name"][$i];
        $error= $files["error"][$i];
        if( $error !==0 )
        {
            $gidlist[] = -1;
            continue;
        }
        
        $detectedType = exif_imagetype($tmp);
        if( !isset($allowedTypes[$detectedType]) )
        {
            $gidlist[] = -1;
            continue;
        }
        
        $hash_name = md5( uniqid( $tmp , true ) ) . $allowedTypes[$detectedType];
        move_uploaded_file($tmp,$savedir.$hash_name);
        $table = SQL::tname('image');
        $sql_insert = "INSERT INTO `$table`(`imgid`, `owner`, `timestamp`,`realname`, `hashname`,`title`,`description`) VALUES (NULL,?,NULL,?,?,'',?)";
        $res = SQL::prepare($sql_insert);
        if( !SQL::execute($res,array($_G['uid'],$name,$hash_name,$name)) )
        {
            Render::errormessage($hash_name." insert error!",'image');
            $gidlist[] = -1;
        }
        else
        {
            $id = SQL::lastInsertId();
            $gidlist[] = (int)$id;
        }    
    }
    return $gidlist;
}

function GetImageNameById($id,&$info = null)
{
    $table = SQL::tname('image');
    $sql_select = "SELECT * FROM `$table` WHERE `imgid` = ?";
    $res = SQL::prepare($sql_select);
    if( !is_numeric($id) )
    {
        return false;
    }
    if( SQL::execute($res,array((int)$id)) )
    {
        $res = $res->fetch();
        if( isset($res['hashname']) )
        {
            if( isset($info) )
            {
                $info = $res;
            }
            return $res['hashname'];
        }
    }
    return false;
}