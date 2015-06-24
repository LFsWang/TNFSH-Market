<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
require_once('user.lib.php');

UserAccess::SetLogout();
header("Location:index.php");
