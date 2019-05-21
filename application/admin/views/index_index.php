<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
    <h3><i class="fa fa-pencil"></i> <span class="badge badge-success pull-right">首页配置</span> <?php echo lang('add') ?></h3>
    <?php echo form_open(current_url(), array("class" => "form-horizontal", "id" => "frm-create")); ?>
    <div class="boxed-inner seamless">
        <div class="control-group">
            <label class="control-label" for="title">标题</label>
            <div class="controls">
                <input type="text" id="title" name="title" value="<?php echo $it['title'] ?>">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">标签</label>
            <div class="controls">
                <?php
                $tag = $this->db->where('admin_id', $_SESSION['mid'])->get('tag')->result_array();
                ?>
                <?php foreach ($tag as $val): ?>
                    <input type="checkbox" name="tag[]" value="<?php echo $val['id']; ?>"<?php echo in_array($val['id'], explode(',', $it['tag'])) ? 'checked' : '' ?> /><?php echo $val['title']; ?>&nbsp;&nbsp;
                <?php endforeach; ?>
            </div>
        </div>

        <div class="control-group">
            <label for="logo" class="control-label">logo</label>
            <div class="controls">
                <div class="btn-group">
                    <span class="btn btn-success">
                        <i class="fa fa-upload"></i>
                        <span>上传logo</span>
                        <input class="fileupload" type="file" accept="" multiple="">
                    </span>
                    <input type="hidden" name="logo" class="form-upload" data-more="0" value="<?php echo $it['logo'] ?>">
                </div>
            </div>
        </div>
        <div id="js-logo-show" class="js-img-list-f"></div>
        <div class="clear"></div>

        <div class="control-group">
            <label for="cover" class="control-label">封面</label>
            <div class="controls">
                <div class="btn-group">
                    <span class="btn btn-success">
                        <i class="fa fa-upload"></i>
                        <span>上传封面</span>
                        <input class="fileupload" type="file" accept="" multiple="">
                    </span>
                    <input type="hidden" name="cover" class="form-upload" data-more="0" value="<?php echo $it['cover'] ?>">
                </div>
            </div>
        </div>
        <div id="js-cover-show" class="js-img-list-f"></div>
        <div class="clear"></div>

        <?php
        if (!empty($it['link'])) {
            $link = json_decode($it['link'], true);
        }
        ?>
        <?php if(isset($link)): ?>
            <?php foreach ($link as $value): ?>
                <div class="control-group">
                    <label class="control-label">链接</label>
                    <div class="controls">
                        <input type="text" name="name[]" value="<?php echo $value['name'] ?>" placeholder="名称">
                        <input style="margin-left: 50px;" class="btn btn-info add-link" type="button" value="新增链接">
                        <input style="margin-left: 20px;" class="btn btn-danger del-link" type="button" value="删除链接">
                    </div>
                    <div class="controls">
                        <input type="text" name="url[]" value="<?php echo $value['url'] ?>" placeholder="url">
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="control-group">
                <label class="control-label">链接</label>
                <div class="controls">
                    <input type="text" name="name[]" value="" placeholder="名称">
                    <input style="margin-left: 50px;" class="btn btn-info add-link" type="button" value="新增链接">
                    <input style="margin-left: 20px;" class="btn btn-danger del-link" type="button" value="删除链接">
                </div>
                <div class="controls">
                    <input type="text" name="url[]" value="" placeholder="url">
                </div>
            </div>
        <?php endif; ?>
    </div>

    <div class="boxed-footer">
        <input type="hidden" value="<?php echo $it['id']; ?>" name="id" />
        <input type="submit" value="<?php echo lang('submit'); ?>" class='btn btn-primary'>
    </div>
    </form>
</div>

<?php include_once 'inc_ui_media.php'; ?>
<script>
    require(['jquery', 'adminer/js/ui', 'adminer/js/media'], function ($, ui, media) {
        media.init();
        var logo = <?php echo json_encode(one_upload($it['logo'])) ?>;
        var cover = <?php echo json_encode(one_upload($it['cover'])) ?>;
        media.show(logo, 'logo');
        media.show(cover, 'cover');

        $(document).on("click", ".add-link", function () {
            var $this = $(this);
            var html = $this.parent().parent().prop("outerHTML");
            $this.parents(".boxed-inner").append(html);
        });
        $(document).on("click", ".del-link", function () {
            $(this).parent().parent().remove();
        })
    });
</script>