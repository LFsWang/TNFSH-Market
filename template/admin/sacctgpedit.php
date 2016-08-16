<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>
$( document ).ready(function() {
    $("#modifysgroup").submit(function(e){
        e.preventDefault();
        $("#info").html('');
        $.post("api.php",
            $("#modifysgroup").serialize(),
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
            },"json"
        ).error(function(e){
            console.log(e);
        });
        return true;
    });
    
    $("#formIA").submit(function(e){
        e.preventDefault();
        $("#infoIA").html('');
        $("#IAres").html('');
        $("#tryIA").val('1');
        //first try
        var formData = new FormData($(this)[0]);
        stats = false;
        $.ajax({
            url: "api.php",
            type: 'POST',
            data: formData,
            dataType: "json",
            async: false,
            success: function (res) {
                console.log(res);
                if( res.status == 'SUCC' )
                {
                    if( confirm('第一筆資料為：\n' + res.data + "\n是否繼續?") )
                    {
                        stats = true;
                    }
                }
                else
                {
                    $('#infoIA').css('color','Red');
                    $('#infoIA').html(res.data);
                }
            },
            error: function (res) {
                console.log(res);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        if( !stats ){
            return true;
        } 
        
        $("#tryIA").val('0');
        $("#IAres").show();
        $("#IAres").html('操作中，請耐心等候，請勿關閉視窗');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "api.php",
            type: 'POST',
            data: formData,
            dataType: "json",
            async: false,
            success: function (res) {
                console.log(res);
                $("#IAres").html(res.data);
                
                if( res.status == 'SUCC' )
                {
                    alert('成功匯入');
                }
                else
                {
                    alert('匯入失敗');
                }
            },
            error: function (res) {
                console.log(res);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        return true;
    });
    
    $("#formIC").submit(function(e){
        e.preventDefault();
        $("#infoIC").html('');
        $("#ICres").html('');
        $("#tryIC").val('1');
        //first try
        var formData = new FormData($(this)[0]);
        stats = false;
        $.ajax({
            url: "api.php",
            type: 'POST',
            data: formData,
            dataType: "json",
            async: false,
            success: function (res) {
                console.log(res);
                if( res.status == 'SUCC' )
                {
                    if( confirm('第一筆資料為：\n' + res.data + "\n是否繼續?") )
                    {
                        stats = true;
                    }
                }
                else
                {
                    $('#infoIC').css('color','Red');
                    $('#infoIC').html(res.data);
                }
            },
            error: function (res) {
                console.log(res);
            },
            cache: false,
            contentType: false,
            processData: false
        });
        
        if( !stats ){
            return true;
        } 
        
        $("#tryIC").val('0');
        $("#ICres").show();
        $("#ICres").html('操作中，請耐心等候，請勿關閉視窗');
        var formData = new FormData($(this)[0]);
        $.ajax({
            url: "api.php",
            type: 'POST',
            data: formData,
            dataType: "json",
            async: false,
            success: function (res) {
                console.log(res);
                $("#ICres").html(res.data);
                
                if( res.status == 'SUCC' )
                {
                    alert('成功匯入');
                }
                else
                {
                    alert('匯入失敗');
                }
            },
            error: function (res) {
                console.log(res);
            },
            cache: false,
            contentType: false,
            processData: false
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
                <h2>修改學生群組</h2>
            <hr>
            </center>
            <h3>基本資料</h3>
            <div class="row">
                <form class="form-horizontal" method="post" action="api.php" id="modifysgroup">
                    <input type="hidden" name="action" value="modifysgroup">
                    <input type="hidden" name="gpid" value="<?=$tmpl['group']['gpid']?>">
                    <div class="col-sm-6">
                        <div class="form-group">
                            <label for="title" class="col-sm-3 control-label">名稱</label>
                            <div class="col-sm-9">
                                <input type="text" class="form-control" name="title" value="<?=htmlentities($tmpl['group']['title'])?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="password" class="col-sm-3 control-label">是否隱藏</label>
                            <div class="col-sm-9">
                                <input type="checkbox" name="hidden" <?php if($tmpl['group']['hidden'])echo"checked";?>>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10 text-right">
                                <span id="info"></span>
                                <button type="submit" class="btn btn-default">送出</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <p>目前有<?=$tmpl['allacct']?>個帳號在此群組</p>
                    </div>
                </form>
            </div>

            <hr>
            <h3>進階操作</h3>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel-group" id="importAcct" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingIA">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#importAcct" href="#collapseIA" aria-expanded="true" aria-controls="collapseIA">
                                        <span class="h3" id="formtitle">匯入帳號</span>
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                </h4>
                                <div id="collapseIA" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIA">
                                    <div class="panel-body">
                                        <form class='form-horizontal' method = "post" action = "api.php" enctype="multipart/form-data" id="formIA">
                                            <input type="hidden" name="action" value="importacct">
                                            <input type="hidden" name="try" id="tryIA" value="1">
                                            <input type="hidden" name="gpid" value="<?=$tmpl['group']['gpid']?>">
                                            
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p>說明：XLSX第一欄編號為1，可用逗號來連結多個欄位。</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="xlsx" class="col-sm-4 col-md-4 control-label">XLSX檔案</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="file" class="form-control" name="xlsxIA" accept='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' required> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodname" class="col-sm-4 col-md-4 control-label">帳號欄位</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="acct" value="3" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodtype" class="col-sm-4 col-md-4 control-label">密碼欄位</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="pass" value="4,5,6" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodtype" class="col-sm-4 col-md-4 control-label">姓名欄位</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="name" value="2" required>
                                                        </div>
                                                    </div>
                                                </div><!--end of row-->
                                                <hr>
                                                <div class ="row">
                                                    <div class="col-sm-12 text-right">
                                                        <span id="infoIA"></span>
                                                        <input type="submit" class="btn btn-success" id="startIA" value='新增帳號'>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class ="row">
                                                    <div class="well" id="IAres" hidden>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!--Import Classes-->
                <div class="col-sm-12">
                    <div class="panel-group" id="importClass" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingIC">
                                <h4 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#importClass" href="#collapseIC" aria-expanded="true" aria-controls="collapseIC">
                                        <span class="h3" id="formtitle">匯入編班資料</span>
                                        <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                    </a>
                                </h4>
                                <div id="collapseIC" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingIC">
                                    <div class="panel-body">
                                        <form class='form-horizontal' method = "post" action = "api.php" enctype="multipart/form-data" id="formIC">
                                            <input type="hidden" name="action" value="importclass">
                                            <input type="hidden" name="try" id="tryIC" value="1">
                                            <input type="hidden" name="gpid" value="<?=$tmpl['group']['gpid']?>">
                                            
                                            <div class="container-fluid">
                                                <div class="row">
                                                    <div class="col-sm-12">
                                                        <p>說明：XLSX第一欄編號為1，可用逗號來連結多個欄位。</p>
                                                        <p>留空表示不使用該欄位</p>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="xlsx" class="col-sm-4 col-md-4 control-label">XLSX檔案</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="file" class="form-control" name="xlsxIC" accept='application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' required> 
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodname" class="col-sm-4 col-md-4 control-label">XLSX頁數</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="excelpage" value="1" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodname" class="col-sm-4 col-md-4 control-label">身分證(帳號)</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="acct" value="" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodtype" class="col-sm-4 col-md-4 control-label">年級</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="grade">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodtype" class="col-sm-4 col-md-4 control-label">班級</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="class">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="goodtype" class="col-sm-4 col-md-4 control-label">座號</label>
                                                        <div class="col-sm-8 col-md-8">
                                                            <input type="text" class="form-control" name="number">
                                                        </div>
                                                    </div>
                                                </div><!--end of row-->
                                                <hr>
                                                <div class ="row">
                                                    <div class="col-sm-12 text-right">
                                                        <span id="infoIC"></span>
                                                        <input type="submit" class="btn btn-success" id="startIC" value='修改帳號'>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class ="row">
                                                    <div class="well" id="ICres" hidden>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>