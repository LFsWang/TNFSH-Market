<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<?php 
    
    if( !isset( $tmpl['market_panel_active'] ) )
        $tmpl['market_panel_active'] = "";
    $tname = $tmpl['market_panel_active'];
    
    function market_panel_active($name,$tname)
    {
        if( $tname == $name )
            echo 'active';
    }

?>
<div class="col-sm-2">
    <div class="trans_form text-center"><p><?= htmlentities($_G['name']) ?>同學您好</p></div>
    <br>
    <div class="trans_form">
        <ul class="nav nav-pills nav-stacked">
            <li role="presentation"><a href="market.php">注意事項</a></li>
            <?php foreach($tmpl['panel_list'] as $row) { ?>
            <li role="presentation" class="<?php market_panel_active("mlist-".$row['lid'],$tname)?>"><a href="market.php?id=<?=$row['lid']?>"><?=htmlspecialchars($row['name'])?></a></li>
            <?php }?>
            <!--
            <li class="dropdown <?php market_panel_active('site',$tname)?>">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="dLabe3">帳號管理<span class="caret"></span></a>
                <ul class="dropdown-menu" aria-labelledby="dLabe3">
                    <li><a href="market.php?page=profile">修改密碼</a></li>
                </ul>
            </li>
            -->
        </ul>
    </div>
    <br>
    <!--AD-->
    <div>
        <div class="text-center">
        <a href="http://jui.com.tw/" title='建億服裝廠' target="_blank"><img src='src/logo.png' style="background-color:lightgray;width:100%"></a>
    </div>
    </div>
</div>
