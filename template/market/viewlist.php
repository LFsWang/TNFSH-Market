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
$( document ).ready(function() {
    $("[gid]").prop('checked', false )
    $("[gid]").change(function(){
        console.log( $(this).attr('gid') );
        gid = $(this).attr('gid');
        tbmatch = $(this).attr('tbmatch');
        if( $(this).is(':checked') )
        {
            gname = $("#szbar"+gid).attr('gname');
            $("#szbar"+gid).html(genclothesizeinputrowstring(gname,'自定義尺寸',gid));
            if(!( tbmatch & 1 )) $("#bust"+gid).hide();
            if(!( tbmatch & 2 )) $("#waistline"+gid).hide();
            if(!( tbmatch & 4 )) $("#lpants"+gid).hide();
        }
        else
        {
            $("#szbar"+gid).html('');
        }
    });
});
</script>
<div class="container-fluid">
    <div class="row">
        <?php $tmpl['admin_panel_active'] = 'overview'; ?>
        <?php Render::renderSingleTemplate('panel','market'); ?>
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
                                <th class="col-sm-4">商品名稱</th>
                                <th class="col-sm-2">單價</th>
                                <th class="col-sm-2">購買數量</th>
                                <th class="col-sm-1">總價</th>
                                <th class="col-sm-2">特別尺寸</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $totalsum = 0; ?>
                            <?php $genlist = array(); ?>
                            <?php foreach($tmpl['goodsinfo'] as $row ) { ?>
                                <?php $totalsum += $row['price']*$row['defaultnum']; ?>
                                <tr>
                                    <td> <?=$row['gid']?> </td>
                                    <td> <a href = "index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                                    <td> <?=$row['price']?> </td>
                                    <td>
                                        <select name="gid-<?=$row['gid']?>" class="form-control" id="gid-<?=$row['gid']?>" onchange="updatemoney(<?=$row['gid']?>,<?=$row['price']?>)">
                                        <?php for($i=0;$i<=$row['maxnum'];++$i){ ?>
                                        <?php if( $i == $row['defaultnum'] ): ?>
                                        <option value="<?=$i?>" selected="selected"><?=$i?></option>
                                        <?php else: ?>
                                        <option value="<?=$i?>"><?=$i?></option>
                                        <?php endif;?>
                                        <?php } ?>
                                        </select>
                                    </td>
                                    <td> <span id="m-<?=$row['gid']?>"><?=$row['total']?></span></td>
                                    <td>
                                        <?php if( $row['type'] == 'clothe' ): ?>
                                        <div class="checkbox">
                                            <label>
                                                <input type="checkbox" gid="<?=$row['gid']?>" tbmatch="<?=$row['tbmatch']?>">
                                            </label>
                                        </div>
                                        <?php $genlist[]=array($row['gid'],$row['name']) ?>
                                        <?php endif;?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    <div class = "container-fluid">
                        <?php if( $tmpl['listinfo']['needclothe'] ): ?>
                        <div id="mainszbar"></div>
                        <script>
                            $("#mainszbar").html(genclothesizeinputrowstring('套量尺寸(英吋)','請依據廠商套量結果填寫',''));
                        </script>
                            <?php foreach($genlist as $row) { ?>
                                <div id="szbar<?=$row[0]?>" gname="<?=$row[1]?>"></div>
                            <?php }?>
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