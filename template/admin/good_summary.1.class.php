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
            <th class="text-center col-sm-1">年級</th>
            <th class="text-center col-sm-1">班別</th>
            <th class="text-center col-sm-1">座號</th>
            <th class="text-center col-sm-2">姓名</th>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
            <th class="text-center col-sm-1 text-left"><?=$goods['name']?></th>
            <th class="text-center col-sm-1 text-left">尺寸</th>
            <?php }?>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php $s = 0;?>
        <?php foreach( $tmpl['studentnumber'] as $snum => $name ){ ?>
        <tr>
            <td><?=$tmpl['grade']?></td>
            <td><?=$tmpl['class']?></td>
            <td><?=$snum?></td>
            <td><?=$name?></td>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
            <td class="text-center col-sm-1 text-left"><?=@$tmpl['data'][(int)$goods['gid']][$snum][0]?></td>
            <td class="text-center col-sm-1 text-left"><?=@$tmpl['data'][(int)$goods['gid']][$snum][1]?></td>
            <?php }?>
            <td></td>
        </tr>
        <?php }?>
    </tbody>
</table>