<style>
    #file_upload input[type="file"] {
        position: relative;
        top: -5px;
        width: 200px;
        cursor: pointer;
        opacity: 0;
    }
    .controls span.btn.btn-success {
        width: 200px;
        padding: 5px 12px;
        margin-top: 0;
    }
    .controls span.btn.btn-success i.fa {
        float: left;
        margin-top: 2px;
    }
</style>
<div class="btn-group">
    <a href="<?php echo site_url('article/index') ?>" class='btn'> <i class="fa fa-arrow-left"></i> <?php echo lang('back_list') ?></a>
</div>

<?php include_once 'inc_form_errors.php'; ?>

<div class="boxed">
    <h3><i class="fa fa-pencil"></i> <span class="badge badge-success pull-right"><?php echo $title; ?></span> <?php echo lang('add') ?></h3>
    <?php echo form_open(current_url(), array("class" => "form-horizontal", "id" => "frm-create")); ?>
    <div class="boxed-inner seamless">
        <div class="control-group">
            <label class="control-label" for="music">曲名</label>
            <div class="controls">
                <input type="text" id="music" name="music">
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="intro">描述</label>
            <div class="controls">
                <textarea rows="8" name="intro"></textarea>
            </div>
        </div>

        <div class="control-group">
            <label class="control-label" for="download_url">音乐地址</label>
            <div class="controls">
                <input type="text" id="download_url" name="download_url">
            </div>
        </div>

    </div>

    <div class="boxed-footer">
        <input type="submit" value="<?php echo lang('submit'); ?>" class="btn btn-primary">
        <input type="reset" value="<?php echo lang('reset'); ?>" class="btn btn-danger">
    </div>
    </form>
</div>

<?php //include_once 'inc_ui_media.php'; ?>
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
<script>
    require(['adminer/js/webuploader'], function(WebUploader) {
        var $Progress = $(".upload_progress progress");
        var uploader = WebUploader.create({
            // 选完文件后，是否自动上传。
            auto: true,
            // swf文件路径
            //swf: STATIC_URL + '/js/Uploader.swf',
            // 文件接收服务端。
            server: '/moon/index.php/music/upload/',
            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: {
                id: '#file_upload',
                multiple: false
            },
            accept: {
                title: 'mp3',
                extensions: 'mp3',
                mimeTypes: 'mp3/*'
            },
            fileSizeLimit: 100 * 1024 * 1024, //所有文件上传的大小限制,单位字节
            fileSingleSizeLimit: 100 * 1024 * 1024, //单个文件上传限制大小，单位字节
            threads: 1 //上传并发数。允许同时最大上传进程数,为了保证文件上传顺序
        });

        uploader.on('error', function (code, file) {
            var name = file.name,
                str  = "";
            switch(code){
                case "F_DUPLICATE":
                    str = name + " 该图片已上传";
                    alert(str);
                    break;
                case "Q_TYPE_DENIED":
                    str = name + "文件类型不允许";
                    alert(str);
                    break;
                case "F_EXCEED_SIZE":
                    str = "文件大小超出限制5M";
                    alert(str);
                    break;
                case "Q_EXCEED_SIZE_LIMIT":
                    str = "超出空间文件大小";
                    alert(str);
                    break;
                case "Q_EXCEED_NUM_LIMIT":
                    str = "抱歉，超过每次上传数量限制";
                    alert(str);
                    break;
            }
        });

        uploader.on( 'startUpload', function( file ) {

        });
        // 进度条
        uploader.on( 'uploadProgress', function( file, percentage ) {
            $Progress.show().attr('value', percentage);
            if(percentage == 1){
                $Progress.hide().attr('value', '');
            }
        });
        // 上传成功
        uploader.on( 'uploadSuccess', function( file, response ) {
            if(response.status == 1){
                $("input[name='download_url']").val(response.url);
            }else{
                alert(response.msg);
            }
        });
    });
</script>
