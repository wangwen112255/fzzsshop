<?php defined('InShopNC') or exit('Access Invalid!');?>

<div class="wrap">
  <div class="tabmenu">
    <?php include template('layout/submenu');?>
  </div>
  <form id="voucher_list_form" method="get">
    <table class="ncm-search-table">
      <input type="hidden" id='act' name='act' value='member_voucher' />
      <input type="hidden" id='op' name='op' value='voucher_list' />
      <tr>
        <td>&nbsp;</td>
        <td class="w100 tr"><select name="select_detail_state">
            <option value="0" <?php if (!$_GET['select_detail_state'] == '0'){echo 'selected=true';}?>> <?php echo $lang['voucher_voucher_state']; ?> </option>
            <?php if (!empty($output['voucherstate_arr'])){?>
            <?php foreach ($output['voucherstate_arr'] as $k=>$v){?>
            <option value="<?php echo $k;?>" <?php if ($_GET['select_detail_state'] == $k){echo 'selected=true';}?>> <?php echo $v;?> </option>
            <?php }?>
            <?php }?>
          </select></td>
        <td class="w70 tc"><label class="submit-border">
            <input type="submit" class="submit" onclick="submit_search_form()" value="<?php echo $lang['nc_search'];?>" />
          </label></td>
      </tr>
    </table>
  </form>
  <table class="ncm-default-table">
    <thead>
      <tr>
        
        <th class="w200">债权人姓名</th>
        <th class="w200">债权人手机号</th>
		<th class="w200">备案金额</th>
        <th class="w200">债事备案日期</th>
		
        <th class="w200"><?php echo $lang['voucher_voucher_state'];?></th>
        <th class="w200"><?php echo $lang['nc_handle'];?></th>
      </tr>
    </thead>
    <tbody>
      <?php  if (count($output['list'])>0) { ?>
      <?php foreach($output['list'] as $val) { ?>
      <tr class="bd-line">
        <td><?php echo $val['name'];?></td>
        <td><?php echo $val['mobile'];?></td>
        <td><?php echo $val['total'];?></td>
        <td  class="goods-time"><?php echo date("Y-m-d",$val['created_at']);?></td>
        <td><?php if($val['status']==1){echo "审核中";}elseif( $val['status']==2){echo "已审核";}elseif( $val['status']==3){echo "审核通过";}elseif( $val['status']==4){echo "审核不通过";}?></td>
        <td class="ncm-table-handle">
          <span><a href="<?php echo urlShop('member_zs', 'show_zs', array('id'=>$val['id']));?>" ><i class="icon-shopping-cart"></i><p>查看详情</p></a></span>
          
          <a href="index.php?act=member_order&op=show_order&order_id=<?php echo $val['voucher_order_id'];?>"><?php echo 123;?></a>
          </td>
      </tr>
      <?php }?>
      <?php } else { ?>
      <tr>
        <td colspan="20" class="norecord"><div class="warning-option"><i>&nbsp;</i><span><?php echo $lang['no_record'];?></span></div></td>
      </tr>
      <?php } ?>
    </tbody>
    <?php  if (count($output['list'])>0) { ?>
    <tfoot>
      <tr>
        <td colspan="20"><div class="pagination"><?php echo $output['show_page'];?></div></td>
      </tr>
    </tfoot>
    <?php } ?>
  </table>
</div>
