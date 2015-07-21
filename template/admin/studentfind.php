<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-2 col-md-2 col-sm-2 trans_form">
            <?php $tmpl['admin_panel_active'] = 'student'; ?>
            <?php Render::renderSingleTemplate('panel','admin'); ?>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1"><br></div>
        <div class="col-lg-8 col-md-8 col-sm-8 trans_form_mh300 panel panel-default">
            <center>
                <h2>學生帳號查詢</h2>
            </center>
            <form class="form-inline">
                <input type="hidden" name='page' value="studentfind">
                <div class="form-group">
                    <label for="acct">帳號(身分證)</label>
                    <input type="text" class="form-control" name="acct">
                </div>
                <div class="form-group">
                    <label for="name">姓名</label>
                    <input type="text" class="form-control" name="name">
                </div>
                <button type="submit" class="btn btn-default">送出</button>
            </form>
            
            <hr>

            <span class="h3">帳號</span>
            <div class="container-fluid">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>帳號</th>
                            <th>姓名</th>
                            <th>班級</th>
                            <th>座號</th>
                            <th>操作</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach( $tmpl['res'] as $row ) { ?>
                        <tr>
                            <td><?=$row['suid']?></td>
                            <td><?=$row['username']?></td>
                            <td><?=htmlentities($row['name'])?></td>
                            <td><?=$row['grade']?>年<?=$row['class']?>班</td>
                            <td><?=$row['number']?></td>
                            <td>
                                <a class="icon-bttn" href="admin.php?page=modifyastudent&suid=<?=$row['suid']?>" target="_blank">
                                    <span class="glyphicon glyphicon-pencil" title="編輯"></span>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>