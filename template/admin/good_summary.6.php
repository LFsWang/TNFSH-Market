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
            <th>腰圍/褲長</th>
        <?php for($i=38;$i<=46;$i+=2){ ?>
            <th><?=$i?></th>
        <?php }?>
            <th>總計</th>
        </tr>
    </thead>
    <tbody>
        <?php $col = array(); ?>
        <?php for($i=27;$i<=48;$i+=1){ ?>
        <tr>
            <td><?=$i?></td>
            <?php $s = 0; ?>
            <?php for($j=38;$j<=46;$j+=2){ ?>
                <?php $s += @$tmpl['data'][$i][$j]; ?>
                <?php @$col[$j] += @$tmpl['data'][$i][$j]; ?>
                <td style="font-size:150%;padding:0;"><?= @$tmpl['data'][$i][$j]?></td>
            <?php }?>
            <td><?=$s?></td>
        </tr>
        <?php }?>
        <?php $s = 0 ?>
        <tr>
            <td>總計</td>
            <?php for($j=38;$j<=46;$j+=2){ ?>
                <td><?= @$col[$j]?></td>
                <?php @$s += $col[$j] ?>
            <?php }?>
            <td><?=$s?></td>
        <tr>
    </tbody>
</table>