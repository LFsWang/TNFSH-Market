<?php
if(!defined('IN_SYSTEM'))
{
    exit('Access denied');
}
//Common Error Code
function __df($X){
    if( !defined ($X) )
        define($X,$X);
}
__df('ERROR_NO');
__df('ERROR_DATA_MISSING');

__df('ERROR_TIME_FORMAT');
__df('ERROR_ARRAY_FORMAT');
__df('ERROR_INT_FORMAT');
__df('ERROR_STRING_FORMAT');
__df('ERROR_SAME_INDEX');
__df('ERROR_SQL_EXEC');

__df('ERROR_PREMISSION_DENIED');
__df('ERROR_OTHERS');

function makeint($var)
{
    if( !is_numeric($var) )
            return false;
    $var = (int) $var;
    return true;
}

function getsysvalue($id)
{
    $table = SQL::tname('system');
    $pdo = SQL::getpdo();
    $sql_select = "SELECT `value` FROM $table WHERE `id` = ?";
    
    $res = SQL::prepare($sql_select);
    $res->execute( array($id) );
    
    $row = $res->fetch();

    if(!$row)return false;
    return $row['value'];
}

function updatesysvalue($id,$value)
{
    $table = SQL::tname('system');
    $sql_update = "INSERT INTO $table (`id`, `value`) VALUES (?,?) ON DUPLICATE KEY UPDATE `value` = ?";
    //$sql_update = "UPDATE $table SET `value` = ? WHERE `id` = ?";
    
    $res = SQL::prepare($sql_update);
    SQL::execute( $res , array($id,$value,$value) );
    return $value;
}

function httpRequest( $url , $post = null , $usepost =true , $usessl = false )
{
    if( is_array($post) )
    {
        ksort( $post );
        //echo http_build_query( $post );
        $post = http_build_query( $post );
        
    }
    
    $ch = curl_init();
    curl_setopt( $ch , CURLOPT_URL , $url );
    curl_setopt( $ch , CURLOPT_ENCODING, "UTF-8" );
    if($usepost)
    {
        curl_setopt( $ch , CURLOPT_POST, true );
        curl_setopt( $ch , CURLOPT_POSTFIELDS , $post );
    }
    if($usessl)
    {
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,0);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,0);
    }
    curl_setopt( $ch , CURLOPT_RETURNTRANSFER , true );
    
    $data = curl_exec($ch);
    curl_close($ch);
    if(!$data)
    {
        return false;
    }
    return $data;
}

function throwjson($status,$data)
{
    exit( json_encode( array( 'status' => $status , 'data' => $data ) ) );
}

function safe_post($name,$default = false)
{
    if( isset( $_POST[$name] ) )
        return $_POST[$name];
    return $default;
}

function safe_get($name,$default = false)
{
    if( isset( $_GET[$name] ) )
        return $_GET[$name];
    return $default;
}

