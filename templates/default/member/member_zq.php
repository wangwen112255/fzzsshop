<?php defined('InShopNC') or exit('Access Invalid!');?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>债务提交</title>
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/layout.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/store_joinin_new.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/base.css" rel="stylesheet" type="text/css">
<link href="<?php echo SHOP_TEMPLATES_URL;?>/css/main.css" rel="stylesheet" type="text/css">
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/common.js" charset="utf-8"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.validation.min.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/jquery.masonry.js"></script>
<script src="<?php echo RESOURCE_SITE_URL;?>/js/dialog/dialog.js" id="dialog_js" charset="utf-8"></script>

<style>
.viss td input.file_input{
	border:none;
}

label.error {
    color: red;
    line-height: 20px;
    background: none;
    vertical-align: middle;
    display: inline-block;
    height: 20px;
    padding: 0px;
    margin-left: 4px;
    border: none;
}
</style>
</head>
<body>
<div class="header">
    <h2 class="header_logo"><a href="<?php echo BASE_SITE_URL;?>"><img src="<?php echo UPLOAD_SITE_URL.DS.ATTACH_COMMON.DS.$output['setting_config']['site_logo']; ?>" class="pngFix"></a></h2>
    <ul class="header_menu">
        <li class="current"><a href="/shop/index.php?act=show_joinin&amp;op=index" class="joinin"><i></i>首页</a></li>
        <li class=""><a href="/shop/index.php?act=seller_center&amp;op=index" class="login"><i></i>商家管理中心</a></li>
        <li class=""><a href="/shop/index.php?act=show_help&amp;op=index" class="faq"><i></i>商家帮助指南</a></li>
    </ul>
