<div class="btn-group"><a href="<?php echo site_url('img_category/index');?>" class="btn"> <i class="fa fa-arrow-left"></i><?php echo lang('back_list')?></a></div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
	<h3> <i class="fa fa-pencil"></i> 编辑消息 <span class="badge badge-success pull-right"><?php echo $title; ?></span></h3>
	<?php echo form_open(current_url(), array('class' => 'form-horizontal', 'id' => 'frm-edit')); ?>
		<div class="boxed-inner seamless">
			<div class="control-group">
				<label for="title" class="control-label">标题</label>
				<div class="controls">
					<input type="text" name="title" id="title" value="<?php echo set_value('title',$it['title']); ?>"  placeholder="配置标题" >
					<span class="help-inline"></span>
				</div>
			</div>
		</div>
		<div class="boxed-footer">
			<input type="hidden" name="id" value="<?php echo $it['id']?>">
			<input type="submit" value="<?php echo lang('submit') ?>" class="btn btn-primary">
			<input type="reset" value="<?php echo lang('reset') ?>" class="btn btn-danger">
		</div>
	</form>
</div>
