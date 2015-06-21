<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
$tstudent_account = SQL::tname('student_account');
$tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
$torderlist_detail = SQL::tname('orderlist_detail');
$torderlist = SQL::tname('orderlist');

$lid = safe_get('lid');
$gid = safe_get('gid');
$grade = safe_get('grade');
$class = safe_get('class');
$optAsPDF = safe_get('pdf',null);

if( !makeint($lid) )
{
    Render::errormessage('ERROR LID');
    Render::render('index','admin');
    exit(0);
}
if( !makeint($gid) )
{
    Render::errormessage('ERROR GID');
    Render::render('index','admin');
    exit(0);
}
//top
//got all class
//
#format
#grade  class 
# if class = all => 總表
#else => 班級

$allclass = SQL::fetchAll("SELECT `grade`, `class` , COUNT(*) AS `total`
FROM `$tstudent_account` WHERE `gpid` IN (SELECT `gpid` FROM `$tgoodlist_accountgroup` WHERE `lid` = 1)
GROUP BY `grade`, `class`
ORDER BY `grade` ASC");

//Render::errormessage($allclass);
$classlist = array();
if( $allclass )
{
    foreach( $allclass as $row )
    {
        $classlist[] = array( $row['grade'] , $row['class'] , $row['total'] );
    }
}

$gooddata = GetGoodByGID($gid);
$goodslist = GetGoodlistByLID($lid);
if( !$gooddata )
{
    Render::errormessage('ERROR GetGoodByGID');
    Render::render('index','admin');
    exit(0);
}
if( !$goodslist )
{
    Render::errormessage('ERROR GetGoodlistByLID');
    Render::render('index','admin');
    exit(0);
}

//if class = all 總表
$_E['template']['good']=$gooddata;
$_E['template']['goodslist']=$goodslist;
$_E['template']['maintb']='good_summary.err';
$_E['template']['classlist'] = $classlist;
$_E['template']['classname'] = '';
if( $class == 'all' ) $_E['template']['classname'] = '總表';
else $_E['template']['classname'] = "{$grade}年{$class}班";
$_E['template']['title'] = $goodslist['name'].'-'.$gooddata['name'].'-'.$_E['template']['classname'];
$data = array(array());

if( $class != 'all' )
{
    if( !makeint($grade) || !makeint($class) )
    {
        Render::errormessage('班別錯誤');
        Render::render('index','admin');
        exit(0);
    }
}

switch( $gooddata['tbmatch'] )
{
    case 0 :
        if( $class == 'all' )
        {
            $res = SQL::fetchAll("
SELECT `$tstudent_account`.`grade`,`$tstudent_account`.`class`, SUM(`$torderlist_detail`.`num`) AS `sum` FROM `$torderlist_detail` 
    INNER JOIN `$torderlist` ON `$torderlist_detail`.`odid` = `$torderlist`.`odid` 
    INNER JOIN `$tstudent_account` ON `$torderlist`.`suid` = `$tstudent_account`.`suid` 
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? 
GROUP BY `$tstudent_account`.`grade`,`$tstudent_account`.`class`
ORDER BY `grade` ASC",array($lid,$gid));
            if( $res === false ) break;
            $_E['template']['maintb']='good_summary.0.all';
            
        }
        else
        {
            $res = SQL::fetchAll("
SELECT `$tstudent_account`.`grade`,`$tstudent_account`.`class`,`$tstudent_account`.`number`,`$tstudent_account`.`username`,`$torderlist_detail`.`num`
FROM `$torderlist_detail`
	INNER JOIN `$torderlist` ON `$torderlist_detail`.`odid` = `$torderlist`.`odid`
	INNER JOIN `$tstudent_account` ON `$torderlist`.`suid` = `$tstudent_account`.`suid`
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? AND `$tstudent_account`.`grade` = ? AND `$tstudent_account`.`class` = ?
ORDER BY `student_account`.`number` ASC",array($lid,$gid,$grade,$class));
            if( $res === false ) break;
            $_E['template']['maintb']='good_summary.0.class';
        }
        $_E['template']['data'] = $res;
        break;
    case 6 :
        if( $class == 'all' )
        {
            $res = SQL::fetchAll("SELECT `num`,`lpants`,`waistline` FROM `$torderlist_detail` WHERE `lid`=? AND `gid`=?",array($lid,$gid));
        }
        else
        {
            $res = SQL::fetchAll(
"SELECT `$torderlist_detail`.`num`,`$torderlist_detail`.`waistline`,`$torderlist_detail`.`lpants`
FROM `$torderlist_detail` 
	INNER JOIN `$torderlist` ON `$torderlist`.`odid` = `$torderlist_detail`.`odid` 
    INNER JOIN `$tstudent_account` ON  `$torderlist`.`suid` = `$tstudent_account`.`suid`
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? AND `$tstudent_account`.`grade` = ? AND `$tstudent_account`.`class` = ?",array($lid,$gid,$grade,$class));
        }
        if( $res === false ) break;
        foreach( $res as $row )
        {
            @$data[ (int)$row['waistline'] ][ (int)$row['lpants'] ] += $row['num'];
        }
        $_E['template']['maintb']='good_summary.6';
        $_E['template']['data'] = $data;
    break;
    
    default :
        Render::errormessage('不支援的表格');
}

if( isset($optAsPDF) )
{
    Render::renderSingleTemplate('common_header_printable','common');
    Render::renderSingleTemplate($_E['template']['maintb'],'admin');
    Render::renderSingleTemplate('common_footer_printable');
}
else
{
    Render::render('good_summary','admin');
}

exit(0);