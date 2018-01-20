<?php
/**
 * 前台抢购
 *
 *
 *
 ***/
defined('InShopNC') or exit('Access Invalid!');

class mb_listControl extends BaseHomeControl {

    public function __construct() {
        parent::__construct();

        //读取语言包
        Language::read('member_groupbuy,home_cart_index');

       
    }

   

    /**
     * 政信页
     */
    public function indexOp()
    {
        Tpl::showpage('mb_list.index');
    }

}