function checkdateformat($datestr)
{
    if(preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/",$datestr))
    {
        return true;
    }else{
        return false;
    }
}

#return array of gid
# -1 : error
function upload_image($files)
{
    global $_E,$_G;
    if(!isset($files['name'])){
        return array();
    }
    $sz = count($files['name']);
    
    //$allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_BMP);
    $allowedTypes = array(  IMAGETYPE_PNG  => ".png", 
                            IMAGETYPE_JPEG => ".jpg",
                            IMAGETYPE_BMP  => ".bmp");
    
    $savedir = $_E['ROOT'].'/image/';
    $gidlist = array();
    for( $i=0 ; $i<$sz ; ++$i )
    {
        $name = $files["name"][$i];
        $type = $files["type"][$i];
        $tmp  = $files["tmp_name"][$i];
        $error= $files["error"][$i];
        if( $error !==0 )
        {
            $gidlist[] = -1;
            continue;
        }
        
        $detectedType = exif_imagetype($tmp);
        if( !isset($allowedTypes[$detectedType]) )
        {
            $gidlist[] = -1;
            continue;
        }
        
        $hash_name = md5( uniqid( $tmp , true ) ) . $allowedTypes[$detectedType];
        move_uploaded_file($tmp,$savedir.$hash_name);
        $table = SQL::tname('image');
        $sql_insert = "INSERT INTO `$table`(`imgid`, `owner`, `timestamp`,`realname`, `hashname`,`title`,`description`) VALUES (NULL,?,NULL,?,?,'',?)";
        $res = SQL::prepare($sql_insert);
        if( !SQL::execute($res,array($_G['uid'],$name,$hash_name,$name)) )
        {
            Render::errormessage($hash_name." insert error!",'image');
            $gidlist[] = -1;
        }
        else
        {
            $id = SQL::lastInsertId();
            $gidlist[] = (int)$id;
        }    
    }
    return $gidlist;
}

function GetImageNameById($id,&$info = null)
{
    $table = SQL::tname('image');
    $sql_select = "SELECT * FROM `$table` WHERE `imgid` = ?";
    $res = SQL::prepare($sql_select);
    if( !is_numeric($id) )
    {
        return false;
    }
    if( SQL::execute($res,array((int)$id)) )
    {
        $res = $res->fetch();
        if( isset($res['hashname']) )
        {
            if( isset($info) )
            {
                $info = $res;
            }
            return $res['hashname'];
        }
    }
    return false;
}

#GetTimeFlag
define('TF_NOTYET',1);
define('TF_NOW',2);
define('TF_PASS',3);
function GetTimeFlag($timestart,$timeend)
{
    $date1 = new DateTime($timestart);
    $date2 = new DateTime($timeend);
    $date2->add(new DateInterval('P1D'));
    $datenow=new DateTime('NOW');
    if( $date1 > $date2 ) return false;
    if( $datenow < $date1 ) return TF_NOTYET;
    if( $date2 < $datenow ) return TF_PASS;
    return TF_NOW;
}

function GetGoodlistByLID($lid)
{
    $tgoods = SQL::tname('goods');
    $tgoodlist = SQL::tname('goodlist');
    $tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
    $tgoodlist_accountgroup = SQL::tname('goodlist_accountgroup');
    $data = SQL::fetch("SELECT * FROM $tgoodlist WHERE `lid` = ?",array($lid));
    if( !$data )return false;
    if( !$data['lid'] ) return false;
    
    $data['goods'] = array();
    $data['needclothe'] = false;
    $tmp = SQL::fetchAll("SELECT `$tgoods`.`gid`,`type` FROM `$tgoodlist_goodstable` 
    INNER JOIN `$tgoods` ON `$tgoods`.`gid` = `$tgoodlist_goodstable`.`gid` 
    WHERE `lid` = ?",array($lid));
    foreach( $tmp as $row )
    {
        $data['goods'][] = $row['gid'];
        if( $row['type'] == 'clothe' )
        {
            $data['needclothe'] = true;
        }
    }
    $tmp = SQL::fetchAll("SELECT `gpid` FROM $tgoodlist_accountgroup WHERE `lid` = ?",array($lid));
    foreach( $tmp as $row )
    {
        $data['accountgroups'][] = $row['gpid'];
    }
    return $data;
}

function GetGoodlistDetail($lid)
{
    $tgoods = SQL::tname('goods');
    $tgoodlist_goodstable = SQL::tname('goodlist_goodstable');
    if(!( $data = GetGoodlistByLID($lid) ))
    {
        return false;
    }
    $sql_select = "SELECT *,`defaultnum` * `price` AS `total` FROM `$tgoods` WHERE `gid` IN (SELECT `gid` FROM `$tgoodlist_goodstable` WHERE `lid` = ?)";
    if( $res = SQL::query($sql_select,array($lid)) )
    {
        $data['goodsinfo'] = array();
        while( $row = $res->fetch() )
        {
            $data['goodsinfo'][ $row['gid'] ] = $row;
        }
    }
    else
    {
        return false;
    }
    return $data;
}

function GetGoodByGID($gid)
{
    $tgoods = SQL::tname('goods');
    $tgoods_image = SQL::tname('goods_image');
    $data = SQL::fetch("SELECT * FROM $tgoods WHERE `gid` = ?",array($gid));
    if( !$data )return false;
    if( !$data['gid'] ) return false;
    
    $data['image'] = array();
    $tmp = SQL::fetchAll("SELECT `imgid` FROM $tgoods_image WHERE `gid` = ?",array($gid));
    foreach( $tmp as $row )
    {
        $data['image'][] = $row['imgid'];
    }
    return $data;
}

function CheckArrayAllNumber(&$array)
{
    if( !is_array($array) )return false;
    foreach( $array as $var )
    {
        if( !is_numeric($var) )
        {
            return false;
        }
        $var = (int) $var;
        if( $var <= 0 )
        {
            return false;
        }
    }
    return true;
}

function checkclothesize(&$bust,&$waistline,&$lpants)
{
    //bust 34 ~ 60 % 2 = 0 
    //waistline 27 ~ 46
    //lpants 38 ~ 46 % 2 = 0 
    if( !makeint($bust) || !makeint($waistline) || !makeint($lpants) )
    {
        return false;
    }

    if( $bust < 34 || 60 < $bust || $bust % 2 != 0 
      ||$waistline < 27 || 46 < $waistline
      ||$lpants < 38 || 46 < $lpants || $lpants % 2 != 0 )
    {
        return false;
    }
    return true;
}

function GetGoodSumOnListByClassGroup($lid,$gid)
{
    $tstudent_account = SQL::tname('student_account');
    $torderlist_detail = SQL::tname('orderlist_detail');
    $torderlist = SQL::tname('orderlist');
    return SQL::fetchAll("
SELECT `$tstudent_account`.`grade`,`$tstudent_account`.`class`, SUM(`$torderlist_detail`.`num`) AS `sum` FROM `$torderlist_detail` 
    INNER JOIN `$torderlist` ON `$torderlist_detail`.`odid` = `$torderlist`.`odid` 
    INNER JOIN `$tstudent_account` ON `$torderlist`.`suid` = `$tstudent_account`.`suid` 
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? 
GROUP BY `$tstudent_account`.`grade`,`$tstudent_account`.`class`
ORDER BY `grade` ASC",array($lid,$gid));
}

function GetGoodNumOnListByClassStudent($lid,$gid,$grade,$class)
{
    $tstudent_account = SQL::tname('student_account');
    $torderlist_detail = SQL::tname('orderlist_detail');
    $torderlist = SQL::tname('orderlist');
    return SQL::fetchAll("
SELECT `$tstudent_account`.`grade`,`$tstudent_account`.`class`,`$tstudent_account`.`number`,`$tstudent_account`.`username`,`$torderlist_detail`.`num`
FROM `$torderlist_detail`
	INNER JOIN `$torderlist` ON `$torderlist_detail`.`odid` = `$torderlist`.`odid`
	INNER JOIN `$tstudent_account` ON `$torderlist`.`suid` = `$tstudent_account`.`suid`
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? AND `$tstudent_account`.`grade` = ? AND `$tstudent_account`.`class` = ?
ORDER BY `student_account`.`number` ASC",array($lid,$gid,$grade,$class));
}

function GetGoodNumWithSize($lid,$gid)
{
    $torderlist_detail = SQL::tname('orderlist_detail');
    return SQL::fetchAll("SELECT `num`,`bust`,`waistline`,`lpants` FROM `$torderlist_detail` WHERE `lid`=? AND `gid`=?",array($lid,$gid));
}

function GetGoodNumWithSizeByClassStudent($lid,$gid,$grade,$class)
{
    $tstudent_account = SQL::tname('student_account');
    $torderlist_detail = SQL::tname('orderlist_detail');
    $torderlist = SQL::tname('orderlist');
    return SQL::fetchAll(
"SELECT `$tstudent_account`.`grade`,`$tstudent_account`.`class`,`$tstudent_account`.`number`,`$tstudent_account`.`username`,`$torderlist_detail`.`num`,`$torderlist_detail`.`bust`,`$torderlist_detail`.`waistline`,`$torderlist_detail`.`lpants`
FROM `$torderlist_detail` 
	INNER JOIN `$torderlist` ON `$torderlist`.`odid` = `$torderlist_detail`.`odid` 
    INNER JOIN `$tstudent_account` ON  `$torderlist`.`suid` = `$tstudent_account`.`suid`
WHERE `$torderlist`.`lid` = ? AND `$torderlist_detail`.`gid` = ? AND `$tstudent_account`.`grade` = ? AND `$tstudent_account`.`class` = ?",array($lid,$gid,$grade,$class));
}
