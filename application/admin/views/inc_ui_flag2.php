<?php //TODO:检测权限 ?>
<?php if ($v['flag2']): ?>
    <a href="#"  title="<?php echo lang('flag_remove') ?>"  class='btn btn-primary btn-small btn-ajax-flag2' data-id="<?php echo $v['id'] ?>" data-flag2="0">  <i class="fa fa-flag"></i> </a>
<?php else: ?>
    <a href="#" title="<?php echo lang('flag') ?>" class='btn btn-small btn-ajax-flag2' data-id="<?php echo $v['id'] ?>" data-flag2="1"> <i class="fa fa-flag"></i> </a>
<?php endif ?>
