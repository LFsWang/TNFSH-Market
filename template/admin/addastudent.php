<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
$( document ).ready(function() {
    $("#newstudent").submit(function(e){
        e.preventDefault();
        $("#info").html('');
        $.post("api.php",
            $("#newstudent").serialize(),
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
                <h2>新增學生帳號</h2>
            <hr>
            </center>
            <form class="form-horizontal" method="post" action="admin.php" id="newstudent">
                <input type="hidden" name="action" value="addsastudent">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">帳號</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="account" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">密碼</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" name="password" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">群組</label>
                        <div class="col-sm-10">
                            <select name="group">
                                <?php foreach( $tmpl['groups'] as $row ) { ?>
                                <option value="<?=$row['gpid']?>"><?=htmlentities($row['title'])?></option>
                                <?php }?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" name="name">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grade" class="col-sm-2 control-label">年級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="grade" min="1" max="4">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="class" class="col-sm-2 control-label">班級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="class" min="1">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label">座號</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" name="number" min="1">
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