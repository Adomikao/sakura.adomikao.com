<!DOCTYPE html>
<head>
<?php include_once VIEWPATH . 'inc/head.php'; ?>
<?php
    echo static_file('css/me.css');
?>
<link rel="stylesheet" href="//at.alicdn.com/t/font_743220_bwms5wr4z36.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_676531_f9yg4moqy9j2a9k9.css">
<link rel="stylesheet" href="//at.alicdn.com/t/font_761408_oep14xapnf.css">
<style>
html, body {
    position: relative;
    overflow: hidden;
    height: 100vh;
}
</style>
</head>

<body>
<?php include_once VIEWPATH . 'inc/sakura.php'; ?>
<?php if (!empty($music)):?>
<?php include_once VIEWPATH . 'inc/music.php';?>
<?php endif;?>
	<!-- PC -->
    <div class="neinfo-wrap bb-bookblock" id="bb-bookblock">

        <div class="bb-item first-item">
            <div class="part part-left">
                <h3>
                    <a href="<?php echo site_url(''); ?> " class="back"><?php echo mb_strtoupper($nickname);?></a>
                    <span class="share iconfont icon-tubiaozhizuomoban">
                        <div class="bdsharebuttonbox">
                            <a href="#weiboShare" class="bds_tsina iconfot icon-weibo-copy" style="color: #D81E06" onclick="window.location.href='<?php echo $weibo_share;?>'" title="分享到新浪微博"></a>
                            <a href="#wechatShare" class="bds_weixin iconfot icon-weixin-copy tc" style="color: #09BB07" title="分享到微信"></a>
                            <a href="#qqShare" class="bds_sqq iconfot icon-qq-copy" style="color: #26ABD9" onclick="window.location.href='<?php echo $qq_share;?>'" title="分享到QQ好友"></a>
                        </div>
                    </span>
                </h3>
                <table width="100%">
                    <tr class="title">
                        <th colspan="2"><?php echo $title ;?></th>
                    </tr>
                    <tr class="info">
                        <td valign="top">
                            <?php echo $intro_left; ?>
                        </td>
                        <td valign="top">
                            <p><?php echo $intro_right; ?></p>
                        </td>
                    </tr>
                </table>
                <div class="number">1</div>
            </div>
            <?php $j = 0;?>
            <div class="part part-image">
                <div class="in">
                    <?php if (in_array(2,$page)):?>
                    	<div class="info"><?php echo $pageText[2];?></div>
                    <?php else:?>
                        <div class="imgbox" data-num="0">
                            <img src="<?php echo $img[0] ?>">
                        </div>
                        <?php $j++ ;?>
                        <div class="imgbox" data-num="1">
                            <img src="<?php echo $img[1]; ?>">
                        </div>
                        <?php $j++ ;?>
                    <?php endif;?>
                </div>
                <div class="number">2</div>
            </div>
        </div>
        <?php $i = 1;?>
        <?php while ($i < ceil($totalPage / 2)):?>
        <div class="bb-item">
            <div class="part part-image">
                <div class="in">
                    <?php if (in_array(2*$i+1,$page)):?>
                        <div class="info"><?php echo $pageText[2*$i+1];?></div>
                    <?php else:?>
                    <div class="imgbox" data-num="<?php echo $j;?> ">
                        <img src="<?php echo $img[$j]; ?>">
                    </div>
                        <?php $j++;?>
                    <?php if ($j<count($img)):?>
                    <div class="imgbox" data-num="<?php echo $j;?>">
                        <img src="<?php echo $img[$j]; ?>">
                    </div>
                        <?php $j++;?>
                    <?php endif;?>
                    <?php endif;?>
                </div>
                <div class="number"><?php echo 2*$i+1;?></div>
            </div>
            <div class="part part-image">
                <div class="in">
                    <?php if (in_array(2*$i+2,$page)):?>
                    	<div class="info"><?php echo $pageText[2*$i+2];?></div>
                    <?php elseif (($totalPage % 2 == 1) && ((2*$i+2) == ($totalPage + 1))):?>
                        <a href="<?php echo site_url('me/aimer/'.$id); ?> " class="back iconfont icon-fanhui">返回首页</a>
                    <?php else:?>
                    <div class="imgbox" data-num="<?php echo $j;?>">
                        <img src="<?php echo $img[$j]; ?>">
                    </div>
                        <?php $j++;?>
                    <?php if ($j<count($img)):?>
                    <div class="imgbox" data-num="<?php echo $j;?>">
                        <img src="<?php echo $img[$j]; ?>">
                    </div>
                            <?php $j++;?>
                        <?php endif;?>
                    <?php endif;?>
                </div>
                <div class="number"><?php echo 2*$i+2;?></div>
            </div>
        </div>
        <?php $i++;?>
        <?php endwhile;?>
        <div class="btn prev iconfont icon-allLeft" id="bb-nav-prev"></div>
        <div class="btn next iconfont icon-shuangyou" id="bb-nav-next"></div>
    </div>
    <!-- 微信登录弹窗 -->
    <div class="popup" id="popup">
    <div class="top_nav" id='top_nav'>
        <span>分享到微信朋友圈账号</span>
        <a class="guanbi" style="color: black">×</a>
    </div>
    <div class="min">
        <div align="center"><img src='<?php echo $wechat_share;?>' width="185" height="185"/>
        </div>
        <div class="bd_weixin_popup_foot"
             style="font-size: 12px;text-align: left;line-height: 22px;color: #666;padding-top:15px;">
            打开微信，点击底部的“发现”，<br>使用“扫一扫”即可将网页分享至朋友圈。
        </div>

    </div>
    </div>
    <!-- M -->
    <div class="m-wrap">
    	<h2><?php echo $title;?></h2>
        <div class="time">
            <p><?php echo date('Y:m:d',$create_time) ;?></p>
        </div>
    	<div class="info">
    		<p><?php echo $intro_left; ?></p>
    		<br>
    		<p><?php echo $intro_right; ?></p>
            <br>
            <?php $j = 2;$i=0;?>
            <?php while ($j<=$totalPage):?>
            <?php if (in_array($j,$page)):?>
            <?php echo $pageText[$j];$j++;?>
            <?php else:?>
            <img src="<?php echo $img[$i];$i++ ?> " alt="">
                <?php if ($i<count($img)):?>
                <img src="<?php echo $img[$i]; $i++?> " alt="">
                <?php endif;?>
                <?php $j++;?>
            <?php endif;?>
            <?php endwhile;?>
    	</div>
    </div>
    <div class="out-image">
        <div class="loader white"></div>
        <a href="javascript:;" class="close iconfont icon-close"></a>
        <div class="scroll">
            <ul>
                <?php foreach ($img as $v):?>
                <li><a href="<?php echo $v; ?> "target="_blank"><img src="<?php echo $v;?>" alt=""></a></li>
                <?php endforeach;?>

            </ul>
        </div>
        <div class="btn prev iconfont icon-left"></div>
        <div class="btn next iconfont icon-right"></div>
    </div>
