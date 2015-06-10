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
    //console.log(v);
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
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br><small>開放時間 <?=$tmpl['listinfo']['starttime']?> ~ <?=$tmpl['listinfo']['endtime']?></small></h3>
                <form>
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
                            <?php foreach($tmpl['goodinfo'] as $row ) { ?>
                                <?php $totalsum += $row['price']*$row['defaultnum']; ?>
                                <tr>
                                    <td> <?=$row['gid']?> </td>
                                    <td> <a href = "index.php?page=viewgood&gid="<?=$row['gid']?> target="_blank"><?=$row['name']?></a></td>
                                    <td> <?=$row['price']?> </td>
                                    <td>
                                        <input type="number" class="form-control" id="gid-<?=$row['gid']?>" placeholder="數量" value="<?=$row['defaultnum']?>" name="gid-<?=$row['gid']?>" min="0" max="$row['maxnum']" onchange="updatemoney(<?=$row['gid']?>,<?=$row['price']?>)">
                                    </td>
                                    <td> <span id="m-<?=$row['gid']?>"><?=$row['total']?></span></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class = "row text-right">
                        <div class = "col-sm-offset-4 col-sm-6">
                            <h4 style="color:red">總價格：<span id='totalmoney'><?=$totalsum?></span>元整</h4>
                        </div>
                        <div class = "col-sm-2">
                            <button type="button" class="btn btn-success">訂購</button>
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