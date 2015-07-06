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
        <?php foreach( $tmpl['studentnumber'] as $row ){ ?>
        <tr>
            <td><?=$tmpl['grade']?></td>
            <td><?=$tmpl['class']?></td>
            <td><?=$row[1]?></td>
            <td><?=$row[2]?></td>
            <?php foreach( $tmpl['allgoods'] as $goods ){?>
            <?php $snum = $row[0]; ?>
            <td class="text-center col-sm-1 text-left"><?=@$tmpl['data'][(int)$goods['gid']][$snum][0]?></td>
            <td class="text-center col-sm-1 text-left"><?=@($tmpl['data'][(int)$goods['gid']][$snum][1]+24)/4?></td>
            <?php }?>
            <td></td>
        </tr>
        <?php }?>
    </tbody>
</table>