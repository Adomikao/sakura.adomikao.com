<div class="btn-group">
    <a href="<?php echo site_url('tag/create') ?>" class='btn btn-primary'><i class="fa fa-plus"></i>添加标签</a>
</div>
<div class="clearfix"><p></p></div>

<div class="boxed">
    <div class="boxed-inner seamless">
        <table class="table table-striped table-hover select-list">
            <thead>
            <tr>
                <th class="width-small"><input id='selectbox-all' type="checkbox"></th>
                <th>标签名称</th>
                <th>标签备注</th>
                <th>更新时间</th>
                <th class="span1">操作</th>
            </tr>
            </thead>
            <tbody class="sort-list">
            <?php foreach ($list as $v): ?>
                <tr data-id="<?php echo $v['id'] ?>">
                    <td><input class="select-it" type="checkbox" value="<?php echo $v['id']; ?>"></td>
                    <td><?php echo $v['title'] ?></td>
                    <td><?php echo $v['remark'] ?></td>
                    <td><?php echo date("Y-m-d H:i:s", $v['create_time']); ?></td>
                    <td>
                        <div class="btn-group">
                            <a class='btn btn-small' href=" <?php echo site_url($this->router->class . '/edit/' . $v['id']) ?>" title="<?php echo lang('edit') ?>"><i class="fa fa-pencil"></i></a>
                            <a class='btn btn-danger btn-small btn-del' data-id="<?php echo $v['id'] ?>" href="#" title="<?php echo lang('del') ?>"><i class="fa fa-times"></i></a>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<?php echo $pages; ?>

<script>
    require(['adminer/js/ui'], function (ui) {
        var article = {
            url_del: "<?php echo site_url('tag/delete'); ?>"
        };
        ui.btn_delete(article.url_del); //删除
    });
</script>
