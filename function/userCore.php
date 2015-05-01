<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}


$permission = array();
$permission['guest']['uid'] = "0";
$permission['guest']['usertype'] = 0;

$permission['admin']['uid'] = "0";
$permission['admin']['usertype'] = 1;

$permission['user']['uid'] = "0";
$permission['user']['usertype'] = 2;

$_G = $permission['guest'];

class UserAccess{
    static function SetToken( $namespace, $timelimit = 900 , $usecookie = true )
    {if( $namespace == 'goodsadd' )die('D');
        global $_E;
        $token   = md5(uniqid($namespace,true));
        $timeout = time() + $timelimit;
        
        $_SESSION['token'][$namespace] = array();
        $_SESSION['token'][$namespace]['token'] = $token;
        $_SESSION['token'][$namespace]['timeout'] = $timeout;
        if( $usecookie )
        {
            //$_E['DOMAIN'] ?
            setcookie(  $namespace , $token , $timeout , 
                        $_E['SITEDIR'] , '' , false , true );
        }
        return $token;
    }
    
    static function CheckToken($namespace , $string = null )
    {
        if( $string === null )
        {
            if( !isset( $_COOKIE[$namespace] ) )
                return false;
            $string = $_COOKIE[$namespace];
        }
        
        if(    !isset( $_SESSION['token'] ) 
            || !isset( $_SESSION['token'][$namespace] )
            || !isset( $_SESSION['token'][$namespace]['token'] ) )
            return false;
            
        if( time() > $_SESSION['token'][$namespace]['timeout'] )
            return false;
        
        return $string === $_SESSION['token'][$namespace]['token'];
    }
    
    static function SetLoginToken($uid,$utype)
    {
        UserAccess::SetToken('token',1800);
        $_SESSION['uid'] = (string)$uid;
        $_SESSION['usertype'] = (int) $utype;
        return true;
    }
    
    static function SetLogout()
    {
        session_destroy();
        foreach($_COOKIE as $name => $data)
            UserAccess::SetToken($name,-1);
        return true;
    }
    
    static function intro()
    {
        global $_G;
        if( UserAccess::CheckToken('token') )
        {
            $_G = $_SESSION['userdata'];
            $_G['uid'] = $_SESSION['uid'];
            $_G['usertype'] = $_SESSION['usertype'];
        }
    }
};