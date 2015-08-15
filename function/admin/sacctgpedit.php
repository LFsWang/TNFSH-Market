<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}

if( !$_G['root'] )
{
    Render::errormessage('權限不足');
    Render::render('index','admin');
    exit(0);
}
$gpid = safe_get('gpid');
if( !makeint($gpid) )
{
    $gpid = 0;
}

$tsaccount_group = SQL::tname('saccount_group');
$tstudent_account = SQL::tname('student_account');

$sql_select = "SELECT * FROM $tsaccount_group";
if(!( $group = SQL::fetch("SELECT * FROM $tsaccount_group WHERE `gpid`=?",array($gpid)) ))
{
    Render::errormessage('無此群組');
    Render::render('index','admin');
    exit(0);
}

$allacct = SQL::fetch("SELECT COUNT(*) FROM `$tstudent_account` WHERE gpid=?",array($gpid));
$_E['template']['group'] = $group;
$_E['template']['allacct']=$allacct[0];
Render::render('sacctgpedit','admin');