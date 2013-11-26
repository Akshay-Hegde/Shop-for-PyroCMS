				

				<fieldset>


				<div class="tabs">		

					<ul class="tab-menu">
						<li><a class=""  data-load="" href="#files-tab"><span><?php echo lang('shop:products:files'); ?></span></a></li>							
						<li><a class=""  data-load="" href="#pc-tab"><span><?php echo lang('shop:products:upload_from_computer'); ?></span></a></li>
					</ul>					
					<div class="form_inputs" id="files-tab">
						<fieldset>
							<ul>
								<li class="<?php echo alternator('', 'even'); ?>">
									<label for="folder">

										<?php echo lang('shop:products:import_from_files'); ?>
										<span>*</span> 
										<br />
										<small>
											<?php echo lang('shop:products:import_image_description'); ?>
										</small>
									</label>
									<div class="input">
										<?php echo form_dropdown('folder_id', $folders, $folder_id, 'id="folder_id" style="width:400px;"'); ?>
										
										<?php echo "<a href='#' id='load_folder' name='load_folder' style='display:none;'>Load</a>";  ?>

												<div id='img_view' style="overflow-y:scroll;min-height:50px;max-height:300px;">
													<!-- This is where the response from search folder images goes -->
												</div>
												<div id='img_actions' style="margin-top:12px">
													<!-- This is where the submit button to save the gallery goes -->
													<a href='#' class="btn gray"  id='btn_select_all_images'><?php echo lang('shop:products:select_all'); ?></a> 
													<a href='#' class="btn gray"  id='btn_select_none_images'><?php echo lang('shop:products:select_none'); ?></a> 
													<a href='#' class="btn orange"  id='btn_add_images' pid='<?php echo $id; ?>'><?php echo lang('shop:products:add_to_gallery'); ?></a>
												</div>	
			  
									</div>
								</li>				
							</ul>
						</fieldset>.
					</div>
					<div class="form_inputs" id="pc-tab">
						<fieldset>

						<ul>
							<li>
								<label for="">
									<?php echo lang('shop:products:upload_image'); ?>
									<span></span>
									<br />
									<small><?php echo lang('shop:products:upload_image_description'); ?></small>
								</label>
								<div class="input">		
									<?php echo lang('shop:products:you_must_select_an_upload_folder'); ?> <br />
									<?php  $_upload_folder = Settings::get('shop_upload_file_product');
									echo form_dropdown('upload_folder_id', $folders, $_upload_folder, 'id="upload_folder_id" style=""'); ?>	 <br />			
									<input type='file' name='fileupload_1' > <br />
									<input type='file' name='fileupload_2' > <br />
									<input type='file' name='fileupload_3' > <br />
									<input type='file' name='fileupload_4' > <br />								
								</div>
							</li>

						</ul>
						</fieldset>		
					</div>					
				</div>



				<?php
				/**
				 *
				 *
				 * Gallery Images
				 *
				 *
				 *
				 *
				 * 
				 */
				?>

				<ul>
					<li class="<?php echo alternator('', 'even'); ?>">
							<label for="">
								<?php echo lang('shop:products:gallery_images'); ?>
								<span></span>
								<br />
								<small>
									<?php echo lang('shop:products:gallery_images_description'); ?>
								</small>
							</label>
							<div class="input">

								<div id="scrollable_images_panel">
									<?php 
									
										if ($images) 
										{
											foreach ($images as $image) 
											{
													
												$dom_id = 'img_id_'.$image->file_id;
												$rem = lang('shop:products:remove');
												$cov = lang('shop:products:set_as_cover');

												echo "<div  class='tooltip-s container' id='$dom_id'>";
												echo "  <a title='$rem' class='img_icon img_delete remove_image gall_cover2' data-image='$image->file_id' data-parent='$dom_id'></a>";
												echo "  <a title='$cov' href='javascript:set_cover(\"$image->file_id\")'  class='tooltip-s img_icon img_home gall_cover3'></a>";
												echo "  <a href='admin/shop/images/admin_view/$image->file_id' class='modal img_icon img_view gall_cover4' data-image='$image->file_id' data-parent='$dom_id'></a>";
												echo "  <img large='".site_url()."files/thumb/$image->file_id/400' title='$image->name' class='tooltip-s' src='".site_url()."files/thumb/$image->file_id/100/100'>";
												echo "</div>";
											}
										}
										?>
								</div>  
	

							</div>
						</li>
				</ul>

				</fieldset>
		
	<script>

			//will set in the db
			$('#btn_add_images').click(function() {
				
				imgs = $('input:checkbox[name="images"]:checked').map(function() { return this.value; }).get();
				
				// Get the product ID
				pid = $('#btn_add_images').attr('pid');
				
				var senddata = { images:imgs, product_id:pid  };

				
				$.post('shop/admin/products/gallery_add/', senddata )

				.done(function(data) 
				{

					var obj = jQuery.parseJSON(data);

					//Uncheck the boxes
					$('input:checkbox[name="images"]:checked').removeAttr("checked"); // uncheck the checkbox or radio
				
					//show the image action buttons	
					var current_images = $('#scrollable_images_panel').html();	

					
					for (var i = 0; i < obj.added.length; i++) {

						//Generate a unique (ish) id for jQ to remove the image when needed
						dom_id = 'js_img_id_' + obj.added[i];
						
						current_images += "<div class='tooltip-s container' id='" + dom_id + "'>";
						current_images += "  <a title='" + obj.name + "' class='img_icon img_delete remove_image gall_cover2' data-image='"+obj.added[i]+"' data-parent='" + dom_id + "'></a>"
						current_images += "  <a title='" + obj.name + "' href='javascript:set_cover(\""+obj.added[i]+"\")'  class='tooltip-s img_icon img_home gall_cover3'></a>";
						current_images += "  <a href='admin/shop/images/admin_view/"+obj.added[i]+"' class='modal img_icon img_view gall_cover4'></a>";						
						current_images += "  <img title='" + obj.name + "' class='tooltip-s' src='" + obj.url + "files/thumb/" + obj.added[i] + "/100/100'>";
						current_images += "</div>";
					}
					
					$('#scrollable_images_panel').html(current_images);	

				});
				
				return false;
			
			});	 

				$('#load_folder').click(function() {
					
					/* Get the values to send to the server */
					f_id = $('#folder_id').val();

					var senddata = { folder_id:f_id  };
					
					$.post('shop/admin/images/get_folder_contents', senddata )

					.done(function(data) 
					{
						var obj = jQuery.parseJSON(data);
						
						str = '';
						for (var i = 0; i < obj.length; i++) 
						{
							
							var imgObj = obj.content[i];


							str += "<div class='gall_container'>";
							str += "   <img class='tooltip-s' title='" + imgObj.name + "' src='" + obj.url + 'files/thumb/' + imgObj.id + "/100/100' alt='' style='float:left'>";
							str += "   <input type='checkbox'  class='gall_checkbox' name='images' id='images' value='" + imgObj.id + "' />";
							str += "</div>";
						}

						$('#img_view').html(str);
						
					});
					
					return false;
				
				});	
				
				$("#folder_id").chosen().change(function() {
					
					$('#load_folder').click();

				});

				//Check all images
				$('#btn_select_all_images').click(function() {
		            
		            $('input:checkbox[name=images]').attr('checked', true);
		            
					return false;

				}); 

				//Check all images
				$('#btn_select_none_images').click(function() {
		            
		            $('input:checkbox[name=images]').attr('checked', false);

					return false;

				});   



				//
		        //
		        // Remove image from gallery
		        //
		        //
				//$('.remove_image').click(function() {
				$(".remove_image").live('click', function(e)  {					
					

		            img = $(this).attr('data-image');
		            var parent = $(this).attr('data-parent');               /*get the parent container id - this is what we remove*/  
		            var pid = $("#static_product_id").attr('data-pid');     /*get the product id*/
		            

		            $.post('shop/admin/products/gallery_remove', { image:img, product_id:pid  } ).done(function(data) 
		            {			
		                var obj = jQuery.parseJSON(data);
		                
		                if (obj.status == 'success') 
		                {
		                    $('#' + parent).remove();
		                }

		            });
		            
					return false;
				
				});		


				$(".popup_image").live('click', function(e)  {					
					

		            img_url = $(this).attr('large');
		            
					return false;
				
				});		


			</script>