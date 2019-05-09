<?php //TODO:检测权限 ?>
<?php if ($v['aiauth']): ?>
    <a href="#"  title="关闭注入"  class='btn btn-primary btn-small btn-ajax-ai' data-id="<?php echo $v['id'] ?>" data-ai="0">开启</a>
<?php else: ?>
    <a href="#" title="开启注入" class='btn btn-small btn-ajax-ai' data-id="<?php echo $v['id'] ?>" data-ai="1"> 开启</a>
<?php endif ?>