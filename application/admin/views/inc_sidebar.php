<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<ul class="nav nav-list nav-sidebar">

    <li id="menu-welcome">
        <a href="<?php echo site_url('welcome') ?>">
            <i class="fa fa-home" title="<?php echo lang('index') ?></span>"></i>
            <span class="i-title"> <?php echo lang('index') ?></span>
            <div class="wp-menu-arrow">
                <div></div>
            </div>
        </a>
    </li>

    <?php if ($_SESSION['mid'] == 2): ?>
    <li class="js-sidebar-cog">
        <a href="<?php echo site_url('image') ?>">
            <i class="fa fa-file" title="<?php echo '图片管理' ?>"></i>
            <span class="i-title"><?php echo '图片管理' ?></span>
            <div class="wp-menu-arrow">
                <div></div>
            </div>
        </a>
    </li>
    <?php endif; ?>

    <?php if ($_SESSION['mid'] == 3): ?>
        <li class="js-sidebar-cog">
            <a href="<?php echo site_url('article') ?>">
                <i class="fa fa-file" title="<?php echo '文章管理' ?>"></i>
                <span class="i-title"><?php echo '文章管理' ?></span>
                <div class="wp-menu-arrow">
                    <div></div>
                </div>
            </a>
        </li>

        <li class="js-sidebar-cog">
            <a href="<?php echo site_url('music') ?>">
                <i class="fa fa-music" title="<?php echo '音乐管理' ?>"></i>
                <span class="i-title"><?php echo '音乐管理' ?></span>
                <div class="wp-menu-arrow">
                    <div></div>
                </div>
            </a>
        </li>

        <li class="js-sidebar-cog">
            <a href="<?php echo site_url('index') ?>">
                <i class="fa fa-cog" title="首页配置"></i>
                <span class="i-title">首页配置</span>
                <div class="wp-menu-arrow">
                    <div></div>
                </div>
            </a>
        </li>
    <?php endif; ?>

    <li class="js-sidebar-cog">
        <a href="<?php echo site_url('manager') ?>">
            <i class='fa fa-user' title="<?php echo lang('nav_manager') ?>"></i>
            <span class="i-title"><?php echo lang('nav_manager') ?></span>
            <div class="wp-menu-arrow">
                <div></div>
            </div>
        </a>
    </li>

    <li>
        <a href="<?php echo site_url('login/logout') ?>">
            <i class='fa fa-sign-out' title="<?php echo lang('logout') ?>"></i>
            <span class="i-title"> <?php echo lang('logout') ?></span>
            <div class="wp-menu-arrow">
                <div></div>
            </div>
        </a>
    </li>
</ul>

<script>
    require(['jquery', 'bootstrap'], function ($) {
        $('#sidebar a.dropdown-toggle').dropdown();
        <?php if (isset($this->cid)): ?>
        $("#c<?php echo $this->cid;?>").parents('li').addClass('active');
        <?php else: ?>
        $("#menu-<?php echo $this->router->class;?>").addClass('active');
        <?php endif; ?>

        $('#js-sidebar-cog').on('click', function (event) {
            event.preventDefault();
            console.log($(this).attr('data-hide'));
            if ($(this).attr('data-hide') == "1") {
                $(this).children('.js-sidebar-cog-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                $('.js-sidebar-cog').fadeIn(500).removeClass('hide');
                $(this).attr('data-hide', 0);
            } else {
                $(this).children('.js-sidebar-cog-icon').removeClass('fa-chevron-up').addClass('fa-chevron-down');
                $('.js-sidebar-cog').fadeOut(500);
                $(this).attr('data-hide', 1);
            }
        });

        // 焦点显示
        $('.js-sidebar-cog').each(function (i, e) {
            _this = $('#js-sidebar-cog');
            if ($(e).hasClass('active')) {
                _this.children('.js-sidebar-cog-icon').removeClass('fa-chevron-down').addClass('fa-chevron-up');
                $('.js-sidebar-cog').fadeIn(500).removeClass('hide');
                _this.attr('data-hide', 0);
            }
        });
    });
</script>
