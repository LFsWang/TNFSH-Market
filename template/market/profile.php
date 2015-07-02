<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
function checkpass()
{
    $("#ps2m").removeClass("has-error has-success");
    if( $("#ps1").val() != $("#ps2").val() )
    {
        $("#ps2m").addClass("has-error");
        $("#info").html('密碼不一致');
        return false;
    }
    else
    {
        $("#ps2m").addClass("has-success");
        $("#info").html('');
        return true;
    }
}
$( document ).ready(function() {
    $("#modifyspass").submit(function(e){
        e.preventDefault();
        if( !checkpass() )
        {
            return false;
        }
        $("#info").html('');
        $.post("api.php",
            $("#modifyspass").serialize(),
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
        <?php $tmpl['market_panel_active'] = 'site'; ?>
        <?php Render::renderSingleTemplate('panel','market'); ?>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>學生資料</h2>
            <hr>
            </center>
            <form class="form-horizontal" method="post" action="api.php" id="modifyspass">
                <input type="hidden" name="action" value="modifyspass">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="title" class="col-sm-2 control-label">帳號</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?=$_G['username']?>" readonly>
                        </div>
                    </div>
                    <hr>
                    <!-- 學校說讓你改密碼會造成困擾，不過你會改還是讓你改XD -->
					<div id="dakckdncuarhf" hidden>
						<span id="helpBlock" class="help-block">修改密碼</span>
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">舊密碼</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" name="passwordold" required>
							</div>
						</div>
						<div class="form-group">
							<label for="password" class="col-sm-2 control-label">新密碼</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="ps1" name="passwordnew" required>
							</div>
						</div>
						<div class="form-group" id="ps2m">
							<label for="password" class="col-sm-2 control-label">確認</label>
							<div class="col-sm-10">
								<input type="password" class="form-control" id="ps2" onchange="checkpass()" required>
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-offset-2 col-sm-10">
								<button type="submit" class="btn btn-default">送出</button>
								<span id="info"><span>
							</div>
						</div>
					</div>
                    
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="name" class="col-sm-2 control-label">姓名</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?=$_G['name']?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="grade" class="col-sm-2 control-label">年級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="<?=$_G['grade']?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="class" class="col-sm-2 control-label">班級</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="<?=$_G['class']?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="number" class="col-sm-2 control-label">座號</label>
                        <div class="col-sm-10">
                            <input type="number" class="form-control" value="<?=$_G['number']?>" readonly>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="col-sm-2 control-label">群組</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" value="<?=$_G['gpid']?>" readonly>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>