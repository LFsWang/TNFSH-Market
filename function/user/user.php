<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
require_once('user.lib.php');

#$action is in api.php
switch( $action )
{
    case 'login' :
        if( $_G['uid'] != 0 || $_G['usertype'] !=0 )
        {
            throwjson('error','logined!');
        }
        if( !isset($_POST['account']) || !isset($_POST['password']) )
        {
            throwjson('error','Empty account or password!');
        }
        $acct = $_POST['account'];
        $pass = $_POST['password'];
        if( login($acct,$pass,$msg) )
        {
            //TODO register token
            throwjson('SUCC','');
        }
        else
        {
            throwjson('error',$msg);
        }
        break;
    case 'logout':
        if( $_G['uid'] == 0 || $_G['usertype'] ==0 )
        {
            throwjson('error','Not login!');
        }
        UserAccess::SetLogout();
        header("Location:index.php");
}


throwjson('error','Developing');