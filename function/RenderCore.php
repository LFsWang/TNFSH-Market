<?php
if(!defined('IN_SYSTEM'))
{
  exit('Access denied');
}
define('IN_TEMPLATE',1);
function lang($str)
{
    return $str;
}
class Render
{
    private $head_css;
    private $head_js;
    
    function __construct()
    {
        $head_css = array();
        $head_js = array();
    }
    
    static function renderSingleTemplate( $pagename , $namespace = 'common' )
    {
        global $_E,$_G;
        if( !isset($_E['template']) )
        {
            $_E['template'] = array();
            $tmpl = array();
        }
        else
        {
            $tmpl = &$_E['template'];
        }
        $path = $_E['ROOT']."/template/$namespace/$pagename.php";
        if( file_exists($path) )
        {
            require($path);
            return true;
        }
        return false;
    }
    
    //work in progress
    static function renderStylesheetLink($namespace = 'common', $options = '') {
        global $_E,$_G;
        if(!isset($_E['template'])) { $_E['template'] = array(); }
        $path = $_E['ROOT']."/template/$namespace/theme";
        
        if( file_exists($path.'-'.$options.'.css'))
        {
            echo '<style>';
            echo file_get_contents($path.'-'.$options.'.css');
            echo '</style>';
        } else if (file_exists($path.'.css')){
            echo '<style>';
            echo file_get_contents($path.'.css');
            echo '</style>';
        }
        
        if (file_exists('css/index-'.$options.'.css')){
            echo '<link rel="stylesheet" type="text/css" href="css/index-'.$options.'.css">';
        }
        return true;
    }
    
    static function setbodyclass($val)
    {
        global $_E;
        if(!isset($_E['template']['_body_class']))
            $_E['template']['_body_class'] = array();
        $_E['template']['_body_class'][]=$val;
    }
    
    static function render($pagename , $namespace = 'common')
    {
        Render::renderSingleTemplate('common_header');
        //Render::renderStylesheetLink($namespace, 'light');
        Render::renderStylesheetLink($namespace);
        
        Render::renderSingleTemplate('common_nav');
        if(!Render::renderSingleTemplate($pagename,$namespace))
        {
            Render::renderSingleTemplate('nonedefined');
        }
        Render::renderSingleTemplate('common_footer');
    }
    
    static function ShowMessage($cont)
    {
        global $_E;
        $_E['template']['message'] = $cont;
        Render::render('common_message');
    }
    
    static function errormessage($text,$namespace = '')
    {
        global $_E;
        if( !is_string($text) )
        {
            ob_start();
            var_dump($text);
            $text = ob_get_clean();
        }
        $_E['template']['error'][]=array('msg'=>nl2br(htmlspecialchars($text)),'namespace'=>$namespace);
    }
    
    static function succmessage($text,$namespace = '')
    {
        global $_E;
        if( !is_string($text) )
        {
            ob_start();
            var_dump($text);
            $text = ob_get_clean();
        }
        $_E['template']['succ'][]=array('msg'=>nl2br(htmlspecialchars($text)),'namespace'=>$namespace);
    }
    
    static function static_html($pagename , $namespace = 'common') 
    {
        ob_start();
        Render::renderSingleTemplate($pagename , $namespace);
        $res = ob_get_clean();
        return $res;
    }
    static function htmlcachefile($name)
    {
        global $_E;
        return $_E['ROOT']."/data/cachehtml/$name.html";
    }
    static function save_html_cache($name,$res)
    {
        $handle = fopen( Render::htmlcachefile($name) ,'w');
        if(!$handle)
        {
            return false;
        }
        fwrite($handle,$res);
        fclose($handle);
        return true;
    }
    static function html_cache_exists($name)
    {
        return file_exists(Render::htmlcachefile($name));
    }
    static function rendercachehtml($name)
    {
        $fullname = Render::htmlcachefile($name);
        if( !file_exists($fullname) )
            return false;
        require($fullname);
    }
}
$_E['template']['error'] = array();
$_E['template']['succ'] = array();