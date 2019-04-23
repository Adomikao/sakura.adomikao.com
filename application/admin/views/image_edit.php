<div class="btn-group">
    <a href="<?php echo site_url('image/index') ?>" class='btn'> <i class="fa fa-arrow-left"></i> <?php echo lang('back_list') ?></a>
</div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
    <h3><i class="fa fa-plus"></i> <?php echo lang('edit') ?></h3>
    <?php echo form_open(current_url(), array("class" => "form-horizontal", "id" => "frm-create")); ?>
    <div class="boxed-inner seamless">
        <div class="control-group">
            <label class="control-label" for="gid">分类</label>
            <div class="controls">
                <select name="cid" id="cid" class='bselect'>
                    <?php
                    foreach ($category as $c) {
                        echo '<option value="' . $c['id'] . '"' . set_switch('gid', $it['cid'], $c['id'], 'selected="selected" class="option-select"') . '>';
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
                <input name="remark" value="<?php echo $it['remark']; ?>" />
            </div>
        </div>
    </div>
</div>

<div class="boxed-footer">
    <input type="hidden" value="<?php echo $it['id']; ?>" name="id" />
    <input type="submit" value="<?php echo lang('submit'); ?>" class='btn btn-primary'>
</div>
</form>
</div>
