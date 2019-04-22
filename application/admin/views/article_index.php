<div class="btn-group">
    <a href="<?php echo site_url('article/create') ?>" class='btn btn-primary'> <i class="fa fa-plus"></i>添加文章</a>
</div>
<div class="btn-group">
    <a href="<?php echo site_url('tag/index') ?>" class='btn btn-info'> <i class="fa fa-plus"></i>标签管理</a>
</div>

<div class="clearfix"><p></p></div>
<div class="boxed">
    <div class="boxed-inner seamless">
        <table class="table table-striped table-hover select-list">
            <thead>
            <tr>
                <th class="width-small"><input id='selectbox-all' type="checkbox"></th>
                <th>编号</th>
                <th>标题</th>
                <th>封面</th>
                <th>描述</th>
                <th>背景音乐</th>
                <th>时间</th>
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
                    <td><?php echo $v['title']; ?></td>
                    <td><img src="<?php echo $v['photo']; ?>" /></td>
                    <td><?php echo mb_substr(strip_tags($v['intro_left']), 0, 50) . '...'; ?></td>
                    <td><?php echo $v['music'] ? $v['music'] : '无'; ?></td>
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
            url_del: "<?php echo site_url('article/delete'); ?>"
        };
        ui.btn_delete(article.url_del);
    });
</script>
