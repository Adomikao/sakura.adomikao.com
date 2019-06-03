<div class="btn-group">
	<a href="<?php echo site_url('tag/index')?>" class='btn'> <i class="fa fa-arrow-left"></i> <?php echo lang('back_list')?></a>
</div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
	<h3><i class="fa fa-plus"></i><span class="badge badge-success pull-right"><?php echo $title; ?></span> <?php echo lang('add') ?></h3>
	<?php echo form_open(current_url(),array("class"=>"form-horizontal","id"=>"frm-create")); ?>
		<div class="boxed-inner seamless">
			<div class="control-group">
				<label class="control-label" for="title">标题</label>
				<div class="controls">
					<input type="text" id="title" name="title" value="<?php echo set_value("title") ?>">
				</div>
			</div>
            <div class="control-group">
                <label class="control-label" for="remark">备注</label>
                <div class="controls">
                    <input type="text" id="remark" name="remark" value="<?php echo set_value("remark") ?>">
                </div>
            </div>
		</div>
		<div class="boxed-footer">
			<input type="submit" value=" <?php echo lang('submit'); ?> " class='btn btn-primary'>
			<input type="reset" value=' <?php echo lang('reset'); ?> ' class="btn btn-danger">
		</div>
	</form>
</div>
