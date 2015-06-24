<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
require_once('user.lib.php');

if( $_G['uid'] != 0 || $_G['usertype'] !=0 )
{
    throwjson('error','logined!');
}
$acct = safe_post('account',null);
$pass = safe_post('password',null);
$method = safe_post('type',null);
#function login will check all args
if( $type = login($acct,$pass,$method,$msg) )
{
    //TODO register token
    throwjson('SUCC',$type);
}
else
{
    SQL::log('login',"[$acct] want to login but fail : $msg");
    throwjson('error',$msg);
}