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
                
                <ul class="nav navbar-nav navbar-right">
                    <?php if( $_G['usertype'] == 2 ): ?>
                    <li><a href="admin.php">管理</a></li>
                    <li><a href="api.php?action=logout">登出</a></li>
                    <?php else: ?>
                    <li><a href="#" data-toggle="modal" data-target="#LoginModal">登入</a></li>
                    <?php endif; ?>
                </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
    </nav>
    
    
    
<?php if( $_G['usertype'] == 2 ): ?>
<?php else: /*Not Login*/?>
    <!--LoginModal-->
    <!--<script src='https://www.google.com/recaptcha/api.js'></script>-->
    <script>
        function login()
        {
            $.post("api.php",
                $("#login_form").serialize(),
                function(res){
                    console.log(res);
                    //console.log($("#login_form").serialize());
                    if( res.status == 'SUCC' )
                    {
                        $('#info').css('color','Lime');
                        $('#info').html('Success! reload page');
                        setTimeout( function(){
                            $('#login_form').modal('hide');
                        },300);
                        setTimeout( function(){
                            location.reload();
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
                        <!--<div class="g-recaptcha" data-sitekey="6LcLIgYTAAAAAHfjWLqtHbUiWCfrhvHfvLjsPPXO"></div>-->
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