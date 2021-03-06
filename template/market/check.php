<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
function check()
{
    if (confirm('確認送出訂單? 送出後超過訂購時限將無法再進行修改，請詳加確認。')) {
        return true;
    } else {
        return false;
    }
};
</script>

<div class="container-fluid">
    <div class="row">
        <?php $tmpl['admin_panel_active'] = 'overview'; ?>
        <?php Render::renderSingleTemplate('panel','market'); ?>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3>確認訂單</h3>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br></h3>
                <form method="post" action="market.php?page=buy" id="checkbuyform" onsubmit="return check()">
                    <input type='hidden' name='token' value='<?=$tmpl['token']?>'>
                    <input type='hidden' name='lid' value='<?=$tmpl['listinfo']['lid']?>'>
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
                                <?php $totalsum += ($tmp= $row['price']*$tmpl['userin']['gid'][$row['gid']]); ?>
                                <tr>
                                    <td> <?=$row['gid']?> </td>
                                    <td> <a href = "index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                                    <td> <?=$row['price']?> </td>
                                    <td> <?=$tmpl['userin']['gid'][$row['gid']]?></td>
                                    <td><?=$tmp?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class = "container-fluid">
                        <?php if($tmpl['clothe']): ?>
                        <div class = "row text-left">
                            <h4>套量尺寸(英寸)<small>請依據廠商套量結果填寫</small></h4>
                            <div class ="col-sm-1">胸圍：</div>
                            <div class ="col-sm-2"><?=$tmpl['userin']['bust']?></div>
                            <div class ="col-sm-1">腰圍：</div>
                            <div class ="col-sm-2"><?=$tmpl['userin']['waistline']?></div>
                            <div class ="col-sm-1">褲長：</div>
                            <div class ="col-sm-2"><?=$tmpl['userin']['lpants']?></div>
                        </div>
                            <?php foreach($tmpl['userin']['sz'] as $row ) { ?>
                            <?php if($row[4] == 0) continue; ?>
                        <div class = "row text-left">
                            <h4><?=$row[3]?> <small>自訂尺寸</small></h4>
                            <?php if($row[4]&1): ?>
                            <div class ="col-sm-1">胸圍：</div>
                            <div class ="col-sm-2"><?=$row[0]?></div>
                            <?php endif;?>
                            <?php if($row[4]&2): ?>
                            <div class ="col-sm-1">腰圍：</div>
                            <div class ="col-sm-2"><?=$row[1]?></div>
                            <?php endif;?>
                            <?php if($row[4]&4): ?>
                            <div class ="col-sm-1">褲長：</div>
                            <div class ="col-sm-2"><?=$row[2]?></div>
                            <?php endif;?>
                        </div>
                        <hr>
                            <?php } ?>
                        <?php endif; ?>
                        <div class = "row text-right">
                            <div class = "col-sm-offset-5 col-sm-3">
                                <h4 style="color:red">總價格：<span id='totalmoney'><?=$totalsum?></span>元整</h4>
                            </div>
                            <div class = "col-sm-2">
                                <button class="btn btn-success" type="submit">送出訂單</button>
                            </div>
                            <div class = "col-sm-2">
                                <button class="btn btn-warning" onclick="location.href='market.php?id=<?=$tmpl['listinfo']['lid']?>';return false;">重新選擇</button>
                            </div>
                        </div>
                    </div>
                </form>
            </center>
            <div class="well well-lg">
                <?=$tmpl['listinfo']['description']?>
            </div>
        </div>
    </div>
</div>