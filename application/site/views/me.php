<!DOCTYPE html>
<head>
<?php include_once VIEWPATH . 'inc/head.php'; ?>
<?php
    echo static_file('css/me.css');
?>
</head>
    
<body>
    <!-- sakura -->
    <?php include_once VIEWPATH . 'inc/sakura.php'; ?>
    <div class="ne-wrap">
        <div><H1 style="text-align: center">その年に一緒に見たアニメ | <a href="/">Sakura</a></H1></div>
    	<!--<div class="logo f-cb"><a href="https://adomikao.com"><img src="<?php echo $index['logo']; ?> " width="190" height="60" alt="" class="fr"></a></div>-->
    	<div class="ban">
    		<img src="<?php echo $index['cover']; ?> " width="100%" alt="" style="border: 3px solid rgb(255,230,229); border-radius:5px">
    	</div>
    	<div class="list f-cb">
    		<div class="box">
    			<h3>Tags</h3>
                <?php foreach ($tagName as $v):?>
    			<a href="<?php echo site_url('me/tag/'.$v['title']); ?> " ><?php echo $v['title'];?></a>
                <?php endforeach;?>
    		</div>
    		<div class="box">
    			<h3>New</h3>
                <?php foreach ($article as $k => $v):?>
    			<a href="<?php echo site_url('me/aimer/'.$v['id']); ?> " ><?php echo $v['title'];?></a>
                <?php endforeach;?>
    		</div>
    		<div class="box">
    			<h3>Archives</h3>
                <?php foreach ($date as $month=>$article):?>
    			<a href="<?php echo site_url('me/date/'.$article[0]['months']); ?> " ><?php echo $month;?></a>
                <?php endforeach;?>
    		</div>
    		<div class="box">
    			<h3>Links</h3>
                <?php if (!empty($index['link'])): ?>
                    <?php foreach ($index['link'] as $value): ?>
                        <a href="<?php echo $value['url'] ?>" target="_blank"><?php echo $value['name'] ?></a>
                    <?php endforeach;?>
                <?php endif;?>
    		</div>
    	
    	</div>
    </div>
<script>
</script>
<script src="https://adomikao.com/wp-content/themes/sparkling/inc/js/customs.min.js" async="" defer=""></script>
<script>(function(T,h,i,n,k,P,a,g,e){g=function(){P=h.createElement(i);a=h.getElementsByTagName(i)[0];P.src=k;P.charset="utf-8";P.async=1;a.parentNode.insertBefore(P,a)};T["ThinkPageWeatherWidgetObject"]=n;T[n]||(T[n]=function(){(T[n].q=T[n].q||[]).push(arguments)});T[n].l=+new Date();if(T.attachEvent){T.attachEvent("onload",g)}else{T.addEventListener("load",g,false)}}(window,document,"script","tpwidget","//widget.seniverse.com/widget/chameleon.js"))</script>
<script>tpwidget("init", {
    "flavor": "bubble",
    "location": "WTMKQ069CCJ7",
    "geolocation": "enabled",
    "position": "top-left",
    "margin": "10px 10px",
    "language": "zh-chs",
    "unit": "c",
    "theme": "chameleon",
    "uid": "U18B0DF804",
    "hash": "78d059be9e9137cea99bf6381d783124"
});
tpwidget("show");</script>
</body>
</html>