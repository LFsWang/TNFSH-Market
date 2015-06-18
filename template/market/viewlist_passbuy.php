<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'overview'; ?>
            <?php Render::renderSingleTemplate('panel','market'); ?>
        </div>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br><small>購買時間<?=$tmpl['buy']['timestamp']?></small></h3>
                <h4>已完成訂購</h4>
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
                                <?php $totalsum += ($tmp = $row['price']*$tmpl['buyinfo'][$row['gid']]); ?>
                                <tr>
                                    <td> <?=$row['gid']?> </td>
                                    <td> <a href = "index.php?page=viewgood&gid="<?=$row['gid']?> target="_blank"><?=$row['name']?></a></td>
                                    <td> <?=$row['price']?> </td>
                                    <td> <?=$tmpl['buyinfo'][$row['gid']]?></td>
                                    <td> <?=$tmp?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <?php if($tmpl['listinfo']['needclothe']): ?>
                    <div class = "row text-left">
                        <h4>套量尺寸</h4>
                        <div class ="col-sm-1">胸圍(X10)：</div>
                        <div class ="col-sm-2"><?=$tmpl['buy']['bust']?></div>
                        <div class ="col-sm-1">腰圍：</div>
                        <div class ="col-sm-2"><?=$tmpl['buy']['waistline']?></div>
                        <div class ="col-sm-1">褲長：</div>
                        <div class ="col-sm-2"><?=$tmpl['buy']['lpants']?></div>
                    </div>
                    <?php endif; ?>
                    <div class = "row text-right">
                        
                        <div class = "col-sm-offset-6 col-sm-6">
                            <h4 style="color:red">應繳費用：<span id='totalmoney'><?=$totalsum?></span>元整</h4>
                        </div>
                    </div>
                    <div class = "row">
                        <div class = "col-sm-10 text-left">
                            交易內容驗證碼：<?=$tmpl['buy']['orderhash']?>
                        </div>
                        <div class = "col-sm-2 text-right">
                            <button class="btn btn-success">列印繳費單</button>
                        </div>
                    </div>
            </center>
            <div class="well well-lg">
                <?=$tmpl['listinfo']['description']?>
            </div>
        </div>
    </div>
</div>