<?php include_once 'inc_form_errors.php'; ?>

<?php
if (isset($_GET['p0'])) {
    $mid = $_GET['p0'];
} else {
    $mid = $_SESSION['mid'];
}
?>

<div class="btn-group">
    <a href="<?php echo site_url('manager/index') ?>" class='btn'> <i class="fa fa-arrow-left"></i> 返回</a>
</div>

<?php if ($mid == $_SESSION['mid'] or $_SESSION['gid'] == 1): ?>

    <?php echo form_open(current_url() . '/' . $mid, array("class" => "form-horizontal", "id" => "frm-pwd")); ?>
    <div class="boxed">
        <div class="heading">
            <h3> 修改密码</h3>
        </div>
        <div class="boxed-inner seamless">

            <div class="control-group">
                <label class="control-label" for="pwdo">原密码</label>
                <div class="controls">
                    <input type="password" id="pwdo" name="pwdo" value="<?php echo set_value('pwdo') ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="pwd">密码</label>
                <div class="controls">
                    <input type="password" id="pwd" name="pwd" value="<?php echo set_value('pwd') ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label" for="pwdre">重复密码</label>
                <div class="controls">
                    <input type="password" id="pwdre" name="pwdre" value="<?php echo set_value('pwdre') ?>">
                    <span class="help-inline"></span>
                </div>
            </div>

        </div>

        <div class="boxed-footer">
            <input type="hidden" name="mid" value="<?php echo $mid ?>">
            <input type="submit" value=" <?php echo lang('submit'); ?> " class='btn btn-primary'>
            <input type="reset" value=' <?php echo lang('reset'); ?> ' class="btn btn-danger">
        </div>
    </div>
    </form>
<?php else: ?>
    <div class="alert alert-danger">
        您并没有权限修改其他人的帐号密码！
    </div>
<?php endif ?>

<?php //echo static_file('adminer/js/manager_passwd.js') ?>
<script>
    require(['tools'], function (tools) {

        var passwd_rule = {
            rules: {
                pwdo: {
                    required: true,
                    minlength: 6,
                    maxlength: 30
                },
                pwd: {
                    required: true,
                    minlength: 6,
                    maxlength: 30
                },
                pwdre: {
                    required: true,
                    minlength: 6,
                    maxlength: 30,
                    equalTo: "#pwd"
                }
            },
            messages: {
                pwdo: {
                    required: "你不能不输入 原密码！",
                    minlength: "输入字符数不的小于 {0}！",
                    maxlength: "输入字符数不的大于 {0}！"
                },
                pwd: {
                    required: "你不能不输入 密码！",
                    minlength: "输入字符数不的小于 {0}！",
                    maxlength: "输入字符数不的大于 {0}！"
                },
                pwdre: {
                    required: "密码必须验证！",
                    minlength: "输入字符数不的小于 {0}！",
                    maxlength: "输入字符数不的大于 {0}！",
                    equalTo: "必须输入一致的密码!"
                }
            }
        }
        tools.make_validate('frm-pwd', passwd_rule.rules, passwd_rule.messages);
    });

</script>
