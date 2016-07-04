<?php
#Default Setting
#DON'T CHANGE THIS FILE!
#If you want to replace setting , yout should edit LocalSetting.php

define('IN_SYSTEM',1);
session_start();
date_default_timezone_set( "Asia/Taipei" );
#Data Base

$_DB['query_string'] = 'mysql:host=localhost;dbname=test_market';
$_DB['prename'] = '';
$_DB['dbaccount'] = '';
$_DB['dbpassword'] = '';

#Environment
$_E = array();
$_E['ROOT'] = __DIR__;
$_E['SITEDIR'] = '/tnfsh-market/';
$_E['DOMAIN']  = 'localhost';

$_E['loginrecaptcha'] = false;
$_E['recaptcha']['secret']  = '';
$_E['recaptcha']['site']    = '';

#Site Setting
$_E['site']['admin']=array(1);
$_E['site']['name'] ='臺南一中採購系統';

#Error Message
$_E['template']['alert'] ='';


if( file_exists('LocalSetting.php') )
{
    require_once('LocalSetting.php');
}

#prapare data
$_E['SITEROOT'] = "//".$_E['DOMAIN'].$_E['SITEDIR'];
if( isset($cgUseHTTPS) && $cgUseHTTPS === true )
{
    $_E['SITEROOT'] = 'https:'.$_E['SITEROOT'];
}


require_once('function/sql.php');
require_once('function/lib.php');
require_once('function/renderCore.php');
require_once('function/userCore.php');
SQL::intro();
UserAccess::intro();