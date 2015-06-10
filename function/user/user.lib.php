<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}



#Account

function checkAccountFormat($account)
{
    $pattern  = '/^[a-zA-Z0-9]{3,30}$/';
    if( !is_string($account) )
        return false;
    return preg_match($pattern,$account);
}

function checkPasswordFormat($realPass)
{
    $pattern  = '/^[a-zA-Z0-9]{3,30}$/';
    if( !is_string($realPass) )
        return false;
    return preg_match($pattern,$realPass);
}

function GetPasswordHash($realPass)
{
    if( !checkPasswordFormat($realPass) )
    {
        return false;
    }
    $hash = password_hash($realPass,PASSWORD_DEFAULT);
    return $hash;
}

function addAdminAccount($username,$password)
{
    if( !checkAccountFormat($username) )
    {
        return false;
    }
    if( !checkPasswordFormat($password) )
    {
        return false;
    }
    
    $password = GetPasswordHash($password);

    $table = SQL::tname('account');
    $sql_insert = "INSERT INTO `$table` (`uid`, `username`, `password`, `stats`) VALUES (NULL,?,?,'1');";
    
    $res = SQL::prepare($sql_insert);
    $res->execute( array($username,$password) );

    return true;
}

function recaptcha()
{
    global $_E;
    if( !$_E['loginrecaptcha'] )
    {
        return true;
    }
    $res = httpRequest( 'https://www.google.com/recaptcha/api/siteverify' ,
                    array( 'secret'     =>$_E['recaptcha']['secret'] ,
                           'response'   =>$_POST['g-recaptcha-response'],) ,true ,true);
                           #'remoteip'   =>$_SERVER['REMOTE_ADDR']));
    $res = json_decode($res);
    return $res->success;
}


#return : Account Type
# false : fail
# 1 :student
# 2 :admin
function login( $username , $password , &$error )
{
    if( !isset( $error ) )
    {
        $error = '';
    }
    if( !recaptcha() )
    {
        $error = "Recaptcha Error!";
        return false;
    }
    if( !checkAccountFormat($username) )
    {
        $error = "Account Error!";
        return false;
    }
    if( !checkPasswordFormat($password) )
    {
        $error = "Password Error!";
        return false;
    }
    
    $table = SQL::tname('account');
    $sql_select = "SELECT * FROM $table WHERE `username` = ?";

    $res = SQL::prepare($sql_select);
    if( !SQL::execute($res,array($username) ) )
    {
        return false;
    }
    $row = $res->fetch();
    
    if( $row !== false )
    {#login as admin
        if( password_verify( $password , $row['password'] ) )
        {
            $error = "Something Wrong!";
            if( !UserAccess::SetLoginToken( $row['uid'] , 2 ) )
                return false;
            
            $error = "Welcome! Admin";
            $_SESSION['userdata'] = $row;
            return 2;
        }
        else
        {
            $error = "Password Error!";
            return false;
        }
    }
    else
    {#login as student
        $table = SQL::tname('student_account');
        $sql_select = "SELECT * FROM $table WHERE `username` = ?";
        $res = SQL::prepare($sql_select);
        $res->execute( array($username) );
        $data = $res->fetchAll();
        
        if( $data )
        {
            foreach( $data as $row )
            {
                if( password_verify( $password , $row['password'] ) )
                {
                    $error = "Something Wrong!";
                    if( !UserAccess::SetLoginToken( $row['suid'] , 1 ) )
                        return false;
                    
                    $error = "Welcome! User";
                    $_SESSION['userdata'] = $row;
                    return 1;
                }
            }
            $error = "Password Error!";
            return false;
        }
    }
    $error = "No Such User!";
    return false;
}