<?php defined('InShopNC') or exit('Access Invalid!');?>
<style type="text/css">
.public-top-layout, .head-app, .head-search-bar, .head-user-menu, .public-nav-layout, .nch-breadcrumb-layout, #faq {
	display: none !important;
}
.public-head-layout {
	margin: 5px auto -10px auto;
  border-bottom: solid 2px #e5e5e5;
  height: 80px;
  width: 100%;
}
.header-wrap .wrapper {
	width: 100%;
  box-shadow: 6px 6px 3px #888888;
  padding-left:220px;
}
#footer {
	border-top: none!important;
	padding-top: 30px;
}
#homeTopAd02{
  height: 0px !important;
}
</style>
<div class="nc-login-layout">
  <div class="nc-login">
    <div class="nc-login-title">
      <h3>个人注册</h3>
    </div>
    <div class="nc-login-content">
      <form id="register_form" method="post" action="<?php echo SHOP_SITE_URL;?>/index.php?act=login&op=usersave">
      <?php Security::getToken();?>
        <dl>
          <dt><?php echo $lang['login_register_username'];?></dt>
          <dd style="min-height:54px;">
            <input type="text" id="user_name" placeholder="请输入用户名"  name="user_name" class="text tip" title="<?php echo $lang['login_register_username_to_login'];?>" autofocus />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_pwd'];?></dt>
          <dd style="min-height:54px;">
            <input type="password" id="password" placeholder="请输入密码" name="password" class="text tip" title="<?php echo $lang['login_register_password_to_login'];?>" />
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><?php echo $lang['login_register_ensure_password'];?></dt>
          <dd style="min-height:54px;">
            <input type="password" placeholder="请确认密码" id="password_confirm" name="password_confirm" class="text tip" title="<?php echo $lang['login_register_input_password_again'];?>"/>
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt>手机号</dt>
          <dd id="smscode_error" style="min-height:54px;">
            <input type="text" id="mobile" placeholder="请输入手机号码" name="mobile" class="text tip" title="请输入常用的手机，将用来找回密码、接受订单通知等" />
            <label></label>
          </dd>
        </dl>
		 <?php if(C('captcha_status_register') == '1') { ?>
        <dl>
          <dt><?php echo $lang['login_register_code'];?></dt>
          <dd id="web_code" style="min-height:54px;">
            <input type="text" id="captcha" name="captcha" placeholder="请输入验证码" class="text w50 fl tip" maxlength="4" size="10" title="<?php echo $lang['login_register_input_code'];?>" />
          
            <a href="javascript:void(0)" class="ml5" onclick="javascript:document.getElementById('codeimage').src='index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();">
                <img  id="validatorcode" style="float:right" src="index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>" title="" name="codeimage" border="0" id="codeimage" class="fl ml5"/> 
            </a>
            
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <dl>
          <dt>手机验证码</dt>
          <dd style="min-height:54px;">
            <input type="text" id="mobile_code" placeholder="请输入手机验证码" name="mobile_code" class="text tip" style="width: 100px;" title="手机验证码" />
            <input id="btnSendCode" style=" width: 80px; text-algin:center; height:45px;float:right" type="button" value="发送验证码" onclick="sendMessage()" />
            <label></label>
          </dd>
        </dl>
       
        <dl>
        
          <dd style="width:100%;">
            <input type="submit" id="Submit" value="<?php echo $lang['login_register_regist_now'];?>" class="submit" title="<?php echo $lang['login_register_regist_now'];?>" />
            <!-- <input name="agree" type="checkbox" class="vm ml10" id="clause" value="1" checked="checked" /> -->
           <!--  <span for="clause" class="ml5"><?php echo $lang['login_register_agreed'];?><a href="<?php echo urlShop('document', 'index',array('code'=>'agreement'));?>" target="_blank" class="agreement" title="<?php echo $lang['login_register_agreed'];?>"><?php echo $lang['login_register_agreement'];?></a></span -->
            <label></label>
          </dd>
        </dl>
        <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
        <input name="nchash" type="hidden" value="<?php echo getNchash();?>" />
        <input type="hidden" name="form_submit" value="ok" />
         <input type="hidden" value="<?php echo $_GET['zmr']?>" name="zmr">
      </form>
      <div class="clear"></div>
    </div>
    <div class="nc-login-bottom"></div>
  </div>
  <div class="nc-login-rights">
    <div class="nc-login-title">
      <h3 style="padding-bottom: 5px;"><a style="color:#555;" href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index">商家入驻</a></h3>
    </div>
  </div>
<!--   <div class="nc-login-left">
    <h3><?php echo $lang['login_register_after_regist'];?></h3>
    <ol>
      <li class="ico05"><i></i><?php echo $lang['login_register_buy_info'];?></li>
      <li class="ico01"><i></i><?php echo $lang['login_register_openstore_info'];?></li>
      <li class="ico03"><i></i><?php echo $lang['login_register_sns_info'];?></li>
      <li class="ico02"><i></i><?php echo $lang['login_register_collect_info'];?></li>
      <li class="ico06"><i></i><?php echo $lang['login_register_talk_info'];?></li>
      <li class="ico04"><i></i><?php echo $lang['login_register_honest_info'];?></li>
      <div class="clear"></div>
    </ol>
    <h3 class="mt20"><?php echo $lang['login_register_already_have_account'];?></h3>
    <div class="nc-login-now mt10"><span class="ml20"><?php echo $lang['login_register_login_now_1'];?><a href="index.php?act=login&ref_url=<?php echo urlencode($output['ref_url']); ?>" title="<?php echo $lang['login_register_login_now'];?>" class="register"><?php echo $lang['login_register_login_now_2'];?></a></span><span><?php echo $lang['login_register_login_now_3'];?><a class="forget" href="index.php?act=login&op=forget_password"><?php echo $lang['login_register_login_forget'];?></a></span></div>
  </div> -->
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.poshytip.min.js" charset="utf-8"></script>
<script>
//注册表单提示
$('.tip').poshytip({
	className: 'tip-yellowsimple',
	showOn: 'focus',
	alignTo: 'target',
	alignX: 'center',
	alignY: 'top',
	offsetX: 0,
	offsetY: 5,
	allowTipHover: false
});

//注册表单验证
$(function(){
		jQuery.validator.addMethod("lettersonly", function(value, element) {
			return this.optional(element) || /^[^:%,'\*\"\s\<\>\&]+$/i.test(value);
		}, "Letters only please"); 
		jQuery.validator.addMethod("lettersmin", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length>=3);
		}, "Letters min please"); 
		jQuery.validator.addMethod("lettersmax", function(value, element) {
			return this.optional(element) || ($.trim(value.replace(/[^\u0000-\u00ff]/g,"aa")).length<=15);
		}, "Letters max please");
		jQuery.validator.addMethod("isMobile", function(value, element) {
		    var length = value.length;
		    var mobile = /^(13[0-9]{9})|(18[0-9]{9})|(14[0-9]{9})|(17[0-9]{9})|(15[0-9]{9})$/;
		    return this.optional(element) || (length == 11 && mobile.test(value));
		}, "请正确填写您的手机号码");
    	$("#register_form").validate({
        errorPlacement: function(error, element){
            var error_td = element.parent('dd');
            error_td.find('label').hide();
            error_td.append(error);
        },
        onkeyup: false,
        rules : {
            user_name : {
                required : true,
                lettersmin : true,
                lettersmax : true,
                lettersonly : true,
                remote   : {
                    url :'index.php?act=login&op=check_member&column=ok',
                    type:'get',
                    data:{
                        user_name : function(){
                            return $('#user_name').val();
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
            mobile : {
                required : true,
                minlength : 11,
                isMobile : true,
                remote   : {
                    url : 'index.php?act=login&op=check_mobile',
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
                    url : 'index.php?act=login&op=check_code',
                    type: 'get',
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
           
			<?php if(C('captcha_status_register') == '1') { ?>
            captcha : {
                required : true,
                remote   : {
                    url : 'index.php?act=seccode&op=check&nchash=<?php echo getNchash();?>',
                    type: 'get',
                    data:{
                        captcha : function(){
                            return $('#captcha').val();
                        }
                    },
                    complete: function(data) {
                        if(data.responseText == 'false') {
                        	document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash();?>&t=' + Math.random();
                        }
                    }
                }
            },
			<?php } ?>
            agree : {
                required : true
            }
        },
        messages : {
            user_name : {
                required : '<?php echo $lang['login_register_input_username'];?>',
                lettersmin : '<?php echo $lang['login_register_username_range'];?>',
                lettersmax : '<?php echo $lang['login_register_username_range'];?>',
				lettersonly: '<?php echo $lang['login_register_username_lettersonly'];?>',
				remote	 : '<?php echo $lang['login_register_username_exists'];?>'
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
            mobile : {
                required : '手机号必填',
                minlength : "确认手机不能小于11位",
                isMobile  : '填写正确的手机号码',
				remote	 : '手机号已存在'
            },

            mobile_code : {
                required : '手机验证不能为空',
				remote	 : '手机验证码不正确'
            },
            
			<?php if(C('captcha_status_register') == '1') { ?>
            captcha : {
                required : '<?php echo $lang['login_register_input_text_in_image'];?>',
				remote	 : '<?php echo $lang['login_register_code_wrong'];?>'
            },
			<?php } ?>
            agree : {
                required : '<?php echo $lang['login_register_must_agree'];?>'
            }
        }
    });    
});

var InterValObj; //timer变量，控制时间
var count = 60; //间隔函数，1秒执行
var curCount;//当前剩余秒数
//验证码滚动

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
	        　　 data: {mobile:mobile,captcha:captcha,nchash:'<?php echo getNchash();?>',type:'reg'},
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