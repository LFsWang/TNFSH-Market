<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<?php 
    
    if( !isset( $tmpl['admin_panel_active'] ) )
        $tmpl['admin_panel_active'] = "";
    $tname = $tmpl['admin_panel_active'];
    
    function admin_panel_active($name,$tname)
    {
        if( $tname == $name )
            echo 'active';
    }

?>
<ul class="nav nav-pills nav-stacked">
    <li class="<?php admin_panel_active('overview',$tname)?>"><a href="admin.php">Overview</a></li>
    
    <li class="dropdown <?php admin_panel_active('goods',$tname)?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dLabel">商品資訊<span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="dLabel">
            <li><a href="admin.php?page=goodlists">購買清單</a></li>
            <li><a href="admin.php?page=goods">商品管理</a></li>
            <li><a href="admin.php?page=orderfind">查詢訂單</a></li>
        </ul>
    </li>
    
    <li class="dropdown <?php admin_panel_active('site',$tname)?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dLabe3">網站管理<span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="dLabe3">
            <li><a href="admin.php?page=edit_system_announcement">網站公告</a></li>
            <li><a href="admin.php?page=listadmin">管理員列表</a></li>
            <li><a href="admin.php?page=syslog">系統紀錄</a></li>
        </ul>
    </li>
    
    <li class="dropdown <?php admin_panel_active('student',$tname)?>">
        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dLabe4">學生管理<span class="caret"></span></a>
        <ul class="dropdown-menu" aria-labelledby="dLabe4">
            <li><a href="admin.php?page=saccount_groups">學生帳號群組</a></li>
            <?php if( $_G['root'] ): ?>
            <li><a href="admin.php?page=addastudent">新增單一學生帳號</a></li>
            <li><a href="admin.php?page=modifyastudent">修改單一學生帳號</a></li>
            <?php endif; ?>
        </ul>
    </li>
    <li class="dropdown <?php admin_panel_active('profile',$tname)?>"><a href="admin.php?page=admininfo&uid=<?=$_G['uid']?>">個人資料</a></li>
    
    <!--
    <li><a href="#">網站管理</a></li>
    <li><a href="#">Menu 3</a></li>
    -->
</ul>