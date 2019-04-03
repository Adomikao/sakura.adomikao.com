<!DOCTYPE html>
<head>
<?php include_once VIEWPATH . 'inc/head.php'; ?>
<?php
    echo static_file('css/me.css');
?>
<style>
.ne-wrap {
    box-sizing: border-box;
    min-height: 100vh;
}
</style>
</head>
    
<body>
    <!-- sakura -->
    <?php include_once VIEWPATH . 'inc/sakura.php'; ?>
    
    <div class="ne-wrap">
    	<div class="logo f-cb">
            <div class="tips fl"><?php echo $search;?></div>
            <!--<a href="https://qaq.adomikao.com"><img src="<?php echo static_file('img/me/logo.png'); ?> " width="190" height="60" alt="" class="fr"></a>-->
        </div>
    	<div class="nglist f-cb">
            <ul>
                <?php foreach ($nglist as $val):?>
                <li>
                    <a href="<?php echo site_url('me/aimer/'.$val['id']); ?> ">
                        <img src="<?php echo $val['pic']; ?> " width="100%" alt="" style="border-radius: 5px">
                        <p style="text-align: center "><?php echo $val['title']?></p>
                    </a>
                </li>
                <?php endforeach;?>
            </ul>
        </div>
    </div>
<script>
</script>
<script src="https://adomikao.com/wp-content/themes/sparkling/inc/js/customs.min.js" async="" defer=""></script>
</body>
</html>