<?php
    echo static_file('js/bookblock/bookblock.css');
    echo static_file('js/bookblock/modernizr.custom.js');
    echo static_file('js/bookblock/jquery.bookblock.js');
?>
<script>
$(function(){
    var Page = (function() {
        var config = {
                $bookBlock : $( '#bb-bookblock' ),
                $navNext : $( '#bb-nav-next' ),
                $navPrev : $( '#bb-nav-prev' )
            },
            init = function() {
                config.$bookBlock.bookblock( {
                    speed : 1000,
                    shadowSides : 0.8,
                    shadowFlip : 0.4,
                    onBeforeFlip: function( page ) {
                    	if(page == 1){
                    		$("#bb-nav-prev").hide()
                    	}
                    	if(page == $(".bb-item").length - 2){
                    		$("#bb-nav-next").hide()
                    	}
                    }
                } );
                initEvents();
            },
            initEvents = function() {

                var $slides = config.$bookBlock.children();

                // add navigation events
                config.$navNext.on( 'click touchstart', function() {
                    config.$bookBlock.bookblock( 'next' );
                    $("#bb-nav-prev").show();
                    return false;
                } );

                config.$navPrev.on( 'click touchstart', function() {
                    config.$bookBlock.bookblock( 'prev' );
                    $("#bb-nav-next").show();
                    return false;
                } );

                // add swipe events
                $slides.on( {
                    'swipeleft' : function( event ) {
                        config.$bookBlock.bookblock( 'next' );
                        return false;
                    },
                    'swiperight' : function( event ) {
                        config.$bookBlock.bookblock( 'prev' );
                        return false;
                    }
                } );

                // add keyboard events
                $( document ).keydown( function(e) {
                    var keyCode = e.keyCode || e.which,
                        arrow = {
                            left : 37,
                            up : 38,
                            right : 39,
                            down : 40
                        };

                    switch (keyCode) {
                        case arrow.left:
                            config.$bookBlock.bookblock( 'prev' );
                    		$("#bb-nav-next").show();
                            break;
                        case arrow.right:
                            config.$bookBlock.bookblock( 'next' );
                    		$("#bb-nav-prev").show();
                            break;
                    }
                } );
            };
            return { init : init };
        })();

    Page.init();

    $(".part.part-left h3 .share").click(function(){
        if(!$(this).hasClass('show')){
            $(this).addClass('show')
        }else{
            $(this).removeClass('show')
        }
    })

    var imgA = [],
        $imgboxWidth = $(".imgbox").width(),
        $imgboxHeight = $(".imgbox").height()
    for (var i = 0; i < $(".imgbox").length; i++) {
        var img = new Image();
        img.src = $(".imgbox").eq(i).find('img').attr('src');
        imgA[i] = new Array();
        imgA[i][0] = img.width
        imgA[i][1] = img.height
    };

    $(".imgbox").each(function(){
        if($imgboxWidth / $imgboxHeight < imgA[$(this).index()][0] / imgA[$(this).index()][1]){
            $(this).find('img').css({
                width: '100%',
                marginTop: ($imgboxHeight - $imgboxWidth * imgA[$(this).index()][1] / imgA[$(this).index()][0] ) / 2
            })
        }else{
            $(this).find('img').height('100%')
        }
    })
    $(".imgbox").click(function () {
        var n = $(this).data('num'),
            N = $(".imgbox").length,
            winST = $(window).scrollTop()

        // fullScreen()
        $("html, body").height('100vh').addClass('ovh')
        $(".creation-wrap").css('top', -winST)
        $(".out-image").stop().fadeIn(600)
        $(".out-image .number .single").html(n + 1)
        $(".out-image .number .total").html(N)

        var winR = $(window).width() * .75 / $(window).height(),
            numb = 0,
            imgR = [],
            $li = $(".out-image .scroll li"),
            $prev = $(".out-image .prev"),
            $next = $(".out-image .next")

        // 加载当前图
        var imgLi = new Image();
            imgLi.src = $li.eq(n).find('img').attr('src')
        if(imgLi.complete){ // 已加载
            if (winR > imgLi.width / imgLi.height) {
                var imgWidth = imgLi.width / imgLi.height * $(window).height()
                if (imgLi.width < $(window).width() * .75 && imgLi.height < $(window).height()) {
                    $li.eq(n).find('img').css({
                        left: '50%',
                        top: '50%',
                        marginTop: -imgLi.height / 2,
                        marginLeft: -imgLi.width / 2,
                        opacity: 1
                    })
                } else {
                    $li.eq(n).find('img').height('100%').css({
                        left: ($(window).width() * .75 - imgWidth) / 2,
                        opacity: 1
                    })
                }
            } else {
                var imgHeight = $(window).width() * .75 * imgLi.height / imgLi.width
                if (imgLi.width < $(window).width() * .75 && imgLi.height < $(window).height()) {
                    $li.eq(n).find('img').css({
                        left: '50%',
                        top: '50%',
                        marginTop: -imgLi.height / 2,
                        marginLeft: -imgLi.width / 2,
                        opacity: 1
                    })
                } else {
                    $li.eq(n).find('img').width('100%').css({
                        top: ($(window).height() - imgHeight) / 2,
                        opacity: 1
                    })
                }
            }
            $('.out-image .scroll').stop().fadeIn(600)
            $li.eq(n).addClass('left')
        }else {
            imgLi.onload = function () {
                if (winR > imgLi.width / imgLi.height) {
                    var imgWidth = imgLi.width / imgLi.height * $(window).height()
                    if (imgLi.width < $(window).width() * .75 && imgLi.height < $(window).height()) {
                        $li.eq(n).find('img').css({
                            left: '50%',
                            top: '50%',
                            marginTop: -imgLi.height / 2,
                            marginLeft: -imgLi.width / 2,
                            opacity: 1
                        })
                    } else {
                        $li.eq(n).find('img').height('100%').css({
                            left: ($(window).width() * .75 - imgWidth) / 2,
                            opacity: 1
                        })
                    }
                } else {
                    var imgHeight = $(window).width() * .75 * imgLi.height / imgLi.width
                    if (imgLi.width < $(window).width() * .75 && imgLi.height < $(window).height()) {
                        $li.eq(n).find('img').css({
                            left: '50%',
                            top: '50%',
                            marginTop: -imgLi.height / 2,
                            marginLeft: -imgLi.width / 2,
                            opacity: 1
                        })
                    } else {
                        $li.eq(n).find('img').width('100%').css({
                            top: ($(window).height() - imgHeight) / 2,
                            opacity: 1
                        })
                    }
                }
                $('.out-image .scroll').stop().fadeIn(600)
                $li.eq(n).addClass('left')
            }
        }
        // 其余图片
        $li.each(function () {
            var img = new Image(),
                $this = $(this)

            img.src = $this.find('img').attr('src')
            img.onload = function () {
                if (winR > img.width / img.height) {
                    var imgWidth = img.width / img.height * $(window).height()
                    if (img.width < $(window).width() * .75 && img.height < $(window).height()) {
                        $this.find('img').css({
                            left: '50%',
                            top: '50%',
                            marginTop: -img.height / 2,
                            marginLeft: -img.width / 2,
                            opacity: 1
                        })
                    } else {
                        $this.find('img').height('100%').css({
                            left: ($(window).width() * .75 - imgWidth) / 2,
                            opacity: 1
                        })
                    }
                } else {
                    var imgHeight = $(window).width() * .75 * img.height / img.width
                    if (img.width < $(window).width() * .75 && img.height < $(window).height()) {
                        $this.find('img').css({
                            left: '50%',
                            top: '50%',
                            marginTop: -img.height / 2,
                            marginLeft: -img.width / 2,
                            opacity: 1
                        })
                    } else {
                        $this.find('img').width('100%').css({
                            top: ($(window).height() - imgHeight) / 2,
                            opacity: 1
                        })
                    }
                }
                numb++
                if (numb == N) {
                    $('.out-image .loader.white').hide()
                    // $('.out-image .scroll').stop().fadeIn(600)
                    // $li.eq(n).addClass('left')
                    // numb = n
                }
            }
        })
        $prev.click(function () {
            n--
            if (n < 0) {
                n = N - 1
            }
            $(".out-image .number .single").html(n + 1)
            $li.removeClass('left').eq(n).addClass('left')
        })
        $next.click(function () {
            n++
            if (n >= N) {
                n = 0
            }
            $(".out-image .number .single").html(n + 1)
            $li.removeClass('left').eq(n).addClass('left')
        })

        // 关闭
        $(document).on('click', ".out-image a.close", function (e) {
            fullExit(winST)
        })
    })

    // 全屏/退出全屏
    function fullScreen() {
        var element = document.documentElement; // 若要全屏页面中div，var element= document.getElementById("divID");
        //IE 10及以下ActiveXObject
        if (window.ActiveXObject) {
            var WsShell = new ActiveXObject('WScript.Shell')
            WsShell.SendKeys('{F11}');
        }
        //HTML W3C 提议
        else if (element.requestFullScreen) {
            element.requestFullScreen();
        }
        //IE11
        else if (element.msRequestFullscreen) {
            element.msRequestFullscreen();
        }
        // Webkit (works in Safari5.1 and Chrome 15)
        else if (element.webkitRequestFullScreen) {
            element.webkitRequestFullScreen();
        }
        // Firefox (works in nightly)
        else if (element.mozRequestFullScreen) {
            element.mozRequestFullScreen();
        }
    }

    function fullExit(winst) {
        var element = document.documentElement; // 若要全屏页面中div，var element= document.getElementById("divID");
        //IE ActiveXObject
        if (window.ActiveXObject) {
            var WsShell = new ActiveXObject('WScript.Shell')
            WsShell.SendKeys('{F11}');
        }
        //HTML5 W3C 提议
        else if (element.requestFullScreen) {
            document.exitFullscreen();
        }
        //IE 11
        else if (element.msRequestFullscreen) {
            document.msExitFullscreen();
        }
        // Webkit (works in Safari5.1 and Chrome 15)
        else if (element.webkitRequestFullScreen) {
            document.webkitCancelFullScreen();
        }
        // Firefox (works in nightly)
        else if (element.mozRequestFullScreen) {
            document.mozCancelFullScreen();
        }

        $("html, body").attr('style', '').removeClass('ovh').stop().animate({'scrollTop': winst}, 10)
        $(".creation-wrap").attr('style', '')
        $(".out-image").stop().fadeOut(600)
        $(".out-image .scroll li").removeClass('left')
    }

    window.onresize = function(){
        $(".imgbox").each(function(){
            $(this).find('img').attr('style', '')
            if($imgboxWidth / $imgboxHeight < imgA[$(this).index()][0] / imgA[$(this).index()][1]){
                $(this).find('img').css({
                    width: '100%',
                    marginTop: ($imgboxHeight - $imgboxWidth * imgA[$(this).index()][1] / imgA[$(this).index()][0] ) / 2
                })
            }else{
                $(this).find('img').height('100%')
            }
        })
        $(".out-image .scroll li").each(function () {
            var winR = $(window).width() * .75 / $(window).height(),
                $image = $(this).find('img')
            $image.attr('style', '')

            var img = new Image(),
                $this = $(this);

            img.src = $this.find('img').attr('src')
            if (winR > img.width / img.height) {
                var imgWidth = img.width / img.height * $(window).height()
                if (img.width < $(window).width() * .75 && img.height < $(window).height()) {
                    $this.find('img').css({
                        left: '50%',
                        top: '50%',
                        marginTop: -img.height / 2,
                        marginLeft: -img.width / 2,
                        opacity: 1
                    })
                } else {
                    $this.find('img').height('100%').css({
                        left: ($(window).width() * .75 - imgWidth) / 2,
                        opacity: 1
                    })
                }
            } else {
                var imgHeight = $(window).width() * .75 * img.height / img.width
                if (img.width < $(window).width() * .75 && img.height < $(window).height()) {
                    $this.find('img').css({
                        left: '50%',
                        top: '50%',
                        marginTop: -img.height / 2,
                        marginLeft: -img.width / 2,
                        opacity: 1
                    })
                } else {
                    $this.find('img').width('100%').css({
                        top: ($(window).height() - imgHeight) / 2,
                        opacity: 1
                    })
                }
            }
        })
    };
})
</script>
<script src="https://adomikao.com/wp-content/themes/sparkling/inc/js/customs.min.js" async="" defer=""></script>
<script type="text/javascript">
    //窗口效果
    //点击登录class为tc 显示
    $(".tc").click(function () {
        $("#popup").show();//查找ID为popup的DIV show()显示#gray
        tc_center();
    });
    //点击关闭按钮
    $("a.guanbi").click(function () {
        $("#popup").hide();//查找ID为popup的DIV hide()隐藏
    })

    //窗口水平居中
    $(window).resize(function () {
        tc_center();
    });

    function tc_center() {
        var _top = ($(window).height() - $(".popup").height()) / 2;
        var _left = ($(window).width() - $(".popup").width()) / 2;
        $(".popup").css({top: _top, left: _left});
    }
