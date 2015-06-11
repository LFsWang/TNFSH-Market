<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'site'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>系統紀錄</h2>
            
            <hr>
            </center>
            
            <div class="container-fluid">
                <table class="table table-striped table-hover font-consolas">
                    <thead>
                        <tr>
                            <th class="col-sm-1">ID</th>
                            <th class="col-sm-2">timestamp</th>
                            <th class="col-sm-1">namespace</th>
                            <th>描述</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($tmpl['syslog'] as $row){ ?>
                        <tr>
                            <td><?=$row['id']?></td>
                            <td><?=$row['timestamp']?></td>
                            <td><?=htmlspecialchars($row['namespace'])?></td>
                            <td><?=htmlspecialchars($row['description'])?></td>
                        </tr>
                        <?php }?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>