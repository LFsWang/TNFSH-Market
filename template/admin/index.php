<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'overview'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h3>ADMIN</h3>
            </center>
            <?php if( isset($tmpl['system_announcement']) ): ?>
            <?=$tmpl['system_announcement']?>
            <?php endif; ?>
            <?php //var_dump($_SESSION);?>
        </div>
    </div>
</div>