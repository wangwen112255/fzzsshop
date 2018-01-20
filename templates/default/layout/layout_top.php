<?php defined('InShopNC') or exit('Access Invalid!');?>
<div id="append_parent"></div>
<div id="ajaxwaitid"></div>
<?php if ($output['hidden_nctoolbar'] != 1) {?>
<div id="ncToolbar" class="nc-appbar">
  <div class="nc-appbar-tabs" id="appBarTabs">
    <?php if ($_SESSION['is_login']) {?>
    <div class="user" nctype="a-barUserInfo">
      <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
      <p>我</p>
    </div>
    <div class="user-info" nctype="barUserInfo" style="display:none;"><i class="arrow"></i>
      <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/>
        <div class="frame"></div>
      </div>
      <dl>
        <dt>Hi, <?php echo $_SESSION['member_name'];?></dt>
        <dd>当前等级：<strong nctype="barMemberGrade"><?php echo $output['member_info']['level_name'];?></strong></dd>
        <dd>当前经验值：<strong nctype="barMemberExp"><?php echo $output['member_info']['member_exppoints'];?></strong></dd>
      </dl>
    </div>
    <?php } else {?>
    <div class="user" nctype="a-barLoginBox">
      <div class="avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
      <p style="color:#ffffff">未登录</p>
    </div>
    <div class="user-login-box" nctype="barLoginBox" style="display:none;"> <i class="arrow"></i> <a href="javascript:void(0);" class="close" nctype="close-barLoginBox" title="关闭">X</a>
      <form id="login_form" method="post" action="index.php?act=login&op=login" onsubmit="ajaxpost('login_form', '', '', 'onerror')">
        <?php Security::getToken();?>
        <input type="hidden" name="form_submit" value="ok" />
        <input name="nchash" type="hidden" value="<?php echo getNchash('login','index');?>" />
        <dl>
          <dt><strong>登录名</strong></dt>
          <dd>
            <input type="text" class="text" tabindex="1" autocomplete="off"  name="user_name" autofocus >
            <label></label>
          </dd>
        </dl>
        <dl>
          <dt><strong>登录密码</strong><a href="index.php?act=login&op=forget_password" target="_blank">忘记登录密码？</a></dt>
          <dd>
            <input tabindex="2" type="password" class="text" name="password" autocomplete="off">
            <label></label>
          </dd>
        </dl>
        <?php if(C('captcha_status_login') == '1') { ?>
        <dl>
          <dt><strong>验证码</strong><a href="javascript:void(0)" class="ml5" onclick="javascript:document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash('login','index');?>&t=' + Math.random();">更换验证码</a></dt>
          <dd>
            <input tabindex="3" type="text" name="captcha" autocomplete="off" class="text w130" id="captcha2" maxlength="4" size="10" />
            <img src="" name="codeimage" border="0" id="codeimage" class="vt">
            <label></label>
          </dd>
        </dl>
        <?php } ?>
        <div class="bottom">
          <input type="submit" class="submit" value="确认">
          <input type="hidden" value="<?php echo $_GET['ref_url']?>" name="ref_url">
          <a href="index.php?act=login&op=register&ref_url=<?php echo urlencode($output['ref_url']);?>" target="_blank">注册新用户</a> </div>
      </form>
    </div>
    <?php }?>

    <ul class="tools">
   <!--    <li><a href="javascript:void(0);" id="chat_show_user" class="chat">聊天<i id="new_msg" class="new_msg" style="display:none;"></i></a></li> -->
      <?php if (!$output['hidden_rtoolbar_cart']) { ?>
      <li><a href="javascript:void(0);" id="rtoolbar_cart" class="cart"><span style="color:#c0000a" class="iconfont icon-gouwuche1"></span>购物车<i id="rtoobar_cart_count" class="new_msg" style="display:none;"></i></a></li>
      <?php } ?>
      <?php if (!$output['hidden_rtoolbar_compare']) { ?>
      <li>
      <!-- <a  target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list"><span class="iconfont icon-zuji">足迹</a></span> -->
      <a  target="_blank" href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list" id="compare" class="compare"><span class="iconfont icon-zuji"></span>足迹</a>
      </li>
      <?php } ?>
      <li><a href="javascript:void(0);" id="gotop" class="gotop" ><span class="iconfont icon-top"></span>顶部</a></li>
    </ul>

    <div class="content-box" id="content-compare">
      <div class="top">
        <h3>商品对比</h3>胜多负少的方式的
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="comparelist">
        <div class="browse-history">
          <div class="part-title">
            <h4>最近浏览的商品</h4>
            <span style="float:right;"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_goodsbrowse&op=list">全部浏览历史</a></span>
          </div>
          <ul>
            <li class="no-goods"><img class="loading" src="<?php echo SHOP_TEMPLATES_URL;?>/images/loading.gif" /></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="content-box" id="content-cart" style="">
      <div class="top">
        <h3>我的购物车</h3>
        <a href="javascript:void(0);" class="close" title="隐藏"></a></div>
      <div id="rtoolbar_cartlist"></div>
    </div>
    <a id="activator" href="javascript:void(0);" class="nc-appbar-hide"></a> </div>
  <div class="nc-hidebar" id="ncHideBar">
    <div class="nc-hidebar-bg">
      <?php if ($_SESSION['is_login']) {?>
      <div class="user-avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
      <?php } else {?>
      <div class="user-avatar"><img src="<?php echo getMemberAvatar($_SESSION['avatar']);?>"/></div>
      <?php }?>
      <div class="frame"></div>
      <div class="show"></div>
    </div>
  </div>
</div>
<script type="text/javascript">
//返回顶部
backTop=function (btnId){
	var btn=document.getElementById(btnId);
	var scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	window.onscroll=set;
	btn.onclick=function (){
		btn.style.opacity="0.5";
		window.onscroll=null;
		this.timer=setInterval(function(){
		    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
			scrollTop-=Math.ceil(scrollTop*0.1);
			if(scrollTop==0) clearInterval(btn.timer,window.onscroll=set);
			if (document.documentElement.scrollTop > 0) document.documentElement.scrollTop=scrollTop;
			if (document.body.scrollTop > 0) document.body.scrollTop=scrollTop;
		},10);
	};
	function set(){
	    scrollTop = document.documentElement.scrollTop || document.body.scrollTop;
	    btn.style.opacity=scrollTop?'1':"0.5";
	}
};
backTop('gotop');

</script>
<?php } ?>
<div class="public-top-layout w" style="height: 31px;background:#f2f2f2;border-bottom: 1px solid #ddd;">
  <div class="topbar wrapper">
    <div class="user-entry">
      <a style="margin-left:30px;line-height: 31px;font:12px/1.6 tahoma,arial,sans-serif;color:#333;" href="<?php echo BASE_SITE_URL;?>/shop"><span class="iconfont icon-shouyedianji"></span>&nbsp;&nbsp;富之债事首页</a>
      
    </div>
    <div class="quick-menu">
      <dl style="text-align: right;width:280px" class="login-dl">
        <div style="height: 31px;padding-top: 4px;">
        <?php if($_SESSION['is_login'] == '1'){?>
        <?php echo $lang['nc_hello'];?> <span>
        <a href="<?php echo urlShop('member','home');?>"><?php echo $_SESSION['member_name'];?></a>
        <?php if ($output['member_info']['level_name']){ ?>
        <div class="nc-grade-mini" style="cursor:pointer;" onclick="javascript:go('<?php echo urlShop('pointgrade','index');?>');"><?php echo $output['member_info']['level_name'];?></div>
        <?php } ?>
        </span> <a href="<?php echo BASE_SITE_URL;?>"  title="<?php echo $lang['homepage'];?>" alt="<?php echo $lang['homepage'];?>"></a> <span>[<a href="<?php echo urlShop('login','logout');?>"><?php echo $lang['nc_logout'];?></a>] </span>
        <?php }else{?>
         <span><a style="line-height: 31px;text-align:center;font:12px/1.6 tahoma,arial,sans-serif;color:#666;" href="<?php echo urlShop('login');?>"><?php echo $lang['nc_login'];?></a></span>
          <a href="index.php?act=login&op=register&ref_url=<?php echo urlencode($output['ref_url']);?>" target="_blank">免费注册</a> 
        <?php }?>
        <a href="<?php echo BASE_SITE_URL;?>/wap" target="_blank">|手机版</a>
        <span style="margin-left:10px;"></span>
        </div>
      </dl>
       <dl>
        <dt style="margin-left: -5px;"><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order"><span style="font-weight: 700;margin-right: 2px;" class="iconfont icon-order"></span>我的订单</a></dt>
        <dd>
          <ul>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_new">待付款订单</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_send">待确认收货</a></li>
            <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_order&state_type=state_noeval">待评价交易</a></li>
          </ul>
        </dd>
      </dl>
        <dl>
        <dt><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=member_favorites&op=fglist"><span style="color: red" class="iconfont icon-gouwuche1"></span>&nbsp;购物车</a></dt>
        <dd>
          <ul>
            
          </ul>
        </dd>
      </dl>
      <dl>
        <dt>客户服务<i></i></dt>
        <dd>
          <ul>
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 2));?>">帮助中心</a></li>
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 5));?>">售后服务</a></li>
            <li><a href="<?php echo urlShop('article', 'article', array('ac_id' => 6));?>">客服中心</a></li>
          </ul>
        </dd>
      </dl>
          <dl>
        <dt>
        <a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index" title="免费开店">商家小店</a><i></i></dt>
        <dd>
          <ul>
        <li><a href="<?php echo SHOP_SITE_URL;?>/index.php?act=show_joinin&op=index" title="招商入驻">招商入驻</a></li>
            <li><a href="<?php echo urlShop('seller_login','show_login');?>" target="_blank" title="登录商家管理中心">商家登录</a></li>
          </ul>
        </dd>
      
      </dl>
      <?php
      if(!empty($output['nav_list']) && is_array($output['nav_list'])){
	      foreach($output['nav_list'] as $nav){
	      if($nav['nav_location']<1){
	      	$output['nav_list_top'][] = $nav;
	      }
	      }
      }
      if(!empty($output['nav_list_top']) && is_array($output['nav_list_top'])){
      	?>
      <dl>
        <dt>站点导航<i></i></dt>
        <dd>
          <ul>
            <?php foreach($output['nav_list_top'] as $nav){?>
            <li><a
        <?php
        if($nav['nav_new_open']) {
            echo ' target="_blank"';
        }
        echo ' href="';
        switch($nav['nav_type']) {
        	case '0':echo $nav['nav_url'];break;
        	case '1':echo urlShop('search', 'index', array('cate_id'=>$nav['item_id']));break;
        	case '2':echo urlShop('article', 'article', array('ac_id'=>$nav['item_id']));break;
        	case '3':echo urlShop('activity', 'index', array('activity_id'=>$nav['item_id']));break;
        }
        echo '"';
        ?>><?php echo $nav['nav_title'];?></a></li>
            <?php }?>
          </ul>
        </dd>
      </dl>
      <?php }?>
	
    </div>
  </div>
