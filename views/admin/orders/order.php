
<section class="title">
	<h4><?php echo shop_lang('shop:orders:order'); ?> - ( <?php echo shop_lang('shop:orders:account'); ?>: <?php echo  $customer->display_name; ?> )</h4>
	<h4 style="float:right">
		<a href="{{ url:site }}shop/" class='button'><?php echo shop_lang('shop:orders:new'); ?></a>
		<?php echo anchor('admin/shop/orders', shop_lang('shop:orders:view_all'), 'class="button"'); ?>
	</h4>		
</section>
<section class="item">
<div class="content">
<fieldset>
	<div id="order-tab" class="form_inputs">
		<ul>
			<li>
				<label>
					<?php echo shop_lang('shop:orders:order_id'); ?>:
					<small>
						<?php echo shop_lang('shop:orders:order_id_description'); ?>:
					</small>
				</label>
				<div class="value">
					<?php  echo $order->id; ?>
				</div>
			</li>   
			<li>
				<label>
					<?php echo shop_lang('shop:orders:order_status'); ?>:
					<small>
						<?php echo shop_lang('shop:orders:order_status_description'); ?>:
					</small>
				</label>
				<div class="value">
					<?php echo shop_lang('shop:orders:'.$order->status); ?>
				</div>
			</li>					  
		 </ul>	
	</div>	
