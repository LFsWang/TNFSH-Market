<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}

class SQL{
    static $pdo = null;
        
    static function getpdo(){
        global $_DB;
        $pdo = null;
        try {
            $pdo = new PDO($_DB['query_string'], $_DB['dbaccount'] , $_DB['dbpassword'] );
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $pdo;
    }
    
    static function intro()
    {
        global $pdo;
        global $_DB;
        self::$pdo = SQL::getpdo();
    }
    
    static function prepare($string)
    {
        try {
            $res = self::$pdo->prepare($string);
        } catch (PDOException $e) {
            echo "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
        return $res;
    }
    static function tname($table)
    {
        global $_DB;
        return $_DB['prename'].$table;
    }
}