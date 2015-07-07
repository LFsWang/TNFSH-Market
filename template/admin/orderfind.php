<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
function delorder(odid){
    if( !confirm("真的要刪除這筆訂單嗎?") )
    {
        return ;
    }
    $.post( "api.php",
        {
            action : 'delorder' ,
            odid : odid
        },
        function(res){
            console.log(res);
            if( res.status == 'SUCC' )
            {
                alert('刪除成功!');
                setTimeout( function(){
                    location.reload();
                },300);
            }
            else
            {
                alert('錯誤!' + res.data);
            }
        },
        "json"
    ).error(function(e){
        alert('錯誤!');
        console.log(e);
    });
}
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'goods'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>訂單查詢</h2>
            </center>
            <form class="form-inline">
                <input type="hidden" name='page' value="orderfind">
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <button type="submit" class="btn btn-default">送出</button>
            </form>
            
            <hr>

            <span class="h3">訂單</span>
            <div class="container-fluid">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>編號</th>
                            <th>帳號</th>
                            <th>姓名</th>
                            <th>班級</th>
                            <th>座號</th>
                            <th>項目</th>
                            <th>訂購時間</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $tmpl['res'] as $row ) { ?>
                        <tr>
                            <td><?=$row['odid']?></td>
                            <td><?=$row['username']?></td>
                            <td><?=htmlentities($row['name'])?></td>
                            <td><?=$row['grade']?>年<?=$row['class']?>班</td>
                            <td><?=$row['number']?></td>
                            <td><?=htmlentities($row['gname'])?></td>
                            <td><?=$row['timestamp']?></td>
                            <td>
                                <a class="icon-bttn" href="#">
                                    <span class="glyphicon glyphicon-eye-open" title="檢視"></span>
                                </a>
                                <a class="icon-bttn" onclick="delorder(<?=$row['odid']?>)">
                                    <span class="glyphicon glyphicon-trash" title="撤銷訂單"></span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>