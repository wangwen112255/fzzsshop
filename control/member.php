<?php
/**
 * 会员中心——账户概览
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');

class memberControl extends BaseMemberControl{

    /**
     * 我的商城
     */
    public function homeOp() {
        Tpl::showpage('member_home');
    }

    public function ajax_load_member_infoOp() {

        $member_info = $this->member_info;
        $member_info['security_level'] = Model('member')->getMemberSecurityLevel($member_info);
        
        //代金券数量
        $member_info['voucher_count'] = Model('voucher')->getCurrentAvailableVoucherCount($_SESSION['member_id']);
        Tpl::output('home_member_info',$member_info);

        Tpl::showpage('member_home.member_info','null_layout');
    }

    public function ajax_load_order_infoOp() {
        $model_order = Model('order');

        //交易提醒 - 显示数量
        $member_info['order_nopay_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'NewCount');
        $member_info['order_noreceipt_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'SendCount');
        $member_info['order_noeval_count'] = $model_order->getOrderCountByID('buyer',$_SESSION['member_id'],'EvalCount');
        Tpl::output('home_member_info',$member_info);

        //交易提醒 - 显示订单列表
        $condition = array();
        $condition['buyer_id'] = $_SESSION['member_id'];
        $condition['order_state'] = array('in',array(ORDER_STATE_NEW,ORDER_STATE_PAY,ORDER_STATE_SEND,ORDER_STATE_SUCCESS));
        $order_list = $model_order->getNormalOrderList($condition,'','*','order_id desc',3,array('order_goods'));
        
        foreach ($order_list as $order_id => $order) {
            //显示物流跟踪
            $order_list[$order_id]['if_deliver'] = $model_order->getOrderOperateState('deliver',$order);
            //显示评价
            $order_list[$order_id]['if_evaluation'] = $model_order->getOrderOperateState('evaluation',$order);
            //显示支付
            $order_list[$order_id]['if_payment'] = $model_order->getOrderOperateState('payment',$order);
            //显示收货
            $order_list[$order_id]['if_receive'] = $model_order->getOrderOperateState('receive',$order);
        }
        
        Tpl::output('order_list',$order_list);
        
        //取出购物车信息
        $model_cart = Model('cart');
        $cart_list	= $model_cart->listCart('db',array('buyer_id'=>$_SESSION['member_id']),3);
        Tpl::output('cart_list',$cart_list);
        Tpl::showpage('member_home.order_info','null_layout');
    }

    public function ajax_load_goods_infoOp() {
        //商品收藏
        $favorites_model = Model('favorites');
        $favorites_list = $favorites_model->getGoodsFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 7);
        if (!empty($favorites_list) && is_array($favorites_list)){
            $favorites_id = array();//收藏的商品编号
            foreach ($favorites_list as $key=>$favorites){
                $fav_id = $favorites['fav_id'];
                $favorites_id[] = $favorites['fav_id'];
                $favorites_key[$fav_id] = $key;
            }
            $goods_model = Model('goods');
            $field = 'goods.goods_id,goods.goods_name,goods.store_id,goods.goods_image,goods.goods_price,goods.evaluation_count,goods.goods_salenum,goods.goods_collect,store.store_name,store.member_id,store.member_name,store.store_qq,store.store_ww,store.store_domain';
            $goods_list = $goods_model->getGoodsStoreList(array('goods_id' => array('in', $favorites_id)), $field);
            $store_array = array();//店铺编号
            if (!empty($goods_list) && is_array($goods_list)){
                $store_goods_list = array();//店铺为分组的商品
                foreach ($goods_list as $key=>$fav){
                    $fav_id = $fav['goods_id'];
                    $fav['goods_member_id'] = $fav['member_id'];
                    $key = $favorites_key[$fav_id];
                    $favorites_list[$key]['goods'] = $fav;
                }
            }
        }
        Tpl::output('favorites_list',$favorites_list);
        
        //店铺收藏
        $favorites_list = $favorites_model->getStoreFavoritesList(array('member_id'=>$_SESSION['member_id']), '*', 6);
        if (!empty($favorites_list) && is_array($favorites_list)){
            $favorites_id = array();//收藏的店铺编号
            foreach ($favorites_list as $key=>$favorites){
                $fav_id = $favorites['fav_id'];
                $favorites_id[] = $favorites['fav_id'];
                $favorites_key[$fav_id] = $key;
            }
            $store_model = Model('store');
            $store_list = $store_model->getStoreList(array('store_id'=>array('in', $favorites_id)));
            if (!empty($store_list) && is_array($store_list)){
                foreach ($store_list as $key=>$fav){
                    $fav_id = $fav['store_id'];
                    $key = $favorites_key[$fav_id];
                    $favorites_list[$key]['store'] = $fav;
                }
            }
        }
        Tpl::output('favorites_store_list',$favorites_list);
        $goods_count_new = array();
        if (!empty($favorites_id)) {
            foreach ($favorites_id as $v){
                $count = Model('goods')->getGoodsCommonOnlineCount(array('store_id' => $v));
                $goods_count_new[$v] = $count;
            }
        }
        Tpl::output('goods_count',$goods_count_new);
        Tpl::showpage('member_home.goods_info','null_layout');
    }

    public function ajax_load_sns_infoOp() {
        //我的足迹
        $goods_list = Model('goods_browse')->getViewedGoodsList($_SESSION['member_id'],20);
        $viewed_goods = array();
        if(is_array($goods_list) && !empty($goods_list)) {
            foreach ($goods_list as $key => $val) {
                $goods_id = $val['goods_id'];
                $val['url'] = urlShop('goods', 'index', array('goods_id' => $goods_id));
                $val['goods_image'] = thumb($val, 240);
                $viewed_goods[$goods_id] = $val;
            }
        }
        Tpl::output('viewed_goods',$viewed_goods);
        
        //我的圈子
        $model = Model();
        $circlemember_array = $model->table('circle_member')->where(array('member_id'=>$_SESSION['member_id']))->select();
        if(!empty($circlemember_array)) {
            $circlemember_array = array_under_reset($circlemember_array, 'circle_id');
            $circleid_array = array_keys($circlemember_array);
            $circle_list = $model->table('circle')->where(array('circle_id'=>array('in', $circleid_array)))->limit(6)->select();
            Tpl::output('circle_list', $circle_list);
        }
        
        //好友动态
        $model_fd = Model('sns_friend');
        $fields = 'member.member_id,member.member_name,member.member_avatar';
        $follow_list = $model_fd->listFriend(array('limit'=>15,'friend_frommid'=>"{$_SESSION['member_id']}"),$fields,'','detail');
        $member_ids = array();$follow_list_new = array();
        if (is_array($follow_list)) {
            foreach ($follow_list as $v) {
                $follow_list_new[$v['member_id']] = $v;
                $member_ids[] = $v['member_id'];
            }
        }
        $tracelog_model = Model('sns_tracelog');
        //条件
        $condition = array();
        $condition['trace_memberid'] = array('in',$member_ids);
        $condition['trace_privacy'] = 0;
        $condition['trace_state'] = 0;
        $tracelist = Model()->table('sns_tracelog')->where($condition)->field('count(*) as _count,trace_memberid')->group('trace_memberid')->limit(5)->select();
        $tracelist_new = array();$follow_list = array();
        if (!empty($tracelist)){
            foreach ($tracelist as $k=>$v){
                $tracelist_new[$v['trace_memberid']] = $v['_count'];
                $follow_list[] = $follow_list_new[$v['trace_memberid']];
            }
        }
        Tpl::output('tracelist',$tracelist_new);
        Tpl::output('follow_list',$follow_list);
        Tpl::showpage('member_home.sns_info','null_layout');
    }

    /**
     * 设置常用菜单
     */
    public function common_operationsOp() {
        $type = $_GET['type'];
        $value = $_GET['value'];
        if (!in_array($type, array('add', 'del')) || empty($value)) {
            echo false;exit;
        }
        $quicklink = $this->quicklink;
        if ($type == 'add') {
            if (!empty($quicklink)) {
                array_push($quicklink, $value);
            } else {
                $quicklink[] = $value;
            }
        } else {
            $quicklink = array_diff($quicklink, array($value));
        }
        $quicklink = array_unique($quicklink);
        $quicklink = implode(',', $quicklink);
        $result = Model('member')->editMember(array('member_id' => $_SESSION['member_id']), array('member_quicklink' => $quicklink));
        if ($result) {
            echo true;exit;
        } else {
            echo false;exit;
        }
    }

    public function zqOp()
    {
        Tpl::showpage('member_zq','null_layout');
    }

    public function saveZqOp()
    {
        $model =  Model('zq');

        $data['name'] = trim($_POST['name']);
        $data['numcard'] = trim($_POST['numcard']);
        $data['zw_name'] = trim($_POST['zw_name']);
        $data['mobile'] = trim($_POST['mobile']);
        $data['zw_mobile'] = trim($_POST['zw_mobile']);
		$data['zw_numcard'] = trim($_POST['zw_numcard']);
        $data['total'] = trim($_POST['total']);
        if($_FILES['zw_image_1']){
			$zw_image_1=$this->file_upload($_FILES['zw_image_1']);
		}
        if($_FILES['zw_image_2']){
			$zw_image_2=$this->file_upload($_FILES['zw_image_2']);
		}
		if($_FILES['zw_image_3']){
			$zw_image_3=$this->file_upload($_FILES['zw_image_3']);
		}
		if($_FILES['zw_image_4']){
			$zw_image_4=$this->file_upload($_FILES['zw_image_4']);
		}
		if($_FILES['zw_image_5']){
			$zw_image_5=$this->file_upload($_FILES['zw_image_5']);
		}
		
		
        if(!$zw_image_1&&!$zw_image_2&&!$zw_image_3&&!$zw_image_4&&!$zw_image_5)
        {
        	showDialog("借款合同扫描件上传失败");
        }
        
        $card_img_1=$this->file_upload($_FILES['card_img_1']);
        if(!$card_img_1)
        {
        	showDialog("债权人身份证扫描件(正)上传失败");
        }
        
        $card_img_2=$this->file_upload($_FILES['card_img_2']);
        if(!$card_img_2)
        {
        	showDialog("债权人身份证扫描件(反)上传失败");
        }
        if($_FILES['card_img_3']){
			$card_img_3=$this->file_upload($_FILES['card_img_3']);
			
		}
		if($_FILES['card_img_4']){
			$card_img_4=$this->file_upload($_FILES['card_img_4']);
			
		}
        $data['zw_image_1']   = $zw_image_1;
		$data['zw_image_2']   = $zw_image_2;
		$data['zw_image_3']   = $zw_image_3;
		$data['zw_image_4']   = $zw_image_4;
		$data['zw_image_5']   = $zw_image_5;
        $data['card_img_1'] = $card_img_1;
        $data['card_img_2'] = $card_img_2;
		$data['card_img_3'] = $card_img_3;
		$data['card_img_4'] = $card_img_4;
        $data['created_at'] = time();
		$data['user_id']    = $_SESSION['member_id'];
		$data['loantime'] 	= $_POST['query_start_date'];
		$data['tj_name'] = trim($_POST['tj_name']);
		$data['province']=$_POST['province'];
		$data['city']=$_POST['city'];
		$data['county']=$_POST['district'];
	//	$data['district']=$_POST['district'];
		$model_pdr = Model('predeposit');
		$data['pay_id'] = $pay_sn = $model_pdr->makeSn();
		$data['status']='1';
		$res=$model->saveZq($data);
			//redirect('index.php?act=buy&op=zs_pay&pay_sn='.$pay_sn);
		if($res){
			$this->sendOp( $_SESSION['member_mobile']);
		}
        showMessage('提交成功请等待客服联系您。', 'index.php?act=member_zs&op=index', 'html', 'success');
    }
    
    private function file_upload($file){
    	
    	//得到文件名称
    	$name = $file['name'];
    	$type = strtolower(substr($name,strrpos($name,'.')+1)); //得到文件类型，并且都转化成小写
    	$allow_type = array('jpg','jpeg','gif','png'); //定义允许上传的类型
    	//判断文件类型是否被允许上传

    	if(!in_array($type, $allow_type)){
    		//如果不被允许，则直接停止程序运行
    		return false;
    	}
    	   	
    	// 生成的文件名
    	$tmp_name = sprintf('%010d',time() - 946656000)
    	. sprintf('%03d', microtime() * 1000)
    	. sprintf('%04d', mt_rand(0,9999));
    	
    	$upload_path = "../".DIR_UPLOAD.DS.ATTACH_PATH.DS.'rechargeimg'.DS;

    	$new_filename=$tmp_name.".".$type;
    	
    	if(move_uploaded_file($file['tmp_name'],$upload_path.$new_filename)){
    		return DIR_UPLOAD.DS.ATTACH_PATH.DS.'rechargeimg'.DS.$new_filename;
    	}else{
    		return false;
    	}
    	 
    	
    }
	
	/**
	 * 短信提醒
	 */
	public function sendOp($mobile)
	{
		$model_tpl = Model('mail_templates');
		$tpl_info = $model_tpl->getTplInfo(array('code'=>'zq_code'));
		$param=array();
		$param['site_name']	= C('site_name');
		$message = ncReplaceText($tpl_info['content'],$param);
		$sms = new Sms();
		
		$result = $sms->send($mobile,$message);
		return $result;
	}
}
