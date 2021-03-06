<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<div class="container-fluid">
    <div class="row">
        <?php $tmpl['admin_panel_active'] = 'overview'; ?>
        <?php Render::renderSingleTemplate('panel','market'); ?>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br><small>開放時間 <?=$tmpl['listinfo']['starttime']?> ~ <?=$tmpl['listinfo']['endtime']?></small></h3>
                <h4>已結束訂購</h4>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col-sm-1">代號</th>
                            <th class="col-sm-5">商品名稱</th>
                            <th class="col-sm-2">單價</th>
                            <th class="col-sm-2">購買數量</th>
                            <th class="col-sm-2">總價</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalsum = 0; ?>
                        <?php foreach($tmpl['goodsinfo'] as $row ) { ?>
                            <?php $totalsum += $row['price']*$row['defaultnum']; ?>
                            <tr>
                                <td> <?=$row['gid']?> </td>
                                <td> <a href = "index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                                <td> <?=$row['price']?> </td>
                                <td> </td>
                                <td> <span id="m-<?=$row['gid']?>"></span></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </center>
            <div class="well well-lg">
                <?=$tmpl['listinfo']['description']?>
            </div>
        </div>
    </div>
</div>