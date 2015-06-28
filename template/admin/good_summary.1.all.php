<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<center><h2><?=htmlentities($tmpl['goodslist']['name']);?><br>
<small><?=htmlentities($tmpl['classname'])?></small>
</h2></center>
<table class="table table-striped table-hover table-bordered text-center">
    <thead>
        <tr>
            <th class="text-center col-sm-1">尺寸</th>
            <th class="text-center col-sm-1"></th>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
            <th class="text-center col-sm-2 text-left"><?=$goods['name']?></th>
            <?php }?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $s = array();?>
        <?php for($i=34;$i<=60;$i+=2){ ?>
        <tr>
            <td><?=$i?></td>
            <td><?=($i+24)/4?></td>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
                <td style="font-size:150%;padding:0 8px;"><?=@$tmpl['data'][(int)$goods['gid']][$i]?></td>
                <?php @$s[(int)$goods['gid']] += @$tmpl['data'][(int)$goods['gid']][$i];?>
            <?php }?>
            <td></td>
        </tr>
        <?php }?>
            
        
        <tr>
            <td></td>
            <td>Total:</td>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
                <td style="font-size:150%;padding:0 8px;"><?=@$s[(int)$goods['gid']]?></td>
            <?php }?>
            <td></td>
        </tr>
    </tbody>

</table>