</div>
<script type="text/javascript">
//动画显示边条内容区域
$(function() {
	$(function() {
		$('#activator').click(function() {
			$('#content-cart').animate({'right': '-250px'});
			$('#content-compare').animate({'right': '-150px'});
			$('#ncToolbar').animate({'right': '-60px'}, 300,
			function() {
				$('#ncHideBar').animate({'right': '59px'},	300);
			});
	        $('div[nctype^="bar"]').hide();
		});
		$('#ncHideBar').click(function() {
			$('#ncHideBar').animate({
				'right': '-79px'
			},
			300,
			function() {
				$('#content-cart').animate({'right': '-250px'});
				$('#content-compare').animate({'right': '-250px'});
				$('#ncToolbar').animate({'right': '0'},300);
			});
		});
	});
  //我的足迹
 //    $("#compare").click(function(){
 //     load_history_information();
 //     $(this).unbind('mouseover');
 //    	if ($("#content-compare").css('right') == '-210px') {
 // 		   loadCompare(false);
 // 		   $('#content-cart').animate({'right': '-210px'});
 //  		   $("#content-compare").animate({right:'35px'});
 //    	} else {
 //    		$(".close").click();
 //    		$(".chat-list").css("display",'none');
 //        }
	// });
    $("#rtoolbar_cart").click(function(){
        if ($("#content-cart").css('right') == '-210px') {
         	$('#content-compare').animate({'right': '-210px'});
    		$("#content-cart").animate({right:'35px'});
    		if (!$("#rtoolbar_cartlist").html()) {
    			$("#rtoolbar_cartlist").load('index.php?act=cart&op=ajax_load&type=html');
    		}
        } else {
        	$(".close").click();
        	$(".chat-list").css("display",'none');
        }
	});
	$(".close").click(function(){
		$(".content-box").animate({right:'-210px'});
      });

	$(".quick-menu dl").hover(function() {
		$(this).addClass("hover");
	},
	function() {
		$(this).removeClass("hover");
	});

    // 右侧bar用户信息
    $('div[nctype="a-barUserInfo"]').click(function(){
        $('div[nctype="barUserInfo"]').toggle();
    });
    // 右侧bar登录
    $('div[nctype="a-barLoginBox"]').click(function(){
        $('div[nctype="barLoginBox"]').toggle();
        document.getElementById('codeimage').src='<?php echo SHOP_SITE_URL?>/index.php?act=seccode&op=makecode&nchash=<?php echo getNchash('login','index');?>&t=' + Math.random();
    });
    $('a[nctype="close-barLoginBox"]').click(function(){
        $('div[nctype="barLoginBox"]').toggle();
    });
    <?php if ($output['cart_goods_num'] > 0) { ?>
    $('#rtoobar_cart_count').html(<?php echo $output['cart_goods_num'];?>).show();
    <?php } ?>
});
</script>