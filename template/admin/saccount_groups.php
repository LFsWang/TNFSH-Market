<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
function delgroup(gpid){
    if( !confirm("真的要刪除這個群組嗎? 此動作無法復原，解將遺失所有帳號組的資訊") )
    {
        return ;
    }
    $.post( "api.php",
        {
            action : 'delgroup' ,
            gpid : gpid
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
$( document ).ready(function() {
    $("#addsgroup").submit(function(e){
        e.preventDefault();
        $("#info").html('');
        $.post("api.php",
            $("#addsgroup").serialize(),
            function(res){
                console.log(res);
                if( res.status == 'SUCC' )
                {
                    $('#info').css('color','Lime');
                    $('#info').html('Success! reload page');
                    setTimeout( function(){
                        location.reload();                       
                    },500);
                }
                else
                {
                    $('#info').css('color','Red');
                    $('#info').html(res.data);
                }
            },"json");
         return true;
    }); 
});
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'student'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>學生群組列表</h2>
            <hr>
            </center>
            <h3>增加學生群組(DEVELOP)</h3>
            <form class="form-inline" id = "addsgroup">
                <input type = "hidden" name="action" value="addsgroup">
                <div class="form-group">
                    <label for="title">群組名稱</label>
                    <input type="text" class="form-control" name="title" required>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="hidden">隱藏
                    </label>
                </div>
                <button type="submit" class="btn btn-default">送出</button>
                <span id="info"></span>
            </form>
            <hr>
            
            <div class="container-fluid">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>GPID</th>
                            <th>群組名</th>
                            <th>顯示</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tmpl['groups'] as $row){ ?>
                        <tr>
                            <td><?=$row['gpid']?></td>
                            <td><?=htmlspecialchars($row['title'])?></td>
                            <td>
                                <?php if( !$row['hidden'] ): ?>
                                <span class="glyphicon glyphicon-eye-open" title="可用"></span>可以使用
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="icon-bttn" href="admin.php?page=sacctgpedit&gpid=<?=$row['gpid']?>" >
                                    <span class="glyphicon glyphicon-pencil" title="編輯"></span>
                                </a>
                                <a class="icon-bttn" onclick="delgroup(<?=$row['gpid']?>)">
                                    <span class="glyphicon glyphicon-trash" title="刪除群組"></span>
                                </a>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>