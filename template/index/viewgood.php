<?php
if(!defined('IN_TEMPLATE'))
{
    exit('Access denied');
}
?>
<?php $data = $tmpl['data'] ?>
<script>$('.carousel').carousel();</script>
<div id="fb-root"></div>
<!--<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/zh_TW/sdk.js#xfbml=1&version=v2.3&appId=990377864313747";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>-->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-offset-2 col-md-8 trans_form_mh300">
            <center>
                <h3><?=$data['name']?></h3>
                <div class="col-md-6">
                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel" style='height:400px;'>
                    <!-- Indicators -->
                        <ol class="carousel-indicators">
                            <?php $imgnum = count($tmpl['img']); ?>
                            <?php for($i=0;$i<$imgnum;++$i){ ?>
                                <?php if($i==0): ?>
                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                <?php else:?>
                                <li data-target="#carousel-example-generic" data-slide-to="<?=$i?>"></li>
                                <?php endif; ?>
                            <?php }?>
                        </ol>

                        <!-- Wrapper for slides -->
                        <div class="carousel-inner" role="listbox" style="background-color:gray;">
                            <?php for($i=0;$i<$imgnum;++$i){ ?>
                                <?php $img = $tmpl['img'][$i]; ?>
                                <?php if($i==0): ?>
                            <div class="item active">
                                <?php else:?>
                            <div class="item">
                                <?php endif; ?>
                                <img src="<?=$img['url']?>" alt="<?=$i?>" style = "height:400px;width:auto;overflow:hidden;">
                                <div class="carousel-caption">
                                    <h3>測試用圖片</h3>
                                    <p>test</p>
                                </div>
                            </div>
                            <?php }?>
                        </div>
                        
                        <!-- Controls -->
                        <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                </div>
                <div class="col-md-6">
                    <table class="table table-hover">
                        <tbody>
                            <tr>
                                <td>提供廠商</td>
                                <td>DATA NOT SUPPORT</td>
                            </tr>
                            <tr>
                                <td>售價/件</td>
                                <td><?=$data['price']?></td>
                            </tr>
                        </tbody>
                    </table>
                    <h4>商品描述</h4>
                    <div class="col-md-12" style="border:#FFFFFF 2px inset;">
                        
                        <span class="text-left">
                            <?=$data['description']?>
                        </span>
                    </div>
                </div>
                <div class="col-md-12">
                    
                </div>
                <!--<div class="fb-comments" data-href="<?=$_E['SITEROOT']?>/index.php?page=viewgood&gid=<?=$data['gid']?>" data-numposts="5" data-colorscheme="light"></div>-->
            </center>
        </div>
    </div>
</div>