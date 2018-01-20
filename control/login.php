<?php
/**
 * 前台登录 退出操作
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class loginControl extends BaseHomeControl {

	public function __construct(){
		parent::__construct();
		Tpl::output('hidden_nctoolbar', 1);
	}

	/**
	 * 登录操作
	 *
	 */
	public function indexOp(){
		
		Language::read("home_login_index");
		$lang	= Language::getLangContent();
		$model_member	= Model('member');
		//检查登录状态
		$model_member->checkloginMember();
		if ($_GET['inajax'] == 1 && C('captcha_status_login') == '1'){
		    $script = "document.getElementById('codeimage').src='".APP_SITE_URL."/index.php?act=seccode&op=makecode&nchash=".getNchash()."&t=' + Math.random();";
		}
		$result = chksubmit(true,C('captcha_status_login'),'num');
		if ($result !== false){
			if ($result === -11){
				showDialog($lang['login_index_login_illegal'],'','error',$script);
			}elseif ($result === -12){
				showDialog($lang['login_index_wrong_checkcode'],'','error',$script);
			}
			if (process::islock('login')) {
				showDialog($lang['nc_common_op_repeat'],SHOP_SITE_URL,'','error',$script);
			}
			$obj_validate = new Validate();
			$obj_validate->validateparam = array(
				array("input"=>$_POST["user_name"],		"require"=>"true", "message"=>$lang['login_index_username_isnull']),
				array("input"=>$_POST["password"],		"require"=>"true", "message"=>$lang['login_index_password_isnull']),
			);
			$error = $obj_validate->validate();
			if ($error != ''){
			    showDialog($error,SHOP_SITE_URL,'error',$script);
			}
			$array	= array();
			$array['member_name']	= $_POST['user_name'];
			$array['member_passwd']	= md5($_POST['password']);
			$member_info = $model_member->getMemberInfo($array);
			if(is_array($member_info) and !empty($member_info)) {
				if(!$member_info['member_state']){
			        showDialog($lang['login_index_account_stop'],''.'error',$script);
				}
			}else{
			    process::addprocess('login');
			    showDialog($lang['login_index_login_fail'],'','error',$script);
			}
    		$model_member->createSession($member_info);
			process::clear('login');

			// cookie中的cart存入数据库
			Model('cart')->mergecart($member_info,$_SESSION['store_id']);

			// cookie中的浏览记录存入数据库
			Model('goods_browse')->mergebrowse($_SESSION['member_id'],$_SESSION['store_id']);

			if ($_GET['inajax'] == 1){
			    showDialog('',$_POST['ref_url'] == '' ? 'reload' : $_POST['ref_url'],'js');
			} else {
			    redirect($_POST['ref_url']);
			}
		}else{

			//登录表单页面
			$_pic = @unserialize(C('login_pic'));
			if ($_pic[0] != ''){
				Tpl::output('lpic',UPLOAD_SITE_URL.'/'.ATTACH_LOGIN.'/'.$_pic[array_rand($_pic)]);
			}else{
				Tpl::output('lpic',UPLOAD_SITE_URL.'/'.ATTACH_LOGIN.'/'.rand(1,4).'.jpg');
			}

			if(empty($_GET['ref_url'])) {
			    $ref_url = getReferer();
			    if (!preg_match('/act=login&op=logout/', $ref_url)) {
			     $_GET['ref_url'] = $ref_url;
			    }
			}
			Tpl::output('html_title',C('site_name').' - '.$lang['login_index_login']);
			if ($_GET['inajax'] == 1){
				Tpl::showpage('login_inajax','null_layout');
			}else{
				Tpl::showpage('login');
			}
		}
	}

	/**
	 * 退出操作
	 *
	 * @param int $id 记录ID
	 * @return array $rs_row 返回数组形式的查询结果
	 */
	public function logoutOp(){
		Language::read("home_login_index");
		$lang	= Language::getLangContent();
		// 清理消息COOKIE
		setNcCookie('msgnewnum'.$_SESSION['member_id'],'',-3600);
		session_unset();
		session_destroy();
		setNcCookie('cart_goods_num','',-3600);
		if(empty($_GET['ref_url'])){
			$ref_url = getReferer();
		}else {
			$ref_url = $_GET['ref_url'];
		}
		redirect('index.php?act=login&ref_url='.urlencode($ref_url));
	}

	/**
	 * 会员注册页面
	 *
	 * @param
	 * @return
	 */
	public function registerOp() {
		//zmr>v30
		$zmr=intval($_GET['zmr']);
		if($zmr>0)
		{
		  setcookie('zmr', $zmr);
		}
		
		Language::read("home_login_register");
		$lang	= Language::getLangContent();
		$model_member	= Model('member');
		$model_member->checkloginMember();
		Tpl::output('html_title',C('site_name').' - '.$lang['login_register_join_us']);
		Tpl::showpage('register');
	}

	/**
	 * 会员添加操作
	 *
	 * @param
	 * @return
	 */
	public function usersaveOp() {
		//重复注册验证
		if (process::islock('reg')){
			showDialog(Language::get('nc_common_op_repeat'));
		}
		Language::read("home_login_register");
		$lang	= Language::getLangContent();
		$model_member	= Model('member');
		$model_member->checkloginMember();
		$result = chksubmit(true,C('captcha_status_register'),'num');
		if ($result){
			if ($result === -11){
				showDialog($lang['invalid_request'],'','error');
			}elseif ($result === -12){
				showDialog($lang['login_usersave_wrong_code'],'','error');
			}
		} else {
		    showDialog($lang['invalid_request'],'','error');
		}
		
		
		
		if($_SESSION['verify_code']!=$_POST['mobile_code'])
		{
			showDialog("手机验证码错误",'','error');
		}
        $register_info = array();
        $register_info['username'] = $_POST['user_name'];
        $register_info['password'] = $_POST['password'];
        $register_info['password_confirm'] = $_POST['password_confirm'];
        $register_info['member_mobile'] = $_POST['mobile'];
		//添加奖励积分zmr>v30
		$zmr=intval($_COOKIE['zmr']);
		if($zmr>0)
		{
			$pinfo=$model_member->getMemberInfoByID($zmr,'member_id');
			if(empty($pinfo))
			{
				$zmr=0;
			}
		}
		$register_info['inviter_id'] = $zmr;
        $member_info = $model_member->register($register_info);
        if(!isset($member_info['error'])) {
            $model_member->createSession($member_info,true);
			process::addprocess('reg');

			// cookie中的cart存入数据库
			Model('cart')->mergecart($member_info,$_SESSION['store_id']);

			// cookie中的浏览记录存入数据库
			Model('goods_browse')->mergebrowse($_SESSION['member_id'],$_SESSION['store_id']);

			$_POST['ref_url']	= (strstr($_POST['ref_url'],'logout')=== false && !empty($_POST['ref_url']) ? $_POST['ref_url'] : 'index.php?act=member_information&op=member');
			redirect($_POST['ref_url']);
        } else {
			showDialog($member_info['error']);
        }
	}
	/**
	 * 会员名称检测
	 *
	 * @param
	 * @return
	 */
	public function check_memberOp() {
			/**
		 	* 实例化模型
		 	*/
			$model_member	= Model('member');

			$check_member_name	= $model_member->getMemberInfo(array('member_name'=>$_GET['user_name']));
			if(is_array($check_member_name) and count($check_member_name)>0) {
				echo 'false';
			} else {
				echo 'true';
			}
	}

	/**
	 * 电子邮箱检测
	 *
	 * @param
	 * @return
	 */
	public function check_emailOp() {
		$model_member = Model('member');
		$check_member_email	= $model_member->getMemberInfo(array('member_email'=>$_GET['email']));
		if(is_array($check_member_email) and count($check_member_email)>0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}
	
	/**
	 * 手机号检测
	 *
	 * @param
	 * @return
	 */
	public function check_mobileOp() {
		$model_member = Model('member');
		$check_member_mobile	= $model_member->getMemberInfo(array('member_mobile'=>$_GET['mobile']));
		if(is_array($check_member_mobile) and count($check_member_mobile)>0) {
			echo 'false';
		} else {
			echo 'true';
		}
	}

	/**
	 * 忘记密码页面
	 */
	public function forget_passwordOp(){
		/**
		 * 读取语言包
		 */
		Language::read('home_login_register');
		
		$_pic = @unserialize(C('login_pic'));
		if ($_pic[0] != ''){
			Tpl::output('lpic',UPLOAD_SITE_URL.'/'.ATTACH_LOGIN.'/'.$_pic[array_rand($_pic)]);
		}else{
			Tpl::output('lpic',UPLOAD_SITE_URL.'/'.ATTACH_LOGIN.'/'.rand(1,4).'.jpg');
		}
		Tpl::output('html_title',C('site_name').' - '.Language::get('login_index_find_password'));
		Tpl::showpage('find_password');
	}

	/**
	 * 找回密码的发邮件处理
	 */
	public function find_passwordOp(){
		Language::read('home_login_register');
		$lang	= Language::getLangContent();

		$result = chksubmit(true,true,'num');
		if ($result !== false){
		    if ($result === -11){
		        showDialog('非法提交');
		    }elseif ($result === -12){
		        showDialog('验证码错误');
		    }
		}

		if(empty($_POST['mobile'])){
			showDialog("手机号不能为空");
		}
		
		
		$code=trim($_POST['code']);
		$mobile=trim($_POST['mobile']);
		$verify_code=$_SESSION['verify_code'];
		$reg_mobile=$_SESSION['user_mobile'];
		
		if ($verify_code != $code && $reg_mobile !=$mobile) {
			showDialog("验证码不正确");
		}
		
		
		
		if(empty($_POST['password'])){
			showDialog("密码不能为空");
		}

		if (process::islock('forget')) {
		    showDialog($lang['nc_common_op_repeat'],'reload');
		}

		$member_model	= Model('member');
		$member	= $member_model->getMemberInfo(array('member_mobile'=>$_POST['mobile']));
		if(empty($member) or !is_array($member)){
		    process::addprocess('forget');
			showDialog("手机号不存在",'reload');
		}

		
		process::clear('forget');
		
		$new_password	= trim($_POST['password']);
		if(!($member_model->editMember(array('member_id'=>$member['member_id']),array('member_passwd'=>md5($new_password))))){
			showDialog("重置密码失败",'reload');
		}else{
			showDialog('重置密码成功','index.php?act=login&op=index','succ');
		}
	}

	/**
	 * 邮箱绑定验证
	 */
	public function bind_emailOp() {
	   $model_member = Model('member');
	   $uid = @base64_decode($_GET['uid']);
	   $uid = decrypt($uid,'');
	   list($member_id,$member_email) = explode(' ', $uid);

	   if (!is_numeric($member_id)) {
	       showMessage('验证失败',SHOP_SITE_URL,'html','error');
	   }

	   $member_info = $model_member->getMemberInfo(array('member_id'=>$member_id),'member_email');
	   if ($member_info['member_email'] != $member_email) {
	       showMessage('验证失败',SHOP_SITE_URL,'html','error');
	   }

	   $member_common_info = $model_member->getMemberCommonInfo(array('member_id'=>$member_id));
	   if (empty($member_common_info) || !is_array($member_common_info)) {
	       showMessage('验证失败',SHOP_SITE_URL,'html','error');
	   }
	   if (md5($member_common_info['auth_code']) != $_GET['hash'] || TIMESTAMP - $member_common_info['send_acode_time'] > 24*3600) {
	       showMessage('验证失败',SHOP_SITE_URL,'html','error');
	   }

	   $update = $model_member->editMember(array('member_id'=>$member_id),array('member_email_bind'=>1));
	   if (!$update) {
	       showMessage('系统发生错误，如有疑问请与管理员联系',SHOP_SITE_URL,'html','error');
	   }

	   $data = array();
	   $data['auth_code'] = '';
	   $data['send_acode_time'] = 0;
	   $update = $model_member->editMemberCommon($data,array('member_id'=>$_SESSION['member_id']));
	   if (!$update) {
	       showDialog('系统发生错误，如有疑问请与管理员联系');
	   }
	   showMessage('邮箱设置成功','index.php?act=member_security&op=index');

	}
	
	
	public function check_codeOp(){
		
		$mobile_code=trim($_GET['mobile_code']);
		
		if($_SESSION['verify_code'] ==$mobile_code && $_SESSION['user_mobile'] ==$_GET['mobile'])
		{
			echo 'true';
		}else{
			echo 'false';
		}
	}
	
	
	public function checked_codeOp(){
	
		$mobile_code=trim($_GET['mobile_code']);
		
		if($_SESSION['verify_code'] ==$mobile_code && $_SESSION['user_mobile'] ==$_GET['mobile'])
		{
			echo 'true';
		}else{
			echo 'false';
		}
	}

	
	public function  exit_mobileOp(){
		$model_member = Model('member');
		$check_member_mobile	= $model_member->getMemberInfo(array('member_mobile'=>$_GET['mobile']));
		if(is_array($check_member_mobile) and count($check_member_mobile)>0) {
			echo 'true';
		} else {
			echo 'false';
		}
	}
	
	
	/**
	 * 注册验证码
	 */
	public function send_codeOp(){
		 
		
		$obj_validate = new Validate();
		$obj_validate->validateparam = array(
				array("input"=>$_POST["mobile"], "require"=>"true", 'validator'=>'mobile',"message"=>'请正确填写手机号码'),
		);
		$error = $obj_validate->validate();
		if ($error != ''){
			exit(json_encode(array('state'=>'false','msg'=>$error)));
		}
		
		if (!checkSeccode($_POST['nchash'],$_POST['captcha'])){
			exit(json_encode(array('state'=>'false','msg'=>'图文验证码不正确')));
		}
		
		$model_member = Model('member');
		$condition = array();
		$condition['member_mobile'] = trim($_POST['mobile']);
	
	
		$type=$_POST['type'];
	
		$member_info = $model_member->getMemberInfo($condition,'member_id');
	
		if($type == 'reg')
		{
			if ($member_info) {
				
				exit(json_encode(array('state'=>'false','msg'=>'该手机号已被使用，请更换其它手机号')));
			}
		}elseif ($type == 'forget'){
			if (!$member_info) {
				exit(json_encode(array('state'=>'false','msg'=>'该手机号不存在')));
			}
		}else{
			
			exit(json_encode(array('state'=>'false','msg'=>'参数有误')));
		}
	
		
		$user_mobile=trim($_POST['mobile']);
	
		$verify_code = rand(100,999).rand(100,999);
		
		$data = array();
		
		$model_tpl = Model('mail_templates');
		$tpl_info = $model_tpl->getTplInfo(array('code'=>'modify_mobile'));
		$param = array();
		$param['site_name']	= C('site_name');
		$param['send_time'] = date('Y-m-d H:i',TIMESTAMP);
		$param['verify_code'] = $verify_code;
		$message	= ncReplaceText($tpl_info['content'],$param);
		//var_dump($message);die;
		$sms = new Sms();
		
		$result = $sms->send(trim($_POST["mobile"]),$message);
		
		if ($result) {
			$_SESSION['user_mobile']=$user_mobile;
			$_SESSION['verify_code']=$verify_code;
			exit(json_encode(array('state'=>true,'msg'=>'发送成功')));
		} else {
			exit(json_encode(array('state'=>false,'msg'=>'发送失败')));
		}
	
	}
}
