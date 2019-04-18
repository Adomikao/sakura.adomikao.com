<div class="btn-group">
    <a href="<?php echo site_url('article/index') ?>" class='btn'> <i class="fa fa-arrow-left"></i> <?php echo lang('back_list') ?></a>
</div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
    <h3><i class="fa fa-pencil"></i> <span class="badge badge-success pull-right"><?php echo $title; ?></span> <?php echo lang('add') ?></h3>
    <?php echo form_open(current_url(), array("class" => "form-horizontal", "id" => "frm-create")); ?>
    <div class="boxed-inner seamless">
        <div class="control-group">
            <label class="control-label" for="title">标题</label>
            <div class="controls">
                <input type="text" id="title" name="title">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="intro_left">首页描述—左</label>
            <div class="controls">
                <textarea rows="8" name="intro_left"></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="intro_right">首页描述—右</label>
            <div class="controls">
                <textarea rows="8" name="intro_right"></textarea>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label" for="music">背景音乐</label>
            <div class="controls">
                <input type="text" id="music" name="music">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">标签</label>
            <div class="controls">
                <?php
                $tag = $this->db->where('admin_id', $_SESSION['mid'])->get('tag')->result_array();
                ?>
                <?php foreach ($tag as $val): ?>
                    <input type="checkbox" name="tag[]" value="<?php echo $val['id']; ?>"><?php echo $val['title']; ?>&nbsp;&nbsp;
                <?php endforeach; ?>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label">封面</label>
            <div class="controls">
                <div class="btn-group">
                    <span class="btn btn-success">
                        <i class="fa fa-upload"></i>
                        <span>上传封面</span>
                        <input class="fileupload" type="file" accept="" multiple="">
                    </span>
                    <input type="hidden" name="photo" class="form-upload" data-more="0" value="">
                    <input type="hidden" name="thumb" class="form-upload-thumb" value="">
                </div>
            </div>
        </div>
        <div id="js-photo-show" class="js-img-list-f"></div>
        <div class="clear"></div>

        <div class="control-group">
            <label class="control-label">多图</label>
            <div class="controls">
                <div class="btn-group">
                    <span class="btn btn-success">
                        <i class="fa fa-upload"></i>
                        <span>上传图片</span>
                        <input class="fileupload" type="file" accept="" multiple="">
                    </span>
                    <input type="hidden" name="image" class="form-upload" data-more="1" value="">
                </div>
            </div>
        </div>
        <div id="js-image-show" class="js-img-list-f"></div>
        <div class="clear"></div>

        <div class="control-group">
            <label class="control-label">文本页</label>
            <div class="controls">
                <input type="text" name="page[]" value="" placeholder="输入页数（大于1）">
                <input style="margin-left: 50px;" class="btn btn-info add-text" type="button" value="新增文本页">
                <input style="margin-left: 20px;" class="btn btn-danger del-text" type="button" value="删除文本页">
            </div>
            <div class="controls">
                <textarea rows="12" name="text[]" placeholder="输入内容"></textarea>
            </div>
        </div>
    </div>

    <div class="boxed-footer">
        <input type="submit" value="<?php echo lang('submit'); ?>" class="btn btn-primary">
        <input type="reset" value="<?php echo lang('reset'); ?>" class="btn btn-danger">
    </div>
    </form>
</div>

<?php include_once 'inc_ui_media.php'; ?>
<script>
    require(['jquery', 'adminer/js/ui', 'adminer/js/media'], function ($, ui, media) {
        media.init();
        media.sort('photo');
        media.sort('image');

        $(document).on("click", ".add-text", function () {
            var $this = $(this);
            var html = $this.parent().parent().prop("outerHTML");
            $this.parents(".boxed-inner").append(html);
        });
        $(document).on("click", ".del-text", function () {
            var $this = $(this);
            if($this.parent().parent().find("textarea").val().length > 0) {
                if(confirm("文本内容不为空，确定删除吗？")){
                    $this.parent().parent().remove();
                }
            } else {
                $this.parent().parent().remove();
            }
        })
    });
</script>
