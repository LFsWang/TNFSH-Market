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
$addin = safe_get('addin',array());
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
FROM `$tstudent_account` WHERE `gpid` IN (SELECT `gpid` FROM `$tgoodlist_accountgroup` WHERE `lid` = ?)
GROUP BY `grade`, `class`
ORDER BY `grade` ASC",array($lid));

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
            $res = GetGoodSumOnListByClassGroup($lid,$gid);
            if( $res === false ) break;
            $_E['template']['maintb']='good_summary.0.all';
            
        }
        else
        {
            $res = GetGoodNumOnListByClassStudent($lid,$gid,$grade,$class);
            if( $res === false ) break;
            $_E['template']['maintb']='good_summary.0.class';
        }
        $_E['template']['data'] = $res;
        break;
    case 1 ://bust
        //need support muilt list
        //put in $addin
        $allgoods = array(GetGoodByGID($gid));
        if( is_array($addin) )
        {
            foreach( $addin as $g )
            {
                $r = GetGoodByGID($g);
                if( $r )$allgoods[] = $r;
            }
        }
        //Render::errormessage($allgoods);
        $data = array(array());
        // gid => array[size] => num
        if( $class == 'all' )
        {
            foreach( $allgoods as $g )
            {
                $_gid = (int)$g['gid'];
                $data[ $_gid ] = array();
                $res = GetGoodNumWithSize($lid,$_gid);
                if( $res === false )continue;
                foreach( $res as $row )
                {
                    @$data[ $_gid ][ (int)$row['bust'] ] += $row['num'];
                }
            }
            $_E['template']['data'] = $data;
            $_E['template']['allgoods'] = $allgoods;
            $_E['template']['maintb']='good_summary.1.all';
        }
        else
        {
            $studentnumber = array();
            $data = array();
            //gid=>suid=>num
            foreach( $allgoods as $g )
            {
                $_gid = (int)$g['gid'];
                $data[ $_gid ] = array();
                $res = GetGoodNumWithSizeByClassStudent($lid,$_gid,$grade,$class);
                if( $res === false )continue;
                foreach( $res as $row )
                {
                    $studentnumber[] = array((int)$row['suid'],$row['number'],$row['name']);
                    $data[$_gid][(int)$row['suid']] = array($row['num'],$row['bust']);
                }
            }
            $_E['template']['data'] = $data;
            $_E['template']['allgoods'] = $allgoods;
            $_E['template']['grade']=$grade;
            $_E['template']['class']=$class;
            $_E['template']['studentnumber']=$studentnumber;
            $_E['template']['maintb']='good_summary.1.class';
        }
        break;
    case 6 :
        if( $class == 'all' )
        {
            $res = GetGoodNumWithSize($lid,$gid);
        }
        else
        {
            $res = GetGoodNumWithSizeByClassStudent($lid,$gid,$grade,$class);
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