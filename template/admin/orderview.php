<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
odid = <?=$tmpl['buy']['odid']?>;
$(document).ready(function(e){
    $('.goodnum').bind('click',function(event){
        console.log( $(this).attr('gid') );
        gid = $(this).attr('gid');
        if(event.ctrlKey){
            console.log('ctrl');
            val = prompt('請輸入新的數量',$(this).attr('defaultnum'));
            ival =  parseInt(val, 10);
            if ( !isNaN(ival) ) 
            {
                $.post("api.php",{action:'cg-num',odid:odid,gid:gid,num:val},function(res){
                    if( res.status == 'SUCC' ){
                        location.reload();
                    }
                    else{
                        alert(res.data);
                    }
                },"json").error(function(e){
                    console.log(e);
                });
            }
            else
            {
                alert('輸入錯誤!');
            }
        }
    });
});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'goods'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3><?=htmlentities($tmpl['listinfo']['name'])?><br><small>購買時間<?=$tmpl['buy']['timestamp']?></small></h3>
                <h4><?=@$tmpl['acct']['grade']?>年<?=@$tmpl['acct']['class']?>班<?=@$tmpl['acct']['number']?>號<?=@$tmpl['acct']['name']?> 已完成訂購</h4>
                <h5>CTRL+選取要修改的數字可以修改訂單</h5>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th class="col-sm-1">代號</th>
                            <th class="col-sm-3">商品名稱</th>
                            <th class="col-sm-2"><span title="胸圍/腰圍/褲長">尺寸</span></th>
                            <th class="col-sm-2">單價</th>
                            <th class="col-sm-2">購買數量</th>
                            <th class="col-sm-2">總價</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalsum = 0; ?>
                        <?php foreach($tmpl['goodsinfo'] as $row ) { ?>
                            <?php $totalsum += ($tmp = $row['price']*$tmpl['buyinfo'][$row['gid']]['num']); ?>
                            <tr>
                                <td> <?=$row['gid']?> </td>
                                <td> <a href = "index.php?page=viewgood&gid=<?=$row['gid']?>" target="_blank"><?=$row['name']?></a></td>
                                <td>
                                <?php if($row['type'] == 'clothe'): ?>
                                    <?php $lt=array('bust','waistline','lpants'); ?>
                                    <?php for($i=0;$i<3;++$i) { ?>
                                        <?php if(  $row['tbmatch'] & ( 1<<$i ) ): ?>
                                            <?=$tmpl['buyinfo'][$row['gid']][$lt[$i]]?>
                                        <?php else :?>
                                            -
                                        <?php endif;?>
                                        <?php if( $i<2 ) echo '/'; ?>
                                    <?php } ?>
                                <?php endif;?>
                                </td>
                                <td> <?=$row['price']?> </td>
                                <td><span class="goodnum" gid='<?=$row['gid']?>' defaultnum='<?=$tmpl['buyinfo'][$row['gid']]['num']?>'><?=$tmpl['buyinfo'][$row['gid']]['num']?></span></td>
                                <td> <?=$tmp?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                
                
                
                <div class = "row text-right">
                    
                    <div class = "col-sm-offset-6 col-sm-6">
                        <h4 style="color:red">應繳費用：<span id='totalmoney'><?=$totalsum?></span>元整</h4>
                    </div>
                </div>
                <div class = "row">
                    <div class = "col-sm-8 text-left">
                        交易內容驗證碼：<?=$tmpl['buy']['orderhash']?>
                    </div>
					<div class = "col-sm-2 text-right">
                    </div>
                    <div class = "col-sm-2 text-right">
                        <a class="btn btn-success" href='admin.php?page=orderview&odid=<?=$tmpl['buy']['odid']?>&pdf' target="_blank">列印本頁</a>
                    </div>
                </div>
            </center>
            <div class="well well-lg">
                <?=$tmpl['listinfo']['description']?>
            </div>
        </div>
    </div>
</div>