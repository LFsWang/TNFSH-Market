<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<script>

function readURL(input) {

    if (input.files && input.files[0]) {
        if( $("#nograph").is(":visible") )
        {
            $("#nograph").hide();
            $("#graphpreview").show();
        }
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#graphpreview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
    else
    {
        $("#graphpreview").hide();
        $("#nograph").show();
    }
}

function editgood(gid)
{
    $.get( "api.php",{ action : "getgoodinfo", gid : gid },function( data ) {
        if( data.status != "SUCC" )
        {
            alert(data.data);
            if( data.data == 'Access denied!' )
            {
                location.href = 'index.php';
            }
        }
        
        info = data.data;
        console.log(info);
        $("#formtitle").html('修改商品');
        $("#btnswitch").show();
        
        $("#page").val('goods');
        $("#method").val('modify');
        $("#gid").val(info.gid);
        
        
        $("#goodname").val(info.name);
        $("#goodprice").val(info.price);
        $("#defaultnum").val(info.defaultnum);
        $("#goodtype").val(info.type);
        
        $("#goodsadd").val('修改');
        
    },"json");
}

function addnew()
{
    $("#form")[0].reset();
    $("#page").val('goods');
    $("#gid").val('0');
    $("#method").val('addnew');
    $("#btnswitch").hide();
    $("#formtitle").html('新增商品');
    $("#goodsadd").val('新增');
}

$( document ).ready(function() {        
    $("#goodgraph").change(function(){
        readURL(this);
    });
    $("#form").onsubmit(function(){
        $("#detail").val(tinymce.activeEditor.getContent());
        return true;
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
                <h2>商品管理</h2>
            </center>
            <hr>
            <span class="h3" id="formtitle">新增商品</span>
            <button class="btn btn-default" id="btnswitch" style="display: none;" onclick="addnew()">切換新增</button>
            <form class='form-inline' method = "post" action = "admin.php?page=goods" enctype="multipart/form-data" id="form">
                <input type="hidden" id="page" name="page" value="goods">
                <input type="hidden" id="method" name="method" value="addnew">
                <input type="hidden" id="gid" name="gid" value="0">
                <input type="hidden" id="detail" name="detail" value=''>
                <!--<input type="hidden" name="token" value="">-->
                <div class="container-fluid">
                    <table class="table table-bordered">
                        <tbody>
                            <tr>
                                <td rowspan="4" class="col-lg-3 col-md-3 col-sm-3">
                                    <div id="display">
                                        <span id="nograph">沒有選擇圖片</span>
                                        <img id="graphpreview" src="#" width='100%' max-height='100px' alt="your image" hidden />
                                    </div>
                                </td>
                                <td class="col-lg-6 col-lg-6 col-lg-6">
                                    <div class="form-group">
                                        <label for="goodname">商品名稱</label>
                                        <input type="text" class="form-control" id="goodname" placeholder="制服" name="goodname" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="goodtype">商品種類</label>
                                        <select name="goodtype" id="goodtype">
                                            <option value="normal">一般商品</option>
                                            <option value="colthe">衣服</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="goodprice">販售價格</label>
                                        <input type="number" class="form-control" id="goodprice" placeholder="EX.100$" name="goodprice" required>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="defaultnum">預設數量</label>
                                        <input type="number" class="form-control" id="defaultnum" placeholder="1件" value=1 name="defaultnum" min="0">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <!--<label for="goodprice">上傳圖片</label>-->
                                        <input type="file" class="form-control" id="goodgraph" name="goodgraph[]" multiple accept='image/*'>
                                    </div>
                                </td>
                                <td>
                                    <div class='text-right'>
                                        <small><span id="info"></span></small>
                                        <input type="submit" class="btn btn-success" id="goodsadd" value='新增'>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </form>
            
            <hr>
            <span class="h3">商品列表</span>
            <div class="container-fluid">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>商品名稱</th>
                            <th>種類</th>
                            <th>售價</th>
                            <th>預設數量</th>
                            <th>預設購買金額</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach($tmpl['goodslist'] as $good){?>
                        <tr>
                            <td><?=$good['gid']?></td>
                            <td><?=htmlspecialchars($good['name'])?></td>
                            <td><?=$good['type']?></td>
                            <td><?=$good['price']?></td>
                            <td><?=$good['defaultnum']?></td>
                            <td><?=$good['price'] * $good['defaultnum']?></td>
                            <?php #TOOLS?>
                            <td>
                                <a class="icon-bttn" href="#" onclick="editgood(<?=$good['gid']?>)">
                                    <span class="glyphicon glyphicon-pencil" title="編輯"></span>
                                </a>
                                <a class="icon-bttn" href="#">
                                    <span class="glyphicon glyphicon-lock" title="隱藏"></span>
                                </a>
                                <a class="icon-bttn" href="#">
                                    <span class="glyphicon glyphicon-trash" title="移除"></span>
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