<?php if (ielt9()): ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><?php else: ?><!DOCTYPE HTML><?php endif ?>
<html lang="zh">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta http-equiv="Content-type" content="text/html; charset=utf-8"/>
    <meta http-equiv="content-language" content="zh-CN"/>
    <title> <?php echo $title . $this->config->item('title_suffix'); ?> </title>
    <meta name="copyright" content="2012"/>
    <link rel="shortcut icon" href="<?php echo IMG_URL; ?>icon.png" type="image/x-icon"/>
    <link rel="canonical" href="/"/>
    <meta name="author" content="余永健 | Adomikao-https://adomikao.com/"/>
    <link rel="shortcut icon" href="https://adomikao.com/wp-content/uploads/2016/08/cropped-snow_70.912386706949px_1196812_easyicon.net_-1.png" type="image/png">

    <meta name="robots" content="deny"/>
    <script type="text/javascript" charset="utf-8">
        //  初始化路径
        var STATIC_URL = "<?php echo STATIC_URL?>";
        var UPLOAD_URL = "<?php echo UPLOAD_URL?>";
        var ADMINER_URL = "<?php echo ADMINER_URL?>";
        var STATIC_VER = "<?php echo STATIC_V ?>";
    </script>
    <?php
    echo static_file('adminer/css/ui.css');
    echo static_file('adminer/css/my.css');
    echo static_file('require.js');
    echo static_file('require.config.js');
    ?>
</head>
<body>
<div id="body-main">
    <div class="container" id="body-main-login">
        <div class="boxed" id='login'>
            <?php
            if ($this->input->get('url')) {
                $after = '?url=' . $this->input->get('url');
                $sub_url = site_url('login') . $after;
            } else {
                $sub_url = site_url('login');
            }
            echo form_open($sub_url, array("class" => "form-horizontal", "id" => "frm-login"));
            ?>
            <div class="boxed-inner seamless">
                <h3 style="padding:20px 0 0 27px;"><i class="fa fa-leaf"></i> LOGIN </h3>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="fa fa-user"></i></span>
                        <input type="text" name="uname" value="<?php echo set_value('uname') ?>" id="uname"
                               placeholder="<?php echo lang('member') ?>" required="required">
                    </div>
                </div>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="fa fa-lock"></i></span>
                        <input type="password" name="pwd" id="pwd" placeholder="<?php echo lang('password') ?>"
                               required/>
                    </div>
                </div>

                <div class="control-group">
                    <label class="checkbox">
                        <input type="checkbox" name="remember" value="1" id="remember" class="select-it" <?php echo set_switch('remember', '1'); ?> >
                        <?php echo lang('remember') ?>
                    </label>
                </div>
            </div>
            <div class="boxed-footer">
                <input id='submit' type="submit" value="<?php echo lang('login') ?>" class="btn btn-primary">
                <a id="btn-lostpass" href="#" class="pull-right" style="padding-top:5px;"> <?php echo lang('password_lost') ?> </a>
            </div>
            </form>
            <p></p>
            <?php include_once 'inc_form_errors.php'; ?>
            <?php if (isset($msg)): ?>
                <p></p>
                <div class="alert <?php echo $status ? 'alert-success' : 'alert-error'; ?>">
                    <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i>
                    </button> <?php echo $msg; ?></div>
            <?php endif ?>
        </div>


        <div class="boxed" id="getpass">
            <div class="boxed-inner ">
                <h3><i class="fa fa-key"></i> <?php echo lang('password_get') ?></h3>
                <p>
                    <?php echo lang('password_get_helper') ?>
                </p>
                <div class="control-group">
                    <div class="input-prepend">
                        <span class="add-on"><i class="fa fa-envelope"></i></span>
                        <input type="text" name="email" value="" id="email" placeholder="email" required="required">
                    </div>
                </div>
            </div>
            <div class="boxed-footer" style='padding-left:20px;'>
                <a id="btn-getpass" href="#" class="add-on btn btn-success"> <i
                            class="fa fa-key"></i> <?php echo lang('password_get') ?> </a>
                <a id="btn-login" href="#" class="pull-right" style="padding-top:5px;"> <?php echo lang('login') ?> <i
                            class="fa fa-pied-piper-alt"></i> </a>
            </div>
            <p></p>
            <div id="pass-msg" class="alert alert-error hide">
                <button type="button" class="close" data-dismiss="alert"><i class="fa fa-times"></i></button>
                <div></div>
            </div>
        </div>


    </div>
    <div class='clear' id="footer-push"></div>
</div>

<div id="body-footer">
    <div class="container-fluid">

    </div>
</div>

<script type="text/javascript" charset="utf-8">
    require(['adminer/js/login'], function (l) {
        l({
            getpass: "<?php echo site_url('login/getpass'); ?>"
        });
    });
</script>

</body>
</html>
