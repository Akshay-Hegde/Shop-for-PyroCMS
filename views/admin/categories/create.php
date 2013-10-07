<section class="title">
	<?php if (isset($id) AND $id > 0): ?>
		<h4><?php echo sprintf(shop_lang('shop:admin:edit'), $name); ?></h4>
	<?php else: ?>
		<h4><?php echo shop_lang('shop:admin:new');?></h4>
	<?php endif; ?>
</section>

<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
<?php if (isset($id) AND $id > 0): ?>
	<?php echo form_hidden('id', $id); ?>
<?php endif; ?>
<section class="item form_inputs">

	<div class="content">
		<fieldset>
			<ul>
				<li class="<?php echo alternator('even', ''); ?>">
					<label for="name"><?php echo shop_lang('shop:admin:name');?><span>*</span></label>
					<div class="input">
						<?php echo form_input('name', set_value('name', $name), 'id="name" '); ?>
					</div>
				</li>
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="slug"><?php echo shop_lang('shop:admin:slug');?><span>*</span></label>
					<div class="input"><?php echo form_input('slug', set_value('slug', $slug)); ?></div>
				</li>				  
				<li class="<?php echo alternator('', 'even'); ?>">
					<label for="cover">
						<?php echo lang('description'); ?>
					</label>			
					<div class="input">
							<?php echo form_textarea('description', set_value('description', isset($description)?$description:""), 'class="wysiwyg-simple"'); ?>
					</div>
				</li>   
			</ul>
		</fieldset>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel'))); ?>
		</div>
	
	</div>

</section>
<?php echo form_close(); ?>