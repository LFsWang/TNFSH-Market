<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script src="js/tinymce/tinymce.min.js"></script>
<script>
tinymce.init({
    language:"zh_TW",
    selector:'#goodlistdetail',
    plugins :[
        "advlist autolink lists link charmap preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime nonbreaking table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ]
});
function addnew()
{
    $("#form")[0].reset();
    /*$("#page").val('goods');
    $("#gid").val('0');
    $("#method").val('addnew');
    $("#btnswitch").hide();
    $("#formtitle").html('新增商品');
    $("goodsadd").val('新增');*/
}

function editgoodlist(id)
{
    console.log(id);
}

$( document ).ready(function() {
    $('[data-toggle="popover"]').popover({html:true});
    $("#form").submit(function(){
        $("#detail").val(tinymce.activeEditor.getContent());
    });
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
                <h2>購買清單</h2>
            </center>
            <hr>
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="h3" id="formtitle">新增購買清單</span>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                        <div class="panel-body">
                            <form class='form-horizontal' method = "post" action = "admin.php?page=goodlists" id="form">
                                <input type="hidden" id="page" name="page" value="goodlists">
                                <input type="hidden" id="method" name="method" value="addnew">
                                <input type="hidden" id="lid" name="lid" value="0">
                                <input type="hidden" id="detail" name="detail" value="">
                                <!--<input type="hidden" name="token" value="">-->
                                <small><span id="info"></span></small>
                                <div class="form-group">
                                    <label for="listname" class="col-sm-2 control-label">清單名稱</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="listname" name="listname" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="starttime" class="col-sm-2 control-label">開放時間</label>
                                    <div class="col-sm-10">
                                    <input type="date" class="form-control" id="starttime" name="starttime" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="endtime" class="col-sm-2 control-label">截止時間</label>
                                    <div class="col-sm-10">
                                    <input type="date" class="form-control" id="endtime" name="endtime" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="listname" class="col-sm-2 control-label">採購商品</label>
                                    <div class="col-sm-10">
                                    <?php foreach($tmpl['goodslist'] as $row ) {?>
                                        <div class="checkbox col-lg-3 col-md-4 col-sm-6" style="overflow:hidden;" >
                                            <label>
                                                <input type="checkbox" name='goods[]' value='<?=$row['gid']?>'><span title='<?=htmlspecialchars($row['name'])?>'><?=htmlspecialchars($row['name'])?></span>
                                            </label>
                                        </div>
                                    <?php }?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="usergroup" class="col-sm-2 control-label">對象</label>
                                    <div class="col-sm-10">
                                    <input type="text" class="form-control" id="usergroup" name="usergroup" >
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="listname" class="col-sm-2 control-label">清單描述</label>
                                    <div class="col-sm-10">
                                        <textarea id="goodlistdetail" rows="15"></textarea>
                                    </div>
                                </div>
                                <div class="form-group"> </div>
                                <div class="form-group">
                                    <div class="col-sm-offset-10 col-sm-2 text-center">
                                    <input type="submit" class="btn btn-success" id="listadd" value='新增'>
                                    </div>
                                </div>             
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <hr>
            <span class="h3">購買清單</span>
            <div class="container-fluid">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>購買清單名稱</th>
                            <td>開始時間</td>
                            <td>結束時間</td>
                            <th>預設總價</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tmpl['goodlists'] as $row){ ?>
                        <tr>
                            <td><?=$row['lid']?></td>
                            <td>
                                <span tabindex="0" role="button" data-toggle="popover" data-trigger="focus" title="包含商品" data-content="<?=htmlspecialchars($row['liststr'])?>"><?=htmlspecialchars($row['name'])?></span>
                            </td>
                            <!--<td><?=htmlspecialchars($row['name'])?></td>-->
                            <td><?=$row['starttime']?></td>
                            <td><?=$row['endtime']?></td>
                            <td><?=$row['sum']?></td>
                            <td>
                                <a class="icon-bttn" href="#" onclick="editgoodlist(<?=$row['lid']?>)">
                                    <span class="glyphicon glyphicon-pencil" title="編輯"></span>
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