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
    selector:'#detail',
    plugins :[
        "advlist autolink lists link charmap preview hr anchor pagebreak",
        "searchreplace wordcount visualblocks visualchars code fullscreen",
        "insertdatetime nonbreaking table contextmenu directionality",
        "emoticons template paste textcolor colorpicker textpattern"
    ]
});
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
        
        $("#imglist-block-add").html('');
        imglisthtml = '<h4>等候上傳的圖片</h4>';
        for(var i = 0 ; i < input.files.length ; ++i )
        {
            imglisthtml += "<div class='col-md-3'>";
            imglisthtml += "<img src='#' id='imglist-block-add-"+i+"' style='max-width:100%;'>";
            imglisthtml += "</div>";
        }
        $("#imglist-block-add").html(imglisthtml);
        
        function createfunc(i) {
            return function(e) { 
                console.log( e.target.result );
                console.log( $('#imglist-block-add-'+i) );
                console.log( i );
                $('#imglist-block-add-'+i).attr('src', e.target.result);
            };
        }
        
        for(var i = 0 ; i < input.files.length ; ++i )
        {
            console.log(input.files[i].name);
            
            var reader = new FileReader();
            reader.onload = createfunc(i);
            reader.readAsDataURL(input.files[i]);
        }       
    }
    else
    {
        $("#graphpreview").hide();
        $("#nograph").show();
        $("#imglist-block-add").html('');
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
        $("#maxnum").val(info.maxnum);
        $("#goodtype").val(info.type);
        tinyMCE.activeEditor.setContent(info.description);
        $("#goodsadd").val('修改');
        $("#collapseOne").collapse('show');
        
        $("#imglist-block").html('');
        imglisthtml = '';
        info.image.forEach(function(name) {
            imglisthtml += "<div class='col-md-3'>";
            imglisthtml += "<a href='admin.php?page=editimg&imgid="+name[0]+"' target='_blank'>";
            imglisthtml += "<img src='image/"+name[1] + "' style='max-width:100%;'>";
            imglisthtml += "</a></div>";
        });
        $("#imglist-block").html(imglisthtml);
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
    $("#imglist-block").html('');
    $("#imglist-block-add").html('');
    tinyMCE.activeEditor.setContent('');
}

$( document ).ready(function() {        
    $("#goodgraph").change(function(){
        readURL(this);
    });
    $("#form").submit(function(){
        $("#description").val(tinymce.activeEditor.getContent());
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
            <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                <div class="panel panel-default">
                    <div class="panel-heading" role="tab" id="headingOne">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                <span class="h3" id="formtitle">新增商品</span>
                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                <!--<button class="btn btn-default" id="btnswitch" style="display: none;" onclick="addnew()">切換新增</button>-->
                            </a>
                        </h4>
                        <div id="collapseOne" class="panel-collapse collapse <?php if($tmpl['opentab'])echo"in";?> " role="tabpanel" aria-labelledby="headingOne">
                            <div class="panel-body">
                                <form class='form-horizontal' method = "post" action = "admin.php?page=goods" enctype="multipart/form-data" id="form">
                                    <input type="hidden" id="page" name="page" value="goods">
                                    <input type="hidden" id="method" name="method" value="addnew">
                                    <input type="hidden" id="gid" name="gid" value="0">
                                    <input type="hidden" id="description" name="description" value=''>
                                    <!--<input type="hidden" name="token" value="">-->
                                    <div class="container-fluid">
                                        <div class="row">
                                            <div class="col-lg-5 col-md-5 col-sm-5 table-bordered" style="padding:0px">
                                                <div id="display" style="min-height:200px;">
                                                    <span id="nograph">沒有選擇圖片</span>
                                                    <img id="graphpreview" src="#" max-height='100px' alt="your image" hidden style='max-width:100%;'/>
                                                </div>
                                                <div class="form-group text-center">
                                                    <!--<label for="goodprice">上傳圖片</label>-->
                                                    <input type="file" class="form-control" id="goodgraph" name="goodgraph[]" multiple accept='image/*' style="width:80%;margin-left:25px;">
                                                </div>
                                            </div>
                                            <div class="col-lg-7 col-md-7 col-sm-7" style="padding:10px">
                                                <div class="form-group">
                                                    <label for="goodname" class="col-sm-4 col-md-4 control-label">商品名稱</label>
                                                    <div class="col-sm-8 col-md-8">
                                                        <input type="text" class="form-control" id="goodname" placeholder="制服" name="goodname" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="goodtype" class="col-sm-4 col-md-4 control-label">商品種類</label>
                                                    <div class="col-sm-8 col-md-8">
                                                        <select name="goodtype" id="goodtype">
                                                            <option value="normal">一般商品</option>
                                                            <option value="colthe">衣服</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="goodprice" class="col-sm-4 col-md-4 control-label">販售價格</label>
                                                    <div class="col-sm-8 col-md-8">
                                                        <input type="number" class="form-control" id="goodprice" placeholder="EX.100$" name="goodprice" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="defaultnum" class="col-sm-4 col-md-4 control-label">預設數量</label>
                                                    <div class="col-sm-8 col-md-8">
                                                        <input type="number" class="form-control" id="defaultnum" placeholder="1件" value=1 name="defaultnum" min="0">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="maxnum" class="col-sm-4 col-md-4 control-label">最大購買數量</label>
                                                    <div class="col-sm-8 col-md-8">
                                                        <input type="number" class="form-control" id="maxnum" placeholder="10件" value=10 name="maxnum" min="0">
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <label for="status" class="col-sm-4 control-label">公開使用</label>
                                                    <div class="col-sm-8">
                                                        <div class="checkbox">
                                                            <label>
                                                                <input type="checkbox" name='status[]' value='1'>勾選後，其他管理員的購買清單可以選擇此項物品
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!--end of row-->
                                        <hr>
                                        <div class ="row">
                                            <div class="col-sm-12">
                                                <h4>商品描述</h4>
                                                <textarea id="detail" rows="10"></textarea>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class ="row">
                                            <div class="col-sm-12">
                                                <h4>上傳的圖片</h4>
                                                <div id="imglist-block"></div>
                                            </div>
                                        </div>
                                        <div class ="row">
                                            <div class="col-sm-12" id="imglist-block-add"></div>
                                        </div>
                                        <hr>
                                        <div class ="row">
                                            <div class="col-sm-12 text-right">
                                                <input type="submit" class="btn btn-success" id="goodsadd" value='新增'>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <button class="btn btn-default" id="btnswitch" style="display: none;" onclick="addnew()">切換新增</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
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
                                    <span class="glyphicon glyphicon-trash" title="移除"></span>
                                </a>
                                <a class="icon-bttn" href="<?=$_E['SITEROOT']?>index.php?page=viewgood&gid=<?=$good['gid']?>" target="_blank">
                                    <span class="glyphicon glyphicon-eye-open" title="預覽"></span>
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