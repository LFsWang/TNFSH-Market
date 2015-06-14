<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
define('USER_GUEST', 0 );
define('USER_NORMAL', 1 );
define('USER_ADMIN' , 2 );
$permission = array();
$permission['guest']['uid'] = "0";
$permission['guest']['usertype'] = USER_GUEST;
$permission['guest']['root'] = false;

$permission['admin']['suid'] = "0";
$permission['admin']['usertype'] = USER_NORMAL;

$permission['user']['uid'] = "0";
$permission['user']['usertype'] = USER_ADMIN ;

$_G = $permission['guest'];

class UserAccess{
    static function SetHashToken($namespace){
        if( !isset($_SESSION['htoken']) )$_SESSION['htoken'] = array();
        $token   = md5(uniqid($namespace,true));
        $_SESSION['htoken'][$namespace] = $token;
        return $token;
    }
    static function CheckHashToken($namespace,$value = null){
        if( !isset($_SESSION['htoken']) ) return false;
        if( !isset($_SESSION['htoken'][$namespace]) )return false;
        if( $value === null ) $value = safe_post('token');
        return $value === $_SESSION['htoken'][$namespace];
    }
    static function RemoveHashToken($namespace){
        if( !isset($_SESSION['htoken']) ) return ;
        if( !isset($_SESSION['htoken'][$namespace]) )return ;
        unset( $_SESSION['htoken'][$namespace] );
    }
    
    static function SetToken( $namespace, $timelimit = 900 )
    {
        global $_E;
        $token   = md5(uniqid($namespace,true));
        $timeout = time() + $timelimit;
        
        $_SESSION['token'][$namespace] = array();
        $_SESSION['token'][$namespace]['token'] = $token;
        $_SESSION['token'][$namespace]['timeout'] = $timeout;

            //$_E['DOMAIN'] ?
        setcookie(  $namespace , $token , $timeout , 
                    $_E['SITEDIR'] , '' , false , true );
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
    
    static function ExtendToken($namespace,$timelimit)
    {
        global $_E;
        if(    !isset( $_SESSION['token'] ) 
            || !isset( $_SESSION['token'][$namespace] )
            || !isset( $_SESSION['token'][$namespace]['token'] )
            || !isset( $_SESSION['token'][$namespace]['timeout'] ))
            return false;
        
        $token = $_SESSION['token'][$namespace]['token'];
        $timeout = time() + $timelimit;

        $_SESSION['token'][$namespace]['timeout'] = $timeout;

        setcookie(  $namespace , $token , $timeout , 
                    $_E['SITEDIR'] , '' , false , true );
        return $token;
    }
    
    static function SetLoginToken($uid,$utype,$root = false)
    {
        UserAccess::SetToken('token',900);
        $_SESSION['uid'] = (string)$uid;
        $_SESSION['usertype'] = (int) $utype;
        $_SESSION['root'] = $root;
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
            $_G['root'] = $_SESSION['root'];
            UserAccess::ExtendToken('token',900);
        }
    }
};