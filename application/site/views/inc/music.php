<style>
    #music #audio-btn{width: 35px;height: 35px; background-size: 100% 100%;position: fixed;  right: 3%;
        top: 3%; z-index: 19;}
    #music .on{background: url(<?php echo IMG_URL .'me/music_02.ico';?>) no-repeat 0 0;-webkit-animation: rotating 1.5s linear infinite;animation: rotating 1.5s linear infinite;}
    #music .off{background: url(<?php echo IMG_URL .'me/music_02.ico';?>) no-repeat 0 0;}
    @-webkit-keyframes rotating {
        from{
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        to{
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
    @keyframes rotating {
        from{
            -webkit-transform: rotate(0deg);
            -moz-transform: rotate(0deg);
            -ms-transform: rotate(0deg);
            -o-transform: rotate(0deg);
            transform: rotate(0deg);
        }
        to{
            -webkit-transform: rotate(360deg);
            -moz-transform: rotate(360deg);
            -ms-transform: rotate(360deg);
            -o-transform: rotate(360deg);
            transform: rotate(360deg);
        }
    }
</style>
<!--代码部分begin-->
<div id="music">

<!-- <img id="music" src="http://sakura.adomikao.cc/public/static/img/me/music_02.ico"> -->
<div id="audio-btn" class="on" onclick="music.changeClass(this,'media')">
        <!-- <audio  loop="loop" src="<?php echo UPLOAD_URL ."music/{$music}.mp3";?>" id="media" preload=""></audio> -->
        <audio  loop="loop" src="<?php echo GITEE_SAKURA_URL ."music/{$music}.mp3";?>" id="media" preload=""></audio>
    </div>

<script>
    document.getElementById('media').load();
    // document.getElementById('media').play();
    var music = {
        changeClass: function (target,id) {
            var className = $(target).attr('class');
            var ids = document.getElementById(id);
            (className == 'on')
                ? $(target).removeClass('on').addClass('off')
                : $(target).removeClass('off').addClass('on');
            (className == 'on')
                ? ids.pause()
                : ids.play();
        },
        play:function(){
            document.getElementById('media').play();
        }
    }
    music.play();
    <!--代码部分end-->

</script>

