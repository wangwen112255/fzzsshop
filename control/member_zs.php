<?php
/**
 * 债权管理
 *
 *
 *
 ***/


defined('InShopNC') or exit('Access Invalid!');
class member_zsControl extends BaseMemberControl{
	public function __construct() {
		parent::__construct();
		Language::read('member_layout,member_voucher');
		//判断系统是否开启代金券功能
		if (intval(C('voucher_allow')) !== 1){
			showMessage(Language::get('member_voucher_unavailable'),urlShop('member', 'home'),'html','error');
		}
	}
	/*
	 * 债权咨询
	 */
	public function indexOp() {
        $this->zs_listOp() ;
    }
    /*
     * 我的债事备案
     */
    public function index1Op() {
        $this->zs_list1Op() ;
    }
	/*
	 *  个人债事备案
	 */
    public function zs_list1Op(){
        $condition = array();
		$condition['user_id']=$_SESSION['member_id'];
		//分页
        $page = new Page();
        $page->setEachNum(10);
        $page->setStyle('admin');
        //查询债事列表
        $model = Model('zq');
        $list = $model->getlistZq($condition,$page,'*','');

        self::profile_menu('zq');
        Tpl::output('show_page',$page->show());
		Tpl::output('list', $list);
        Tpl::showpage('member_zq.list');
    }

    /*
	 *  债权咨询
	 */
    public function zs_listOp(){
        $model = Model('zq');
        $condition['user_id']=$_SESSION['member_id'];
        $list = $model->listZq($condition, 10);
        Tpl::output('list', $list);
        Tpl::showpage('member_zq.list');
    }

	/*
	*
	*债事详情
	*
	*/
	public function show_zs(){
		Tpl::showpage('member_zq.show');
	}
	
	/**
	 * 用户中心右边，小导航
	 *
	 * @param string	$menu_type	导航类型
	 * @param string 	$menu_key	当前导航的menu_key
	 * @param array 	$array		附加菜单
	 * @return
	 */
	private function profile_menu($menu_key='') {
		$menu_array = array(
			1=>array('menu_key'=>'voucher_list','menu_name'=>Language::get('nc_myvoucher'),'menu_url'=>'index.php?act=member_voucher&op=voucher_list'),
		);
		Tpl::output('member_menu',$menu_array);
		Tpl::output('menu_key',$menu_key);
    }

}
