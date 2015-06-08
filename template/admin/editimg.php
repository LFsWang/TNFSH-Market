<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<?php $img=$tmpl['imgdata']; ?>
<script>

$(document).ready(function()
{
    $("#submitimginfo").submit(function(e)
    {
        e.preventDefault();
        $("#api-action").val('editimage');
        $.post("api.php",
            $("#submitimginfo").serialize(),
            function(res){
                if(res.status == 'error')
                {
                    $("#info-show").html(res.data);
                    $("#info-show").css('color','Red');
                }
                else
                {
                    $("#info-show").css('color','Lime');
                    $("#info-show").html('Success!');
                    setTimeout(function(){
                        location.reload();
                    }, 500);
                }
                console.log(res);
        },"json");
        return true;
    });
})
</script>
<div class="container-fluid">
    <div class="row">
        <div class="col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'goods'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-sm-1"><br></div>
        <div class="col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>編輯圖片</h2>
            </center>
            <hr>
            <div class="row">
                <div class="col-md-6">
                    <a href="#" class="thumbnail">
                    <img src="<?=$img['url']?>" alt="..." style = "height:400px;width:auto;overflow:hidden;">
                    </a>
                </div>
                <div class="col-md-6">
                    <form id="submitimginfo" method="post">
                        <input type="hidden" name="action" id="api-action">
                        <input type="hidden" name="imgid" value="<?=$img['imgid']?>">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>屬性</th>
                                    <th>數值</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>原始檔名</td>
                                    <td><?=htmlentities($img['realname'])?></td>
                                </tr>
                                <tr>
                                    <td>雜湊檔名</td>
                                    <td><?=htmlentities($img['hashname'])?></td>
                                </tr>
                                <tr>
                                    <td>檔案大小</td>
                                    <td><?=(int)(filesize($_E['ROOT'].'/image/'.$img['hashname'])/1024)?> Kbytes</td>
                                </tr>
                                <tr>
                                    <td>標題</td>
                                    <td>
                                        <input type="text" class="form-control" id="title" placeholder="標題" name="title" value="<?=htmlentities($img['title'])?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td>描述</td>
                                    <td>
                                        <input type="text" class="form-control" id="description" placeholder="描述" name="description" value="<?=htmlentities($img['description'])?>">
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <div class="col-sm-12 text-right">
                                            <span id="info-show"></span>
                                            <button class="btn btn-danger">移除圖片</button>
                                            <input type="submit" class="btn btn-success" value='修改內容'>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>