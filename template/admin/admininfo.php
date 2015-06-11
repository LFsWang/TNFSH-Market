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
                <h2>帳號資料</h2>
            
            <hr>
            </center>
            <h3>管理員<?=$tmpl['users']['username']?></h3>
            <form class="form-horizontal" method="post" action="admin.php">
                <input type="hidden" name="page" value="admininfoedit">
                <input type="hidden" name="uid" value="<?=$tmpl['users']['uid']?>">
                <?php if( $tmpl['users']['uid'] == $_G['uid'] ): ?>
                <div class="form-group">
                    <label for="passwordold" class="col-sm-2 control-label">舊密碼</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="passwordold" name="passwordold" required>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                    <label for="password" class="col-sm-2 control-label">新密碼</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label for="password2" class="col-sm-2 control-label">確認密碼</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" id="password2">
                    </div>
                </div>
                <?php if( $_G['root'] && $tmpl['users']['uid'] != $_G['uid'] ): ?>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <div class="checkbox">
                            <label>
                                <?php if($tmpl['users']['root']): ?>
                                <input name="root" type="checkbox" checked>給予最高權限
                                <?php else: ?>
                                <input name="root" type="checkbox">給予最高權限
                                <?php endif; ?>
                            </label>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
                <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                <button type="submit" class="btn btn-default">送出</button>
                </div>
                </div>
            </form>
        </div>
    </div>
</div>