<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

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