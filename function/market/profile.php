<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
require_once('panel.php');

//Render::errormessage($_G);
Render::render('profile','market');