</script>
<script>
        var c = document.getElementById("c");
        var ctx = c.getContext("2d");
        var cw = c.width = window.innerWidth;
        var ch = c.height = window.innerHeight;
        var cx = cw / 2,
            cy = ch / 2;
        var rad = Math.PI / 180;
        var A = 360 / 5;
        var R = 150;
        var delta = 20;
        var howMany = 50;

        var flowersRy = [];
        var colors = ["hsl(2,70%,90%)", "hsl(2,80%,90%)", "hsl(2,90%,90%)", "hsl(2,100%,90%)", "hsl(2,70%,85%)", "hsl(2,80%,85%)", "hsl(2,90%,85%)", "hsl(2,100%,85%)", "hsl(2,70%,95%)", "hsl(2,80%,95%)", "hsl(2,90%,95%)", "hsl(2,100%,95%)", "hsl(2,100%,100%)"];

        function flower() {
            var maxW = cw > 1200 ? 1250 : cw;
            this.pm = Math.random() < 0.5 ? -1 : 1; //plus or minus
            this.cx = ~~(Math.random() * maxW) + 1;
            this.cy = ~~(Math.random() * ch / 2) + 1;
            this.R = randomIntFromInterval(20, 50);
            this.color = colors[~~(Math.random() * colors.length)];
            this.delta = ~~(Math.random() * 90) + 1;
            this.pm = Math.random() < 0.5 ? -1 : 1; //plus or minus
            this.speedX = 2 + Math.random();
            this.speedY = 1.01 + Math.random() / 50;
            this.drift = this.pm + this.speedX;
            this.fall = this.speedY;
        }

        function init() {

            for (var i = 0; i < howMany; i++) {
                createFlower();

            }
            requestId = window.requestAnimationFrame(updateFlowers);
        }

        function updateFlowers() {
            ctx.clearRect(0, 0, cw, ch);

            for (var i = 0; i < flowersRy.length; i++) {
                if (i % 2 == 0 || i % 3 == 0 || flowersRy[i].cy > 200 || cx < 100) {
                    flowersRy[i].cx += flowersRy[i].drift;
                    flowersRy[i].cy *= flowersRy[i].fall;
                    flowersRy[i].delta += 1;
                } else {
                    var pm = Math.random() < 0.5 ? -1 : 1;
                    flowersRy[i].cx += pm / 5;
                    //flowersRy[i].cy += pm/10;
                    flowersRy[i].delta += pm / 10;
                }
                drawFlower(flowersRy[i].cx, flowersRy[i].cy, flowersRy[i].R, flowersRy[i].color, flowersRy[i].delta);
            }

            requestId = window.requestAnimationFrame(updateFlowers);
        }

        function createFlower() {
            var l = flowersRy.length
            flowersRy[l] = new flower();
            drawFlower(flowersRy[l].cx, flowersRy[l].cy, flowersRy[l].R, flowersRy[l].color, flowersRy[l].delta);
        }

        function drawFlower(cx, cy, R, color, delta) {

            ctx.fillStyle = color
            var R1 = R * 1.3;
            for (var a = 0; a < 5; a++) {

                drawPetal(cx, cy, a, R, R1, color, delta)
                drawAnthers(cx, cy, a, R, R1, delta);
            }
        }

        function drawAnthers(cx, cy, a, R, R1, delta) {
            ctx.save();
            ctx.strokeStyle = "#fff";
            ctx.shadowBlur = 5;
            ctx.shadowOffsetX = 1;
            ctx.shadowOffsetY = 1;
            ctx.shadowColor = "#333";

            var ax0 = cx + R / 3 * Math.cos((a * A + 2 * A / 6 + delta) * rad);
            var ay0 = cy + R / 3 * Math.sin((a * A + 2 * A / 6 + delta) * rad);
            var ax1 = cx + R / 2 * Math.cos((a * A + 3 * A / 6 + delta) * rad);
            var ay1 = cy + R / 2 * Math.sin((a * A + 3 * A / 6 + delta) * rad);
            var ax2 = cx + R / 3 * Math.cos((a * A + 4 * A / 6 + delta) * rad);
            var ay2 = cy + R / 3 * Math.sin((a * A + 4 * A / 6 + delta) * rad);

            if (R > 40) {
                var ary = [{
                    x: ax0,
                    y: ay0
                }, {
                    x: ax1,
                    y: ay1
                }, {
                    x: ax2,
                    y: ay2
                }]; // anthers array
            } else {
                var ary = [{
                    x: ax1,
                    y: ay1
                }];
            }

            ctx.beginPath();
            for (var i = 0; i < ary.length; i++) {
                ctx.moveTo(cx, cy);
                ctx.lineTo(ary[i].x, ary[i].y);
                ctx.arc(ary[i].x, ary[i].y, 2, 0, 2 * Math.PI)
            }
            ctx.stroke();
            ctx.restore();
        }

        function drawPetal(cx, cy, a, R, R1, color, delta) {
            ctx.strokeStyle = "#d9d9d9";
            ctx.fillStyle = color;

            var x0 = cx + R * Math.cos((a * A + delta) * rad);
            var y0 = cy + R * Math.sin((a * A + delta) * rad);

            var x1 = cx + R1 * Math.cos((a * A + 2 * A / 6 + delta) * rad);
            var y1 = cy + R1 * Math.sin((a * A + 2 * A / 6 + delta) * rad);

            var x2 = cx + R * Math.cos((a * A + 3 * A / 6 + delta) * rad);
            var y2 = cy + R * Math.sin((a * A + 3 * A / 6 + delta) * rad);

            var x3 = cx + R1 * Math.cos((a * A + 4 * A / 6 + delta) * rad);
            var y3 = cy + R1 * Math.sin((a * A + 4 * A / 6 + delta) * rad);

            var x4 = cx + R * Math.cos((a * A + A + delta) * rad);
            var y4 = cy + R * Math.sin((a * A + A + delta) * rad);

            // petal
            ctx.beginPath();
            ctx.moveTo(cx, cy);
            ctx.quadraticCurveTo(x0, y0, x1, y1);
            ctx.lineTo(x2, y2);
            ctx.lineTo(x3, y3);
            ctx.quadraticCurveTo(x4, y4, cx, cy);
            ctx.fill();
            ctx.stroke();
        }

        function randomIntFromInterval(mn, mx) {
            return ~~(Math.random() * (mx - mn + 1) + mn);
        }

        window.addEventListener("load", init, false);
    </script>
</body>
</html>