<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>

<body><div id="wrap">
    <nav class="navbar navbar-default navbar-inverse navbar-static-top">
        <div class="container-fluid">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
<<<<<<< HEAD
                <!--<a class="navbar-brand" href="#" data-toggle="modal" data-target="#LoginModal">臺南一中採購系統</a>-->
                <a class="navbar-brand" href="index.php">臺南一中採購系統</a>
=======
                <a class="navbar-brand" href="#" data-toggle="modal" data-target="#LoginModal"><?=$_E['site']['name']?></a>
>>>>>>> origin/master
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav">
                    <?php if( $_G['usertype'] == 1 ): ?>
                    <li><a href="market.php">採購頁面</a></li>
                    <?php endif; ?>
                    <li><a href="https://docs.google.com/forms/d/1Qn4rHAa6L_cnysumjYpL_xpWDxkI-OfhhjVAcB-ymIg/viewform" target="_blank">問題回報</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <?php if( $_G['usertype'] == 2 ): ?>
                    <li><a href="admin.php">管理</a></li>
                    <?php endif; ?>
                    
                    <?php if( $_G['usertype'] == 0 ): ?>
                    <li><a href="#" data-toggle="modal" data-target="#LoginModal">登入</a></li>
                    <?php else: ?>
                    <li><a href="api.php?action=logout">登出</a></li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    <?php if($tmpl['error']):?>
    <div class="alert alert-danger fade in" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <strong>Oh! System error</strong>
        <ul>
        <?php foreach($_E['template']['error'] as $list){ ?>
            <li>(<?=$list['namespace']?>)<?=$list['msg']?></li>
        <?php }?>
        </ul>
    </div>
    <?php endif;?>
    <?php if($tmpl['succ']):?>
    <div class="alert alert-success fade in" role="alert" id="success-alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <strong>Nice!</strong>
        <ul>
        <?php foreach($_E['template']['succ'] as $list){ ?>
            <li>(<?=$list['namespace']?>)<?=$list['msg']?></li>
        <?php }?>
        </ul>
    </div>
    <script>
    $("#success-alert").fadeTo(2000, 500).slideUp(500, function(){
        $("#success-alert").alert('close');
    });
    </script>
    <?php endif;?>
    <!--[if lt IE 8]>
    <script>
    alert("本網站不支援IE，請更換瀏覽器，若發生任何錯誤均不負責。");
    </script>
    <![endif]-->
    <!--[if lte IE 11]>
    <div class="alert alert-danger fade in" role="alert" id="whydidyouuseie">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <strong>Oh My God !</strong>
        <ul>
            <li><a href="http://www.ithome.com.tw/news/90027" target="_blank">還在使用過時且危險的IE?</a> 趕快換個瀏覽器吧，本網站推薦使用<a href="https://www.google.com/chrome/browser/desktop/index.html" target="_blank">Chrome瀏覽器。</a>(若IE 11以前的版本將會有額外的跳窗警告)</li>
        </ul>
    </div>
    <![endif]-->
<?php if( $_G['usertype'] == 0 ): ?>
    <!--Not Login-->
    <!--LoginModal-->
    <?php if($_E['loginrecaptcha']): ?>
    <script src='https://www.google.com/recaptcha/api.js'></script>
    <?php endif;?>
    <script>
        function login()
        {
            $.post("api.php",
                $("#login_form").serialize(),
                function(res){
                    console.log(res);
                    if( res.status == 'SUCC' )
                    {
                        $('#info').css('color','Lime');
                        $('#info').html('Success! reload page');
                        setTimeout( function(){
                            $('#login_form').modal('hide');
                            setTimeout( function(){
                                if( res.data == 1 )
                                {
                                    location.href = 'market.php';
                                }
                                else
                                {
                                    location.href = 'admin.php';
                                }                        
                            },200);
                        },300);
                    }
                    else
                    {
                        $('#info').css('color','Red');
                        $('#info').html(res.data);
                    }
                },"json").error(function(e) {
                    console.log(e);
                    alert( "JSON format Fail!" );
                });
            return true;
        }
        $( document ).ready(function() {        
            $("#login_form").keyup(function(event){
                if(event.keyCode == 13){
                    $("#loginsubmit").click();
                }
            });
        });
    </script>
    <div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModalLabel">登入</h4>
                </div>
                <div class="modal-body">
                    <form id="login_form">
                        <input type = "hidden" name="action" value="login">
                        <div class="form-group">
                            <label for="LoginUserName">帳號</label>
                            <input type="text" class="form-control" id="LoginUserName" name="account">
                            <span class="help-block">身分證(首字需大寫)</span>
                        </div>
                        <div class="form-group">
                            <label for="LoginUserPassword">密碼</label>
                            <input type="password" class="form-control" id="LoginUserPassword" name="password">
                            <span class="help-block">生日7碼(YYYMMDD)</span>
                        </div>
                        <div class="form-group">
                            <label>身分類別</label>
                            <select name="type" class="form-control">
                                <?php if( !isset($tmpl['loginadmin']) ): ?>
                                <option value="newbie">新生</option>
                                <option value="user">在校學生</option>
                                <?php else: ?>
                                <option value="admin">管理員</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php if($_E['loginrecaptcha']): ?>      
                        <div class="g-recaptcha" data-sitekey="6LcLIgYTAAAAAHfjWLqtHbUiWCfrhvHfvLjsPPXO"></div>
                        <?php endif;?>
                    </form>
                </div>
                <div class="modal-footer">
                    <small><span id="info"></span></small>
                    <button type="button" class="btn btn-default" id="loginsubmit" onclick="login()">登入</button>
                </div>
            </div>
        </div>
    </div>
    <!--LoginModal-->
<?php endif; ?>