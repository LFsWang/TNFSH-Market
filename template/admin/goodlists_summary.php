<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>

<script>
$( document ).ready(function() {
    
});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'goods'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>統計列表</h2>
            </center>
            <table class="table table-striped table-hover">
                <tbody>
                    <tr>
                        <td class="col-sm-4"><h4><?=$tmpl['goodlist']['name']?></h4></td>
                        <td class="col-sm-8"><?=$tmpl['goodlist']['starttime']?>~<?=$tmpl['goodlist']['endtime']?></td>
                    </tr>
                    <tr>
                        <td>應購買人數: <?=$tmpl['goodlist']['totaluser']?></td>
                        <td>已下單人數: <?=$tmpl['totalbuyuser']?></td>
                    </tr>
                </tbody>
            </table>
            <p>
                <a href="admin.php?page=exportorder&lid=<?=$tmpl['goodlist']['lid']?>" class="btn btn-default" target="_blank">匯出CSV</a>
            </p>
            <hr>
            <h3>一般商品大綱</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>商品名稱</th>
                        <th>單價</th>
                        <th>購買人數</th>
                        <th>購買數量</th>
                        <th>銷售額</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $tmpl['goods'] as $row ){ ?>
                        <?php if( $row['type'] != 'normal') continue; ?>
                    <tr>
                        <td><a href="index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                        <td><?=$row['price']?></td>
                        <td><?=$tmpl['totalguser'][$row['gid']]?></td>
                        <td><?=$tmpl['totalgnum'][$row['gid']]?></td>
                        <td><?=$tmpl['totalgnum'][$row['gid']]*$row['price']?></td>
                        <td>
                            <a class="icon-bttn" href="admin.php?page=good_summary&lid=<?=$tmpl['goodlist']['lid']?>&gid=<?=$row['gid']?>&class=all">
                                <span class="glyphicon glyphicon-th-list" title="總表"></span>
                            </a>
                            <a class="icon-bttn" href="admin.php?page=good_summary&lid=<?=$tmpl['goodlist']['lid']?>&gid=<?=$row['gid']?>&class=all&pdf">
                                <span class="glyphicon glyphicon-print" title="列印"></span>
                            </a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
            <hr>
            <h3>衣物類大綱</h3>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>商品名稱</th>
                        <th>單價</th>
                        <th>購買人數</th>
                        <th>購買數量</th>
                        <th>銷售額</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach( $tmpl['goods'] as $row ){ ?>
                        <?php if( $row['type'] != 'clothe') continue; ?>
                        <?php $clotheflag = true; ?>
                    <tr>
                        <td><a href="index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                        <td><?=$row['price']?></td>
                        <td><?=$tmpl['totalguser'][$row['gid']]?> </td>
                        <td><?=$tmpl['totalgnum'][$row['gid']]?></td>
                        <td><?=$tmpl['totalgnum'][$row['gid']]*$row['price']?></td>
                        <td>
                            <a class="icon-bttn" href="admin.php?page=good_summary&lid=<?=$tmpl['goodlist']['lid']?>&gid=<?=$row['gid']?>&class=all">
                                <span class="glyphicon glyphicon-th-list" title="總表"></span>
                            </a>
                            <a class="icon-bttn" href="admin.php?page=good_summary&lid=<?=$tmpl['goodlist']['lid']?>&gid=<?=$row['gid']?>&class=all&pdf">
                                <span class="glyphicon glyphicon-print" title="列印"></span>
                            </a>
                        </td>
                    </tr>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>