<div class="btn-group">
    <a href="<?php echo site_url('image/index') ?>" class='btn'> <i class="fa fa-arrow-left"></i> <?php echo lang('back_list') ?></a>
</div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
    <h3><i class="fa fa-plus"></i> <?php echo lang('add') ?></h3>
    <?php echo form_open(current_url(), array("class" => "form-horizontal", "id" => "frm-create")); ?>
    <div class="boxed-inner seamless">
        <div class="control-group">
            <label class="control-label" for="gid">分类</label>
            <div class="controls">
                <select name="cid" id="cid" class='bselect'>
                    <?php
                    foreach ($category as $c) {
                        echo '<option value="' . $c['id'] . '"' . set_selected('cid', 1, $c['id']) . '>';
                        echo $c['title'];
                        echo '</option>';
                    }
                    ?>
                </select>
                <span class="help-inline"></span>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="title">备注</label>
            <div class="controls">
                <input name="remark" />
            </div>
        </div>
        <div class="control-group">
            <label for="img" class="control-label">文件：</label>
            <div class="controls">
                <div class="btn-group">
                    <span class="btn btn-success"><i class="fa fa-upload"></i><span>图片上传</span><input class="fileupload" type="file" accept=""></span>
                    <input type="hidden" name="url" class="form-upload" value="<?php echo set_value('url') ?>">
                </div>
            </div>
        </div>
        <div id="js-url-show" class="js-img-list-f">
            <!-- 模板 #tpl-img-list -->
        </div>
        <div class="clear"></div>
    </div>
</div>

<div class="boxed-footer">
    <input type="submit" value=" <?php echo lang('submit'); ?> " class='btn btn-primary'>
</div>
</form>
</div>

<?php include_once 'inc_ui_media.php'; ?>

<script type="text/javascript">
    require(['adminer/js/ui', 'adminer/js/media'], function (ui, media) {
        media.init();
    });
</script>