</div>
<div class="main mat30">
	<div><p>请认真阅读以下文字：</p>
		<p>我们需要全面了解您的债权情况，请您认真填写。我们会保护您的隐私。带星号（*）的为必填项；您的信息填写越完整，系统模拟评级越高，越能快速处理不良债权！</p>
	</div>
    <div class="nch-article-con">
        <h1>提交债权信息</h1>
        <h2>您可以提交您所拥有的债事信息给我们的客服</h2>
        <div class="default">
            <form id="ajax_form" method="post" action="<?php echo urlShop('member', 'saveZq');?>" enctype="multipart/form-data">
            <table class="viss">
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债权人姓名：</span><br />
                    </td>
                    <td><input name="name" type="text" id="name" /><br />
                    <label>请输入姓名,信息审核通过后无法修改</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债权人电话：</span>
                    </td>
                    <td><input type="text" name="mobile" id="mobile" /><br />
                    <label>请输入债权人手机号码</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债权人身份证号码：</span><br />
                    </td>
                    <td><input type="text" name="numcard" id="numcard" /><br />
                    <label>请输入身份证号码</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债务人姓名：</span><br />
                    </td>
                    <td><input type="text" name="zw_name" id="zw_name" /><br />
                    <label>请输入借款人姓名,信息审核通过后无法修改</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债务人电话：</span>
                    </td>
                    <td><input type="text" name="zw_mobile" id="zw_mobile" /><br />
                    <label>请输入债务人手机号码</label>
                    </td>
                </tr>
				<tr>
                    <td width="150">
                        <span>债务人身份证号码：</span><br />
                    </td>
                    <td><input type="text" name="zw_numcard" id="zw_numcard" /><br />
                    <label>请输入身份证号码</label>
                    </td>
                </tr>
				<tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>借款时间：</span><br />
                    </td>
                    <td><input type="text" name="query_start_date" id="query_start_date" /><br />
                    <label>请选择借款的时间</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>借款合同扫描件：</span><br />
                    </td>
                    <td><input type="file" name="zw_image_1" id="zw_image_1" class="file_input" /><br />
					<input type="file" name="zw_image_2" id="zw_image_2" class="file_input" /><br />
					<input type="file" name="zw_image_3" id="zw_image_3" class="file_input" /><br />
					<input type="file" name="zw_image_4" id="zw_image_4" class="file_input" /><br />
					<input type="file" name="zw_image_5" id="zw_image_5" class="file_input" /><br />
                    <label>请上传合同扫描件，请保持字迹清晰，如果合同页数过多，请打包上传</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债权人身份证扫描件(正)：</span><br />
                    </td>
                    <td><input type="file" name="card_img_1" id="card_img_1" class="file_input" /><br />
                    <label>身份证正面</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span><p style="color:red;display:inline;">*</p>债权人身份证扫描件(反)：</span>
                    </td>
                    <td><input type="file" name="card_img_2" id="card_img_2" class="file_input" /><br />
                    <label>身份证反面</label>
                    </td>
                </tr>
				 <tr>
                    <td width="150">
                        <span>债务人身份证扫描件(正)：</span><br />
                    </td>
                    <td><input type="file" name="card_img_3" id="card_img_3" class="file_input" /><br />
                    <label>身份证正面</label>
                    </td>
                </tr>
                <tr>
                    <td width="150">
                        <span>债务人身份证扫描件(反)：</span>
                    </td>
                    <td><input type="file" name="card_img_4" id="card_img_4" class="file_input" /><br />
                    <label>身份证反面</label>
                    </td>
                </tr>
				<tr>
                    <td width="150">
                        <span>推荐人：</span><br />
                    </td>
                    <td><input type="text" name="tj_name" id="tj_name" /><br />
                    <label>请填写推荐人姓名</label>
                    </td>
                </tr>
				<tr>
                    <td width="150">
                        <span>备案网点：</span><br />
                    </td>
                    <td><div data-toggle="distpicker" style="display: inline;">
							<select class="form-control" id="province" name="province"></select>
							<select class="form-control" id="city" name="city"></select>
							<select class="form-control" id="district" name="district"></select>
						</div><br />
                    <label>请选择您备案的网点所在地</label>
                    </td>
                </tr>
                <tr>
                    <td width="150" >
                        <span><p style="color:red;display:inline;">*</p>债事金额：</span>
                    </td>
                    <td><input type="text" name="total" id="total" />&nbsp;  元<br />
                    <label>请输入借款合同债权金额，例如：1000000</label>
                    </td>
                </tr>
                <tr style="font-size:12px;"><td></td><td><input type="checkbox" checked="checked" style="width:14px;height:14px;">并同意<a href="index.php?act=member&op=xieyi">《债权转让协议》</a></td></tr>
                <tr>
                    <td width="150">
                        <span></span>
                    </td>
                    <td><input type="submit" value="立即提交"></td>
                </tr>
            </table>
            <style>
                .viss{ width: 100%; border-collapse: collapse }
                .viss td{ padding: 10px 10px; line-height: 24px;}
                .viss td span{ width: 150px; text-align: right; display: block;}
                .viss td input{ height: 30px; border: 1px solid #ddd; padding: 0 10px; width: 300px;}
                 .viss td input[type="submit"] {height: 40px;color: #fff;background: #D93600;font-size: 20px;font-weight: bold;}
                .viss td textarea{ width: 300px; height: 100px; border: 1px solid #ddd; padding: 10px;}
            </style>
            </form>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/jquery.ui.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/distpicker.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/main.js"></script> 
<script type="text/javascript" src="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/i18n/zh-CN.js" charset="utf-8"></script>
<link rel="stylesheet" type="text/css" href="<?php echo RESOURCE_SITE_URL;?>/js/jquery-ui/themes/ui-lightness/jquery.ui.css"  />
<script language="javascript">
$(function(){
	$('#query_start_date').datepicker({dateFormat: 'yy-mm-dd'});
});
</script>
<script>
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
	$("#ajax_form").validate({
    errorPlacement: function(error, element){
        var error_td = element.parent('td');
        error_td.find('label').hide();
        error_td.append(error);
    },
    onkeyup: false,
    rules : {
        name : {
            required : true
        },
        numcard : {
            required : true
        },
        zw_name : {
            required : true
        },
        zw_mobile : {
            required : true,
            minlength : 11,
            isMobile : true
        },
		zw_image : {
            required : true
        },
		card_img_1 : {
            required : true
        },
		card_img_2 : {
            required : true
        },
		total : {
            required : true
        },
        mobile : {
            required : true,
            minlength : 11,
            isMobile : true
        }
    },
    messages : {
        name : {
            required : '请输入姓名,信息审核过后无法修改',
        },
        numcard  : {
            required : '请输入身份证号'
        },
        zw_name : {
            required : '请输入借款人姓名,信息审核过后无法修改'
        },
        zw_mobile : {
            required : '请输入债务人手机号',
            minlength : "确认手机不能小于11位",
            isMobile  : '填写正确的手机号码'
        },
		zw_image : {
            required : '请上传合同扫描件，请保持字迹清晰，如果合同页数过多，请打包上传'
        },
		card_img_1 : {
            required : '身份证正面'
        },
		card_img_2 : {
            required : '身份证反面'
        },
		total : {
            required : '请输入借款合同金额，例如1000000'
        },
        mobile : {
            required : '请输入债权人手机号',
            minlength : "确认手机不能小于11位",
            isMobile  : '填写正确的手机号码'
        }
    }
});    
});


</script>
<?php require_once template('footer');?>
</body>
</html>
