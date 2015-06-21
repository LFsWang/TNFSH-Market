<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>

<script>
$( document ).ready(function() {
    
});
function callprintpage()
{
    window.open(location.href + '&pdf');
}
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'goods'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <nav class="navbar navbar-default">
                <div class="container-fluid">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#classbar" aria-expanded="false">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="classbar">
                        <ul class="nav navbar-nav">
                        </ul>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">班級分類<span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <?php foreach($tmpl['classlist'] as $row){ ?>
                                        <li><a href="admin.php?page=good_summary&lid=<?=$tmpl['goodslist']['lid']?>&gid=<?=$tmpl['good']['gid']?>&grade=<?=$row[0]?>&class=<?=$row[1]?>"><?=$row[0]?>年<?=$row[1]?>班(<?=$row[2]?>)</a></li>
                                    <?php }?>
                                    <li role="separator" class="divider"></li>
                                    <li><a href="admin.php?page=good_summary&lid=<?=$tmpl['goodslist']['lid']?>&gid=<?=$tmpl['good']['gid']?>&class=all">總表</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                </div><!-- /.container-fluid -->
            </nav>
            <center>
                <h2>統計列表<small><a onclick="callprintpage()">列印</a></small></h2>
            </center>
            <?php Render::renderSingleTemplate($_E['template']['maintb'],'admin'); ?>
        </div>
    </div>
</div>