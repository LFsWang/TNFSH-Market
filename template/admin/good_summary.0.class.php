<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<center><h2><?=htmlentities($tmpl['goodslist']['name']." - ".$tmpl['good']['name']);?><br>
<small><?=htmlentities($tmpl['classname'])?></small>
</h2></center>
<table class="table table-striped table-hover table-bordered text-center">
    <thead>
        <tr>
            <th class="text-center col-sm-1">年級</th>
            <th class="text-center col-sm-1">班別</th>
            <th class="text-center col-sm-1">座號</th>
            <th class="text-center col-sm-2">姓名</th>
            <th class="text-left"><?=htmlentities($tmpl['good']['name'])?> 數量</th>
        </tr>
    </thead>
    <tbody>
        <?php $s = 0;?>
        <?php foreach( $tmpl['data'] as $row ){ ?>
        <tr>
            <?php $s+=$row['num'] ?>
            <td><?=$row['grade']?></td>
            <td><?=$row['class']?></td>
            <td><?=$row['number']?></td>
            <td><?=htmlentities($row['username'])?></td>
            <td class="text-left" style="font-size:150%;padding:0 8px;"><?=$row['num']?></td>
        </tr>
        <?php }?>
        <tr>
            <td></td>
            <td></td>
            <td></td>
            <td>Total:</td>
            <td class="text-left" style="font-size:150%;padding:0 8px;"><?=$s?></td>
        </tr>
    </tbody>
</table>