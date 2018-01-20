<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  
  <div class="ncm-default-form">
    <form method="post" id="password_form" name="password_form" action="index.php?act=member_security&op=modify_membercard">
      <input type="hidden" name="form_submit" value="ok"  />
      <dl>
        <dt><i class="required">*</i>绑定会员卡：</dt>
        <dd>
          <input type="text"  maxlength="40" class="password" name="member_card" id="member_card"/>
          <label for="member_card" generated="true" class="error"></label>
          <p class="hint">会员卡号</p></dd>
      </dl>
      <dl class="bottom">
        <dt>&nbsp;</dt>
        <dd><label class="submit-border">
          <input type="submit" class="submit" value="<?php echo $lang['home_member_submit'];?>" /></label>
        </dd>
      </dl>
    </form>
  </div>
</div>
<script type="text/javascript">
$(function(){
    $('#password_form').validate({
        
        rules : {
            member_card : {
                required   : true
            }
        },
        messages : {
            member_card  : {
                required  : '请输入会员卡号'
            }
        }
    });
});
</script> 
