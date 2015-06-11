<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
$( document ).ready(function() {
    $("#addadmin").submit(function(e){
        e.preventDefault();
        $("#info").html('');
        $.post("api.php",
                $("#addadmin").serialize(),
                function(res){
                    console.log(res);
                    //console.log($("#login_form").serialize());
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
        }
    );
});
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
                <h2>管理員列表</h2>
            
            <hr>
            </center>
            <h3>增加管理員</h3>
            <form class="form-inline" id = "addadmin">
                <input type = "hidden" name="action" value="addadmin">
                <div class="form-group">
                    <label for="username">帳號</label>
                    <input type="text" class="form-control" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">密碼</label>
                    <input type="password" class="form-control" name="password" required>
                </div>
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="root">給予最高權限
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
                            <th>UID</th>
                            <th>帳號</th>
                            <th>權限</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tmpl['users'] as $row){ ?>
                        <tr>
                            <td><?=$row['uid']?></td>
                            <td><?=htmlspecialchars($row['username'])?></td>
                            <td>
                                <?php if( $row['root'] ): ?>
                                <span class="glyphicon glyphicon-king" title="最高權限"></span>ROOT
                                <?php endif; ?>
                            </td>
                            <td>
                                <a class="icon-bttn" href="admin.php?page=admininfo&uid=<?=$row['uid']?>" >
                                    <span class="glyphicon glyphicon-pencil" title="編輯"></span>
                                </a>
                                <?php if( $_G['uid'] != $row['uid'] ): ?>
                                <a class="icon-bttn" href="#" onclick="editgoodlist(<?=$row['uid']?>)">
                                    <span class="glyphicon glyphicon-remove" title="移除使用者"></span>
                                </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>