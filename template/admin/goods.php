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

$( document ).ready(function() {        
    $("#goodgraph").change(function(){
        readURL(this);
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
            <span class="h3">新增商品</span>
            <form class='form-inline'>
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
                                        <input type="text" class="form-control" id="goodname" placeholder="制服" name="goodname">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="goodname">商品種類</label>
                                        <select name="goodtype">
                                            <option value="normal">一般商品</option>
                                            <option value="clouth">衣服</option>
                                        </select>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="goodprice">販售價格</label>
                                        <input type="number" class="form-control" id="goodprice" placeholder="100$" name="goodprice" min="0">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <label for="goodprice">預設數量</label>
                                        <input type="number" class="form-control" id="goodprice" placeholder="1件" value=1 name="goodprice" min="0">
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="form-group">
                                        <!--<label for="goodprice">上傳圖片</label>-->
                                        <input type="file" class="form-control" id="goodgraph" name="goodgraph" multiple accept='image/*'>
                                    </div>
                                </td>
                                <td>
                                    <div class='text-right'>
                                        <small><span id="info"></span></small>
                                        <button type="button" class="btn btn-success" id="goodsadd" >新增</button>
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
                            <th>售價</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>風景畫</td>
                            <td>300</td>
                            <td>
                                <a class="icon-bttn" href="#">
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
                        <tr>
                            <td>2</td>
                            <td>風景畫</td>
                            <td>3015</td>
                            <td>
                                <a class="icon-bttn" href="#">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>