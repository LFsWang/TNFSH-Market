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
    //UPDATE `test_market`.`system` SET `value` = 'A' WHERE `system`.`id` = 'system_announcement';
    $table = SQL::tname('system');
    $pdo = SQL::getpdo();
    $sql_select = "UPDATE $table SET `value` = ? WHERE `id` = ?";
    
    $res = SQL::prepare($sql_select);
    $res->execute( array($value,$id) );
    return $value;
}

function httpRequest( $url , $post = null , $usepost =true )
{
    if( is_array($post) )
    {
        ksort( $post );
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
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER , true );
    
    $data = curl_exec($ch);
    curl_close($ch);
    if(!$data)
    {
        return false;
    }
    return $data;
}
	
    
    
    