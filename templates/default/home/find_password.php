<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.public-top-layout, .head-app, .head-search-bar, .head-user-menu, .public-nav-layout, .nch-breadcrumb-layout, #faq {
	display: none !important;
}
.public-head-layout {
	margin: 10px auto -10px auto;
}
.wrapper {
	width: 1000px;
}
#footer {
	border-top: none!important;
	padding-top: 30px;
}
</style>
<div class="nc-login-layout">
  <div class="left-pic"> <img src="<?php echo $output['lpic'];?>"  border="0"> </div>
  <div class="nc-login">
    <div class="nc-login-title">
      <h3><?php echo $lang['login_index_find_password'];?></h3>
    </div>
    <div class="nc-login-content" id="demo-form-site">
      <form action="index.php?act=login&op=find_password" method="POST" id="find_password_form">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <dl>
          <dt><?php echo "手机号";?></dt>
          <dd id="smscode_error" style="min-height:54px;">
            <input type="text" id="mobile" name="mobile" class="text tip" title="<?php echo "输入正确的手机号";?>" />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_code'];?></dt>
          <dd id="web_code" style="min-height:54px;">
            <input type="text" name="captcha" class="text w50 fl" id="captcha" maxlength="4" size="10" />
            <img src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" title="<?php echo $lang['login_index_change_checkcode'];?>" name="codeimage" border="0" id="codeimage" class="fl ml5"> <a href="javascript:void(0);" class="ml5" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();"><?php echo $lang['login_password_change_code']; ?></a>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt>手机验证码</dt>
          <dd style="min-height:54px;">
            <input type="text" id="mobile_code" name="mobile_code" class="text tip" style="width: 100px;" title="手机验证码" />
            <input id="btnSendCode" style=" width: 80px; text-algin:center; height:28px;" type="button" value="发送验证码" onclick="sendMessage()" />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo "设置密码";?></dt>
          <dd style="min-height:54px;">
            <input type="password" class="text" id="password" name="password"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo "再次密码";?></dt>
          <dd style="min-height:54px;">
            <input type="password" class="text" id="password_confirm" name="password_confirm"/>
            <label></label>
          </dd>
        </dl>
        
        <dl class="mb30">
          <dt></dt>
          <dd>
            <input type="button" class="submit" value="重置密码" name="Submit" id="Submit">
          </dd>
        </dl>
        <input type="hidden" value="<?php echo $output['ref_url']?>" name="ref_url">
      </form>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script> 
<script>
var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数

function sendMessage() {
  　	curCount = count;
　　//设置button效果，开始计时
     

     var mobile=$("#mobile").val();
     var captcha=$("#captcha").val();

     if( mobile == '')
     {
    	 $("#smscode_error > label:first").show().addClass("error");
    	 $("#smscode_error > label:first").html("手机号不能为空");
         return false;
     }else{
    	 $("#smscode_error > label:first").hide();
     }

     if( captcha == '')
     {
    	 $("#web_code > label:first").show().addClass("error");
    	 $("#web_code > label:first").html("验证码不能为空");
         return false;
     }else{
    	 $("#web_code > label:first").hide();
     }
　　  //向后台发送处理数据
     $.ajax({
	         　　type: "POST", //用POST方式传输
	         　　dataType: "json", //数据格式:JSON
	         　　url: 'index.php?act=login&op=send_code', //目标地址
	        　　 data: {mobile:mobile,captcha:captcha,nchash:'<?php echo getNchash();?>',type:'forget'},
	         　　success: function (msg){
				
		         if(msg.state == true)
		         {
		        	 showDialog(msg.msg,'succ','','','','','','','','',2);
		        	 $("#btnSendCode").attr("disabled", "true");
		             $("#btnSendCode").val(curCount + "秒");
		             InterValObj = window.setInterval(SetRemainTime, 1000); //启动计时器，1秒执行一次
			         
			     }
			     if(msg.state == false){
			    	 showDialog(msg.msg,'error','','','','','','','','',2);
				 }
	        	 
		  }
     });
}

//timer处理函数
function SetRemainTime() {
            if (curCount == 0) {                
                window.clearInterval(InterValObj);//停止计时器
                $("#btnSendCode").removeAttr("disabled");//启用按钮
                $("#btnSendCode").val("发送验证码");
            }
            else {
                curCount--;
                $("#btnSendCode").val(curCount + "秒");
            }
}
</script>
<script type="text/javascript">
$(function(){
	jQuery.validator.addMethod("isMobile", function(value, element) {
	    var length = value.length;
	    var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
	    return this.optional(element) || (length == 11 && mobile.test(value));
	}, "请正确填写您的手机号码");
	jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
	}, "Letters only please"); 
		jQuery.validator.addMethod("lettersmin", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length>=3);
	}, "Letters min please"); 
		jQuery.validator.addMethod("lettersmax", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length<=15);
	}, "Letters max please");
	
    $('#Submit').click(function(){
        if($("#find_password_form").valid()){
        	ajaxpost('find_password_form', '', '', 'onerror');
        } else{
        	document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
        }
    });
    $('#find_password_form').validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        rules : {
        	mobile : {
                required : true,
                isMobile : true,
                remote   : {
                    url : 'index.php?act=login&op=exit_mobile',
                    type: 'get',
                    data:{
                        mobile : function(){
                            return $('#mobile').val();
                        }
                    }
                }
            },
            mobile_code : {
				required : true,
				remote   : {
                    url :'index.php?act=login&op=check_code',
                    type:'get',
                    data:{
                    	mobile_code : function(){
                            return $('#mobile_code').val();
                        },
                        mobile : function(){
                            return $('#mobile').val();
                        }
                    }
                }
        	},
			password : {
                required : true,
                minlength: 6,
				maxlength: 20
            },
            password_confirm : {
                required : true,
                equalTo  : '#password'
            },
            captcha : {
                required : true,
                minlength: 4,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    }
                }
            } 
        },
        messages : {
        	mobile : {
                required : '手机号必填',
                isMobile  : '填写正确的手机号码',
				remote	 : '手机号不存在'
            },
            mobile_code : {
				required : "请输入验证码",
				remote : "验证码不正确"
			},
			password  : {
                required : '<?php echo $lang['login_register_input_password'];?>',
                minlength: '<?php echo $lang['login_register_password_range'];?>',
				maxlength: '<?php echo $lang['login_register_password_range'];?>'
            },
            password_confirm : {
                required : '<?php echo $lang['login_register_input_password_again'];?>',
                equalTo  : '<?php echo $lang['login_register_password_not_same'];?>'
            },
            captcha : {
                required : '<?php echo $lang['login_usersave_code_isnull']	;?>',
                minlength : '<?php echo $lang['login_usersave_wrong_code'];?>',
                remote   : '<?php echo $lang['login_usersave_wrong_code'];?>'
            }
        }
    });
});
</script> 
