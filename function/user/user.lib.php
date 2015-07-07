<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
define('NEWBIE_PRE','~new@');


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

function addAdminAccount($username,$password,$root)
{
    if( !checkAccountFormat($username) )
    {
        return ERROR_STRING_FORMAT;
    }
    if( !checkPasswordFormat($password) )
    {
        return ERROR_STRING_FORMAT;
    }
    if( $root ) $root = 1 ;
    else $root = 0 ;
    $password = GetPasswordHash($password);

    $table = SQL::tname('account');
    $sql_insert = "INSERT INTO `$table` (`uid`,`username`,`password`,`root`,`stats`) VALUES (NULL,?,?,?,'1');";
    
    $res = SQL::prepare($sql_insert);
    if( SQL::execute($res,array($username,$password,$root)) )
    {
        return ERROR_NO;
    }
    return ERROR_SQL_EXEC;
}

function addUserAccount($username,$password,$group,$newbie = false,$data = array())
{
    #data
    /*
        name
        grade (int)
        class (int)
        number(int)
    */
    if( !checkAccountFormat($username) )
    {
        return ERROR_STRING_FORMAT;
    }
    if( !checkPasswordFormat($password) )
    {
        return ERROR_STRING_FORMAT;
    }
    if( !is_numeric($group) )
    {
        return ERROR_INT_FORMAT."Group";
    }
    $group = (int)$group;
    
    if( $newbie ) $newbie = true ;
    else $newbie = false;

    $args = array('grade','class','number');
    foreach( $args as $i )
    {
        if( isset($data[$i]) && !empty($data[$i]) )
        {
            if( !is_numeric($data[$i]) )
            {
                return ERROR_INT_FORMAT.$i;
            }
            $data[$i] = (int)$data[$i];
        }
        else
        {
            $data[$i] = 0;
        }
    }
    if( !isset($data['name']) )
    {
        $data['name'] = null;
    }
    
    $tstudent_account = SQL::tname('student_account');
    //check username avaible
    $sql_count = "SELECT COUNT(`suid`) AS `sum` FROM `$tstudent_account` WHERE `username` = ? OR `username` = ?";
    if( $res = SQL::fetch($sql_count,array(NEWBIE_PRE.$username,$username)) )
    {
        if( $res['sum'] != 0 )
        {
            return ERROR_SAME_INDEX."帳號重複";
        }
    }
    else
    {
        return ERROR_SQL_EXEC;
    }
    if( $newbie )
    {
        $username = NEWBIE_PRE.$username;
    }
    #insert
    $password = GetPasswordHash($password);
    $sql_insert = "INSERT INTO `$tstudent_account`(`suid`, `username`, `password`, `gpid`, `name`, `grade`, `class`, `number`) VALUES (NULL,?,?,?,?,?,?,?)";

    if( SQL::query($sql_insert,array($username,$password,$group,$data['name'],$data['grade'],$data['class'],$data['number'])) )
    {
        return ERROR_NO;
    }
    return ERROR_SQL_EXEC;
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
define('LOGIN_NO_SUCH_ACCOUNT',"無此帳號");
define('LOGIN_INVLID_ACCOUNT' ,"帳號錯誤");
define('LOGIN_INVLID_PASSWORD',"密碼錯誤");
define('LOGIN_INVLID_RECAPTCHA',"驗證問答錯誤");
define('LOGIN_UA_FUNC_ERROR'  ,"系統錯誤");
define('LOGIN_TYPE_ERROR'     ,"登入類別錯誤");
function login( $username , $password , $type , &$error )
{
    if( !isset( $error ) )
    {
        $error = '';
    }
    if( !recaptcha() )
    {
        $error = LOGIN_INVLID_RECAPTCHA;
        return false;
    }
    if( !checkAccountFormat($username) )
    {
        $error = LOGIN_INVLID_ACCOUNT;
        return false;
    }
    if( !checkPasswordFormat($password) )
    {
        $error = LOGIN_INVLID_PASSWORD;
        return false;
    }
    switch( $type )
    {
        case 'admin' :
            $taccount = SQL::tname('account');
            $row = SQL::fetch("SELECT * FROM $taccount WHERE `username` = ?",array($username) );
            if( !$row ){
                $error = LOGIN_NO_SUCH_ACCOUNT;
                return false;
            }
            if( !password_verify( $password , $row['password'] ) )
            {
                $error = LOGIN_INVLID_PASSWORD;
                return false;
            }        
            if( !UserAccess::SetLoginToken( $row['uid'] , USER_ADMIN ,$row['root'] ) )
            {
                $error = LOGIN_UA_FUNC_ERROR;
                return false;
            }
            $error = "Welcome! Admin";
            $_SESSION['userdata'] = $row;
            return USER_ADMIN;
            break;
            
        case 'newbie':
            $username = NEWBIE_PRE.$username;
        case 'user'  :
            $tstudent_account = SQL::tname('student_account');
            $row = SQL::fetch("SELECT * FROM $tstudent_account WHERE `username` = ?",array($username) );
            if( !$row ){
                $error = LOGIN_NO_SUCH_ACCOUNT;
                return false;
            }
            if( !password_verify( $password , $row['password'] ) )
            {
                $error = LOGIN_INVLID_PASSWORD;
                return false;
            }
            if( !UserAccess::SetLoginToken( $row['suid'] , USER_NORMAL ) )
            {
                $error = LOGIN_UA_FUNC_ERROR;
                return false;
            }
            $error = "Welcome! User";
            $_SESSION['userdata'] = $row;
            return USER_NORMAL;
            break;
            
        default :
            $error = LOGIN_TYPE_ERROR;
            return false;
            break;
    }
    $error = LOGIN_TYPE_ERROR;
    return false;
}