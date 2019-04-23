<div class="btn-group">
    <a href="<?php echo site_url('image/create') ?>" class='btn btn-primary'> <i class="fa fa-plus"></i>上传图片</a>
</div>
<div class="btn-group">
    <a href="<?php echo site_url('img_category/index') ?>" class='btn btn-info'> <i class="fa fa-plus"></i>分类管理</a>
</div>
<div class="clearfix"><p></p></div>
<div class="boxed">
    <div class="boxed-inner seamless">
        <table class="table table-striped table-hover select-list">
            <thead>
            <tr>
                <th class="width-small"><input id='selectbox-all' type="checkbox"></th>
                <th>编号</th>
                <th>分类</th>
                <th>图片</th>
                <th>备注</th>
                <th>上传时间</th>
                <th class="span1">操作</th>
            </tr>
            </thead>
            <tbody class="sort-list">
            <?php foreach ($list as $v): ?>
                <tr data-id="<?php echo $v['id'] ?>">
                    <td>
                        <input class="select-it" type="checkbox" value="<?php echo $v['id']; ?>">
                    </td>
                    <td><?php echo $v['id']; ?></td>
                    <td><?php echo $v['category']; ?></td>
                    <td><img src="<?php echo $v['url']; ?>" /></td>
                    <td><?php echo $v['remark']; ?></td>
                    <td> <?php echo date("Y-m-d H:i:s", $v['create_time']); ?> </td>
                    <td>
                        <div class="btn-group">
                            <a class='btn btn-small' href="<?php echo site_url($this->router->class . '/edit/' . $v['id']) ?>" title="<?php echo lang('edit') ?>"> <i class="fa fa-pencil"></i></a>
                            <a class='btn btn-danger btn-small btn-del' data-id="<?php echo $v['id'] ?>" href="#" title="<?php echo lang('del') ?>"> <i class="fa fa-times"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="btn-group">
    <a id='select-all' class='btn' href="#"> <i class=""></i> <?php echo lang('select_all') ?> </a>
    <a id='unselect-all' class='btn hide' href="#"> <i class=""></i> <?php echo lang('unselect') ?> </a>
    <a id="btn-del" class='btn btn-danger' href="#"> <i class="fa fa-times"></i> <?php echo lang('del') ?> </a>
</div>
<?php echo $pages; ?>
<script>
    require(['adminer/js/ui'], function (ui) {
        var article = {
            url_del: "<?php echo site_url('image/delete'); ?>"
        };
        ui.fancybox_img();
        ui.btn_delete(article.url_del);
    });
</script>
