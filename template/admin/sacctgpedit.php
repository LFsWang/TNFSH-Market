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
                    if( confirm('第一筆資料為：' + res.data + "\n是否繼續?") )
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
                <div class="col-sm-12"><br>
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
                                        <input type="hidden" name="try" value="1">
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
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                匯入編班資料
            </div>
        </div>
        
    </div>
</div>