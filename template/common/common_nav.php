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
                <a class="navbar-brand" href="index.php"><?=$_E['site']['name']?></a>
            </div>
            
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                
                <ul class="nav navbar-nav">
                    <?php if( $_G['usertype'] == 1 ): ?>
                    <li><a href="market.php">採購頁面</a></li>
                    <?php endif; ?>
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
    <script>
    $(function () {
        var Sys = {};
        var ua = navigator.userAgent.toLowerCase();
        var s;
        (s = ua.match(/rv:([\d.]+)\) like gecko/)) ? Sys.ie = s[1] :
        (s = ua.match(/msie ([\d.]+)/)) ? Sys.ie = s[1] :
        (s = ua.match(/firefox\/([\d.]+)/)) ? Sys.firefox = s[1] :
        (s = ua.match(/chrome\/([\d.]+)/)) ? Sys.chrome = s[1] :
        (s = ua.match(/opera.([\d.]+)/)) ? Sys.opera = s[1] :
        (s = ua.match(/version\/([\d.]+).*safari/)) ? Sys.safari = s[1] : 0;
        
        if (Sys.ie) $('#whydidyouuseie').show();
        /*if (Sys.firefox) $('span').text('Firefox: ' + Sys.firefox);
        if (Sys.chrome) $('span').text('Chrome: ' + Sys.chrome);
        if (Sys.opera) $('span').text('Opera: ' + Sys.opera);
        if (Sys.safari) $('span').text('Safari: ' + Sys.safari);*/
    });
    </script>

    <div class="alert alert-danger fade in" role="alert" id="whydidyouuseie" hidden>
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">×</span><span class="sr-only">Close</span></button>
        <strong>Oh My God !</strong>
        <ul>
            <li>還在用連美國國防部都拋棄的IE? 趕快換個瀏覽器吧</li>
        </ul>
    </div>
    
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
                        },300);
                        setTimeout( function(){
                            if( res.data == 1 )
                            {
                                location.href = 'market.php';
                            }
                            else
                            {
                                location.href = 'admin.php';
                            }                        
                        },500);
                    }
                    else
                    {
                        $('#info').css('color','Red');
                        $('#info').html(res.data);
                    }
                },"json");
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
                            <input type="text" class="form-control" id="LoginUserName" name="account" placeholder="學號">
                        </div>
                        <div class="form-group">
                            <label for="LoginUserPassword">密碼</label>
                            <input type="password" class="form-control" id="LoginUserPassword" name="password" placeholder="Password">
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