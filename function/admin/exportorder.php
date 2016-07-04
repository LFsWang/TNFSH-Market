<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
require_once($_E['ROOT'].'/function/user/user.lib.php');
$tstudent_account = SQL::tname('student_account');
$tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
$torderlist_detail = SQL::tname('orderlist_detail');
$torderlist = SQL::tname('orderlist');
$output = "\xEF\xBB\xBF";

$lid = safe_get('lid');
if( !makeint($lid) )
{
    Render::errormessage('ERROR LID');
    Render::render('index','admin');
    exit(0);
}
$data = GetGoodlistByLID($lid);

if( !$data )
{
    Render::errormessage('GET DATA ERROR');
    Render::render('index','admin');
    exit(0);
}

#人數
$data['totaluser'] = 0;
$cusers = SQL::fetch("SELECT COUNT(`suid`) FROM `$tstudent_account` WHERE `gpid` IN (SELECT `gpid` FROM `$tgoodlist_accountgroup` WHERE `lid` = ?)",array($lid));
if( $cusers )
{
    $data['totaluser'] = (int)$cusers[0];
}

$goods = array();
$goodsorder = array();
$totalgnum = array();
$totalguser = array();
$firstline = '帳號,姓名,年級,班級,座號';
foreach( $data['goods'] as $gid )
{
    $goods[$gid] = GetGoodByGID($gid);
    $goodsorder [] = $gid;
    $totalgnum[$gid] = 0;
    $totalguser[$gid] = 0;
    if( $goods[$gid]['type'] == 'clothe' )
    {
        $firstline .= ','.$goods[$gid]['name'].'尺寸,數量,價格';
        //need a mask
        $goods[$gid]['sz'] = array();
    }
    else
    {
        $firstline .= ','.$goods[$gid]['name'].',價格';
    }
}
$output.= $firstline.',總價';


#取得所有細節加以統計
$orderlist_detail = SQL::fetchAll("
SELECT * FROM `$torderlist_detail`
    INNER JOIN `$torderlist` ON `$torderlist_detail`.`odid` = `$torderlist`.`odid` 
    INNER JOIN `$tstudent_account` ON `$torderlist`.`suid`  = `$tstudent_account`.`suid` 
WHERE `$torderlist_detail`.`lid` = ?
ORDER BY `$tstudent_account`.`grade`,`$tstudent_account`.`class`,`$tstudent_account`.`number`
",array($lid));

//var_dump($orderlist_detail);
if( !$orderlist_detail ) $orderlist_detail = array();

$data = array();
$user = array();
#suid => array( gid=>( num , size , money ) )
foreach($orderlist_detail as $row)
{
    if( !isset( $data[ $row['suid'] ] ) )
        $data[ $row['suid'] ] = array();
    if( !isset( $user[ $row['suid'] ] ) )
    {
        $user[$row['suid']] = array(
            str_replace(NEWBIE_PRE,'',$row['username']),$row['name'],$row['grade'],$row['class'],$row['number']
        );
    }
    $sz = array();
    if( $goods[$row['gid']]['tbmatch'] & 1 ) $sz[]=$row['bust'];
    if( $goods[$row['gid']]['tbmatch'] & 2 ) $sz[]=$row['waistline'];
    if( $goods[$row['gid']]['tbmatch'] & 4 ) $sz[]=$row['lpants'];
    $sz = implode('-',$sz);
    $data[ $row['suid'] ][ $row['gid'] ] = array( $row['num'] , $sz , $row['num']*$goods[$row['gid']]['price']);
}

//total user
foreach( $data as $uid=>$d )
{
    $line = implode(',',$user[$uid]);
    $sum = 0;
    foreach( $goodsorder as $gid )
    {
        if( !isset( $d[$gid] ) )
            $d[$gid] = array('0','','0');
        if( $goods[$gid]['type'] == 'clothe' )
            $line .= ','.$d[$gid][1].','.$d[$gid][0].','.$d[$gid][2];
        else
            $line .= ','.$d[$gid][0].','.$d[$gid][2];
        $sum += $d[$gid][2];
    }
    $output.="\n".$line.','.$sum;
}
header("Content-type: text/x-csv");
header("Content-Disposition:filename=export.csv");
echo $output;
exit(0);