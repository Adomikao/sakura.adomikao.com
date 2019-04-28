<?php if (!defined('BASEPATH')) exit('No direct script access allowed'); ?>

<div class="row-fluid">
    <div class="boxed span4">
        <div class="boxed-inner hg1">
            <h3><i class="fa fa-user-md"></i> <?php echo lang('user_status') ?></h3>
            <ul class="boxed-list">
                <li><?php echo lang('nickname') ?>： <?php echo $_SESSION['nickname']; ?> </li>
                <li><?php echo lang('manager_group') ?>： <?php echo $user_group; ?> </li>
                <li><?php echo lang('login_ip') ?>： <?php echo $_SESSION['login_ip']; ?> </li>
                <li><?php echo lang('last_activity') ?>： <?php echo date('Y-m-d H:i:s', $_SESSION['login_time']) ?></li>
                <?php if ($this->input->cookie('_rember')): ?>
                    <li class="text-success"><?php printf(lang('rember_hours'), $this->mcfg->get('adminer', 'rember_hours')); ?></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
    <div class="boxed span4">
        <div class="boxed-inner hg1">
            <h3><i class="fa fa-shield"></i> <?php echo lang('server_env') ?></h3>
            <ul class="boxed-list">
                <?php
                foreach ($env as $e => $v) {
                    $li = $v['enable'] ? '<li class="text-success">' : '<li class="text-error">';
                    $enable = $v['enable'] ? " <span class='badge badge-success'> " . $v['enable'] . "</span>" : "<span class='badge badge-important'> error </span>";
                    printf("%s %s : %s </li>", $li, $v['title'], $enable);
                } ?>
            </ul>
        </div>
    </div>
</div>
