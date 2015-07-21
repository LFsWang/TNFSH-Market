<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
$( document ).ready(function() {
    $("#modifystudent").submit(function(e){
        e.preventDefault();
        $("#info").html('');
        $.post("api.php",
            $("#modifystudent").serialize(),
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
            },"json"
        ).error(function(e){
            console.log(e);
        });
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
                <h2>修改學生帳號</h2>
            <hr>
            </center>
            <form class="form-horizontal" method="post" action="admin.php" id="modifystudent">
                <input type="hidden" name="action" value="modifyastudent">
                <input type="hidden" name="suid" value="<?=$tmpl['user']['suid']?>">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">帳號</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="account" value="<?=htmlentities($tmpl['user']['username'])?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">密碼</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">群組</label>
                        <div class="col-sm-10">
                            <select name="group">
                                <?php foreach( $tmpl['groups'] as $row ) { ?>
                                <?php if( $row['gpid'] == $tmpl['user']['gpid'] ): ?>
                                <option value="<?=$row['gpid']?>" selected><?=htmlentities($row['title'])?></option>
                                <?php else: ?>
                                <option value="<?=$row['gpid']?>"><?=htmlentities($row['title'])?></option>
                                <?php endif; ?>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                    <!--
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">類別</label>
                        <div class="col-sm-10">
                            <select name="type">
                                <option value="1">新生</option>
                                <option value="0">在校生</option>
                            </select>
                        </div>
                    </div>
                    -->
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name" value="<?=htmlentities($tmpl['user']['name'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grade" class="col-sm-2 control-label">年級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="grade" min="0" max="4" value="<?=htmlentities($tmpl['user']['grade'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="class" class="col-sm-2 control-label">班級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="class" min="0" value="<?=htmlentities($tmpl['user']['class'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label">座號</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="number" min="0" value="<?=htmlentities($tmpl['user']['number'])?>">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">送出</button>
                            <span id="info"><span>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>