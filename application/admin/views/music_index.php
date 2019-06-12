<div class="btn-group">
    <a href="<?php echo site_url('music/create') ?>" class='btn btn-primary'> <i class="fa fa-plus"></i>添加音乐</a>
</div>


<div class="clearfix"><p></p></div>
<div class="boxed">
    <div class="boxed-inner seamless">
        <table class="table table-striped table-hover select-list">
            <thead>
            <tr>
                <th class="width-small"><input id='selectbox-all' type="checkbox"></th>
                <th >编号</th>
                <th >曲名</th>
                <th >播放</th>
                <th >描述</th>
                <th >日期</th>
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
                    <td><?php echo $v['music']; ?></td>
                    <td><audio id="audio" controls="controls" loop="loop"  src="<?php echo $v['download_url'];?>"></audio></td>
                    <td> <?php echo $v['intro']; ?> </td>
                    <td> <?php echo date("Y-m-d H:i:s", $v['create_time']); ?> </td>
                    <td>
                        <div class="btn-group">
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
            url_del: "<?php echo site_url('music/delete'); ?>"
        };
        ui.btn_delete(article.url_del);
    });
</script>
