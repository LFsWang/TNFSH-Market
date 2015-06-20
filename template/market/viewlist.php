<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
function updatemoney(num,price)
{
    v = $("#gid-"+num).val();
    oldsum = $("#m-"+num).html();
    $("#m-"+num).html( v * price );
    oldtotal = $('#totalmoney').html();
    oldtotal = oldtotal - oldsum + v * price;
    $('#totalmoney').html(oldtotal);
}
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'overview'; ?>
            <?php Render::renderSingleTemplate('panel','market'); ?>
        </div>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br><small>開放時間 <?=$tmpl['listinfo']['starttime']?> ~ <?=$tmpl['listinfo']['endtime']?></small></h3>
                <form method="post" action="market.php?page=check&id=<?=$tmpl['listinfo']['lid']?>">
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
                                <?php $totalsum += $row['price']*$row['defaultnum']; ?>
                                <tr>
                                    <td> <?=$row['gid']?> </td>
                                    <td> <a href = "index.php?page=viewgood&gid="<?=$row['gid']?> target="_blank"><?=$row['name']?></a></td>
                                    <td> <?=$row['price']?> </td>
                                    <td>
                                        <input type="number" class="form-control" id="gid-<?=$row['gid']?>" placeholder="數量" value="<?=$row['defaultnum']?>" name="gid-<?=$row['gid']?>" min="0" max="<?=$row['maxnum']?>" onchange="updatemoney(<?=$row['gid']?>,<?=$row['price']?>)" required>
                                    </td>
                                    <td> <span id="m-<?=$row['gid']?>"><?=$row['total']?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class = "container-fluid">
                        <?php if( $tmpl['listinfo']['needclothe'] ): ?>
                        <div class = "row text-left">
                            <h4>套量尺寸(英吋)<small>請依據廠商套量結果填寫</small></h4>
                            <div class ="col-sm-1">胸圍：</div>
                            <div class ="col-sm-2">
                                <select name="bust" id="bust" class="form-control" required>
                                    <?php for($i=34;$i<=60;$i+=2){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class ="col-sm-1">腰圍：</div>
                            <div class ="col-sm-2">
                                <select name="waistline" id="waistline" class="form-control" required>
                                    <?php for($i=27;$i<=46;$i+=1){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?php }?>
                                </select>
                            </div>
                            <div class ="col-sm-1">褲長：</div>
                            <div class ="col-sm-2">
                                <select name="lpants" id="lpants" class="form-control" required>
                                    <?php for($i=38;$i<=46;$i+=2){?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                    <?php }?>
                                </select>
                            </div>
                        </div>
                        <?php endif; ?>
                        <div class = "row text-right">
                            <div class = "col-sm-offset-4 col-sm-6">
                                <h4 style="color:red">總價格：<span id='totalmoney'><?=$totalsum?></span>元整</h4>
                            </div>
                            <div class = "col-sm-2">
                                <button class="btn btn-success" type="submit">確認</button>
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