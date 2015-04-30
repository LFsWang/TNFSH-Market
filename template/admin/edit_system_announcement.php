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
        selector:'#announcement',
        plugins :[
            "advlist autolink lists link charmap preview hr anchor pagebreak",
            "searchreplace wordcount visualblocks visualchars code fullscreen",
            "insertdatetime nonbreaking table contextmenu directionality",
            "emoticons template paste textcolor colorpicker textpattern"
        ]
    });
    $(document).ready(function()
    {
        $("#announcement-edit").submit(function(e)
        {
            //e.preventDefault();
            
            $("#info").html("SUBMIT...");
            $("#content").val(tinymce.activeEditor.getContent());
        });
    });
</script>

<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'site'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3>編輯公告</h3>
            </center>
            <form id="announcement-edit" method="post">
                <input type="hidden" name="page" value="edit_system_announcement">
                <input type="hidden" name="content" id="content" value="">
                <textarea id="announcement" rows="10"><?=$tmpl['system_announcement']?></textarea>
                <br>
                <div class="text-right">
                    <span id="info"></span>
                    <button type="submit" class="btn btn-success">送出</button>
                </div>
            </form>
            
            <?php //var_dump($_SESSION);?>
        </div>
    </div>
</div>