</fieldset>
	<div class="tabs">

		<ul class="tab-menu">
			<li><a href="#order-tab"><span><?php echo shop_lang('shop:orders:details'); ?></span></a></li>
			<li><a href="#billing-tab"><span><?php echo shop_lang('shop:orders:billing'); ?></span></a></li>
			<li><a href="#delivery-tab"><span><?php echo shop_lang('shop:orders:shipping'); ?></span></a></li>
			<li><a href="#contents-tab"><span><?php echo shop_lang('shop:orders:items'); ?></span></a></li>
			<li><a href="#message-tab"><?php echo shop_lang('shop:orders:messages'); ?></a></li>
			<li><a href="#transactions-tab"><span><?php echo shop_lang('shop:orders:transactions'); ?></span></a></li>
			<li><a href="#notes-tab"><span><?php echo shop_lang('shop:orders:notes'); ?></span></a></li>
			<li><a href="#actions-tab"><span><?php echo shop_lang('shop:orders:actions'); ?></span></a></li>
		</ul>
		<div id="order-tab" class="form_inputs">
			<fieldset>
				<ul>			
					<?php if ($order->user_id && $customer): ?>
						<li>
							<label><?php echo shop_lang('shop:orders:customer'); ?>:</label>
							<div class="value">
								<?php echo anchor('user/' . $customer->id, $customer->display_name,array('class'=>'nc_links')); ?>
							</div>
						</li>
					<?php endif; ?>
					<li>
						<label><?php echo shop_lang('shop:orders:items_amount'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_items ); ?><br />
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:shipping_amount'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_shipping); ?><br />
						</div>
					</li>		
					<li>
						<label><?php echo shop_lang('shop:orders:order_total'); ?></label>
						<div class="value">
							<?php echo nc_format_price($order->cost_total); ?><br />
						</div>
					</li>									
					<li>
						<label><?php echo shop_lang('shop:orders:date_order_placed'); ?></label>
						<div class="value">
							 <strong> <?php echo date('d / M / Y ', $order->order_date); ?> </strong> @ <?php echo date('H:i:s',$order->order_date) ;?> <small><em>{ <?php echo timespan($order->order_date); ?> <?php echo shop_lang('shop:orders:ago'); ?> }</em></small>
						</div>
					</li>
					<li>
					
						<label><?php echo shop_lang('shop:orders:payment_type'); ?></label>
						<div class="value">
							<a href="./admin/shop/gateways/edit/<?php echo $order->gateway_id; ?>"  title="Click to view <?php echo $payments->title; ?>"  class="tooltip-s nc_links"><?php echo $payments->title; ?></a>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:shipping_method'); ?></label>
						<div class="value">
							<a href="./admin/shop/shipping/edit/<?php echo $order->shipping_id; ?>" title="Click to view <?php echo $shipping_method->title; ?>" class="tooltip-s nc_links"><?php echo $shipping_method->title; ?></a>
						</div>
					</li>	
					<li>
						<label><?php echo shop_lang('shop:orders:ip_address'); ?></label>
						<div class="value">
							 <strong><div id="ip_of_order"><?php echo $order->ip_address ;?></div></strong> <br/><a href="#" class="nc_links add_to_blacklist">Add this to the BlackList</a>
						</div>
					</li>										  			
				</ul>
			</fieldset>
		</div>
		<div id="billing-tab" class="form_inputs">
			<fieldset>
				<ul>
					<li>
						<label><?php echo shop_lang('shop:orders:email'); ?></label>
						<div class="value">
							<?php echo $invoice->email; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:first_name'); ?></label>
						<div class="value">
							<?php echo $invoice->first_name; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:last_name'); ?></label>
						<div class="value">
							<?php echo $invoice->last_name; ?>
						</div>
					</li>
					<?php if ($invoice->company != ""): ?>
					<li>
						<label><?php echo shop_lang('shop:orders:company'); ?></label>
						<div class="value">
							<?php echo $invoice->company; ?>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<label><?php echo shop_lang('shop:orders:address'); ?></label>
						<div class="value">
							<?php echo $invoice->address1; ?> , 
							<?php echo $invoice->address2; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:city'); ?></label>
						<div class="value">
							<?php echo $invoice->city; ?>
						</div>
					</li>
					<?php if ($invoice->state != ""): ?>
					<li>
						<label><?php echo shop_lang('shop:orders:state'); ?></label>
						<div class="value">
							<?php echo $invoice->state; ?>
						</div>
					</li>
					<?php endif; ?>
					<?php if ($invoice->country != ""): ?>
					<li>
						<label><?php echo shop_lang('shop:orders:country'); ?></label>
						<div class="value">
							<?php echo $invoice->country; ?>
						</div>
					</li>
					<?php endif; ?>
					<li>
						<label><?php echo shop_lang('shop:orders:zip'); ?></label>
						<div class="value">
							<?php echo $invoice->zip; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:phone'); ?></label>
						<div class="value">
							<?php echo $invoice->phone; ?>
						</div>
					</li>
				</ul>
			</fieldset>
		</div>
		<div id="delivery-tab" class="form_inputs">
			<fieldset>
				<ul>
					<li>
						<label><?php echo shop_lang('shop:orders:email'); ?></label>
						<div class="value">
							<?php echo $shipping_address->email; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:first_name'); ?></label>
						<div class="value">
							<?php echo $shipping_address->first_name; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:last_name'); ?></label>
						<div class="value">
							<?php echo $shipping_address->last_name; ?>
						</div>
					</li>
					
					<?php if ($shipping_address->company != ""): ?>
					<li>
						<label><?php echo shop_lang('shop:orders:company'); ?></label>
						<div class="value">
							<?php echo $shipping_address->company; ?>
						</div>
					</li>
					<?php endif; ?>

					<li>
						<label><?php echo shop_lang('shop:orders:address'); ?></label>
						<div class="value">
							<?php echo $shipping_address->address1; ?>,
							<?php echo $shipping_address->address2; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:city'); ?></label>
						<div class="value">
							<?php echo $shipping_address->city; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:state'); ?></label>
						<div class="value">
							<?php echo $shipping_address->state; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:country'); ?></label>
						<div class="value">
							<?php echo $shipping_address->country; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:zip'); ?></label>
						<div class="value">
							<?php echo $shipping_address->zip; ?>
						</div>
					</li>
					<li>
						<label><?php echo shop_lang('shop:orders:phone'); ?></label>
						<div class="value">
							<?php echo $shipping_address->phone; ?>
						</div>
					</li>
				</ul>
			</fieldset>
		</div>
		
		<div id="contents-tab" class="form_inputs">
			<fieldset>
				<table>
					<thead>
						<tr>
							<th><?php echo shop_lang('shop:orders:image'); ?></th>
							<th><?php echo shop_lang('shop:orders:item'); ?></th>
							<th><?php echo shop_lang('shop:orders:item_code' ,'item_'); ?></th>
							<th><?php echo shop_lang('shop:orders:price_base', 'price_'); ?></th>
							<th><?php echo shop_lang('shop:orders:qty'); ?></th>
							<th><?php echo shop_lang('shop:orders:price'); ?></th>
							<th><?php echo shop_lang('shop:orders:subtotal'); ?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($contents as $item): ?>
							<tr>
								<td><?php echo img(site_url('files/thumb/' . $item->cover_id)); ?></td>
								<td><?php echo anchor('shop/product/' . $item->slug, $item->name, array('class'=>'nc_links')); ?>
								<br /><br />
									<?php 
										
										$opt = json_decode($item->options) ; 
										
										if ($opt !=NULL)
										{
									
											foreach ($opt as $key=>$val)
											{
												if($val->type == 'file')
												{
													echo "<br /><br />";
													echo $val->name. ' : <a href="files/download/'.$val->value.'">'.shop_lang('shop:orders:download').'</a>';
												}
												else
												{
													echo "<br /><br />";
													echo $val->name. ' : '. $val->value;
												}

											}

										} 
									?>		
								
								</td>
								<td><?php echo $item->code; ?></td>
								<td><?php echo nc_format_price( $item->cost_base ); ?></td>
								<td><?php echo $item->qty; ?></td>
								<td><?php echo nc_format_price( $item->cost_item ); ?></td>
								<td><?php echo nc_format_price( $item->cost_sub ); ?></td>
							</tr>
					
						<?php endforeach; ?>
					</tbody>
				</table>
			</fieldset>
		</div>
		<div id="message-tab" class="form_inputs">
			
			<fieldset>
			 	<strong><?php echo shop_lang('shop:orders:messages'); ?></strong>
			 	
			 	<table class='fixed' >
					<thead class='fixed'>
							<tr>
								<th><?php echo shop_lang('shop:orders:from'); ?></th>
								<th><?php echo shop_lang('shop:orders:date'); ?></th>
								<th><?php echo shop_lang('shop:orders:status'); ?></th>
								<th><?php echo shop_lang('shop:orders:subject'); ?></th>
								<th><?php echo shop_lang('shop:orders:message'); ?></th>
							</tr>
					</thead>
				</table>	   
					  	
			 	<div style="height:200px;overflow-x:none;overflow-y:auto;">
				 	<table class='fixed' >
						<tbody class='fixed'>
								<?php foreach ($messages as $item): ?>
									<tr>
										<td><?php echo $item->user_name; ?></td>
										<td><?php echo date('d/m/Y', $item->date_sent); ?></td>
										<td><?php echo $item->status; ?></td>
										<td><?php echo $item->subject; ?></td>
										<td><?php echo $item->message; ?></td>
									</tr>
								<?php endforeach; ?>
						</tbody>
					</table>
				</div>

				<div style="display:none;">
					<h4><?php echo shop_lang('shop:orders:view_message'); ?></h4>
					<div id="message_preview_window">
					   <?php echo shop_lang('shop:orders:loading_messages'); ?>
					</div>
				</div>

				<strong><?php echo shop_lang('shop:orders:compose'); ?></strong> <br /><br /><br />
				<?php echo form_open('admin/shop/orders/messages'); ?>
				<?php echo form_hidden('order_id', $order->id); ?>
				<?php echo form_hidden('user_name', ''.$user->username); ?>
			
				<div class="form_inputs">
					<ul>
						<li>
							<?php echo shop_lang('shop:orders:subject'); ?>
							<div class="">
								<?php echo form_input(array( 'name' => 'subject', 'value' => set_value('subject'))); ?>
							</div>
						</li>
						<li>
							<?php echo shop_lang('shop:orders:message'); ?>
							<div class="">
								<?php echo form_textarea(array( 'name' => 'message', 'value' => set_value('message'), 'rows' => 3)); ?>
							</div>
						</li>
						<li>
							<div class="">
								<?php echo form_submit('save', shop_lang('shop:brands:send')); ?>
							</div>
						</li>
					</ul>
				</div>
				<?php echo form_close(); ?>
			</fieldset>
		</div>
		<div id="transactions-tab" class="form_inputs">
			<div style="overflow-y:scroll;max-height:300px;">
				<fieldset>
					<table>
						<thead>
							<tr>
								<th><?php echo shop_lang('shop:orders:status'); ?></th>
								<th><?php echo shop_lang('shop:orders:reason'); ?></th>
								<th><?php echo shop_lang('shop:orders:received'); ?></th>
								<th><?php echo shop_lang('shop:orders:refunded'); ?></th>
								<th><?php echo shop_lang('shop:orders:user'); ?></th>
								<th><?php echo shop_lang('shop:orders:date'); ?></th>
								<th><?php echo shop_lang('shop:orders:action'); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($transactions as $item): ?>
								<tr onclick='javascript:view(<?php echo $item->id;?>)' class='clickable_row'>
									<td><a class='status_img_icon status_img_<?php echo $item->status; ?>'> </a></td>
									<td><?php echo $item->reason; ?></td>
									<td><?php echo ($item->amount != 0) ? nc_format_price($item->amount) : ' - '  ; ?></td>
									<td><?php echo ($item->refund != 0) ? nc_format_price($item->refund) : ' - '  ; ?></td>
									<td><?php echo $item->user; ?></td>
									<td><?php echo date('Y-m-d H:i:s', $item->timestamp); ?></td>
									<td><a class='img_icon img_view' href='javascript:view(<?php echo $item->id;?>)' > </a></td>

								</tr>
							<?php endforeach; ?>
						</tbody>
					</table>
				</fieldset>
			</div>
			<div style="overflow-y:scroll;max-height:400px;">
				<div id="txn_panel">
				
				</div>
			</div>			
		</div>
		<div id="notes-tab" class="form_inputs">
			
				<fieldset>
 				<?php echo form_open('admin/shop/orders/notes'); ?>
				<?php echo form_hidden('order_id', $order->id); ?>
				<?php echo form_hidden('user_name', ''.$user->username); ?>
				<?php echo form_hidden('user_id', ''.$user->id); ?>
					<ul>
						<li>
							<label>
								<?php /*echo lang('message');*/ ?>
							</label>
							<div class="">
								<?php echo form_textarea(array( 'name' => 'message', 'value' => set_value('message'), 'rows' => 3)); ?>
							</div>
						</li>
						<li>
							<div class="">
								<?php echo form_submit('save', shop_lang('shop:orders:save')); ?>
							</div>
						</li>
					</ul>
				<?php echo form_close(); ?>				
				</fieldset>
				<div style="overflow-y:scroll;height:250px;">
				<fieldset>
							<?php foreach ($notes as $item): ?>
						   		<?php echo ' <fieldset>'; ?> 
						  
	 							<i><?php echo $item->user_id; ?> -  <?php echo date('Y-m-d H:i:s', $item->date); ?></i> <br />
								<?php echo $item->message; ?>
							  	<?php echo ' </fieldset>'; ?> 
							<?php endforeach; ?>
				</fieldset>
			</div>
		</div>		
		<div id="actions-tab" class="form_inputs">
			<fieldset>
				<ul>
						<?php 
						$show_cancel = TRUE;
						$show_close = TRUE;
					   
					   	switch($order->status) 
						{				
							case 'placed';
							case 'pending';
							case 'processing';												
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/paid', shop_lang('shop:orders:mark_as_paid') ,'class="button blue"')."</div></li>";
								break;
							case 'closed';
							case 'cancelled';
								$show_cancel = FALSE;
								$show_close = FALSE;
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/reopen', shop_lang('shop:orders:open_and_set_to_pending') ,'class="button blue"')."</div></li>";
								break;
							case 'complete':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/cancelled', shop_lang('shop:orders:mark_as_cancelled'),'class="button blue"')."</div></li>";
								break;
							case 'paid':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="button blue"')."</div></li>";
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/processing',shop_lang('shop:orders:mark_as_processing') ,'class="button blue"')."</div></li>";
								break;
							case 'shipped':
								$show_cancel = FALSE;
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/returned',shop_lang('shop:orders:mark_as_returned') ,'class="button blue"')."</div></li>";
								break;
							case 'returned':
								echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/shipped',shop_lang('shop:orders:mark_as_shipped') ,'class="button blue"')."</div></li>";
								break;																															
			
						}
						
						if ($show_cancel) {
							echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/cancelled', shop_lang('shop:orders:cancel_order'), 'class="button red delete"')."</div></li>";
						}
						if ($show_close) {
							echo "<li><div class='input'>".anchor('admin/shop/orders/setstatus/' . $order->id.'/closed',  shop_lang('shop:orders:close_order'), 'class="button red delete"')."</div></li>";
						}						
 
						?>				
				</ul>
			</fieldset>
		</div>		

	</div>
	
</div>
</section>
