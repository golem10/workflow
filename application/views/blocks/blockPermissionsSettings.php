<section class="content">
	<div class="row">
		<?php foreach($permissionsBlocksArray as $k_group=>$v_group){?>
			
				<div class="col-md-3">
				  <!-- general form elements -->
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title"><?php echo $v_group['name'];?></h3>
					</div><!-- /.box-header -->
					
					  <div class="box-body">					  
						<?php foreach($v_group['objects'] as $k_object=>$v_object){?>
						<div class="box-header with-border">
						  <h4 class="box-title"><?php echo $v_object['name'];?></h4>
						</div><!-- /.box-header -->
						<div class="box-body">			
							<?php foreach($v_object['actions'] as $k_action=>$v_action){?>					
								<div class="form-group">
									<label>
									 <input type='checkbox' id="checkbox_<?php echo $k_object."_".$k_action;?>" name='<?php echo $k_object;?>[]' class='flat-red list-select' value='<?php echo $k_action;?>'>&nbsp;&nbsp;
									 <?php echo $v_action['name'];?>
									</label>		
								</div>
							<?php
							}
							?>
						</div>
						<?php	
						}
						?>
					  </div><!-- /.box-body -->
					
				  </div><!-- /.box -->				  
				</div><!--/.col (left) -->
				
		<?php
		}
		?>
	</div>
</section>
<script>
$(function(){
	<?php foreach($permissionsArray as $value){?> 
	$("#checkbox_<?php echo $value->id_object."_".$value->id_action;?>").parent(".icheckbox_square-blue").find(".iCheck-helper").click();
	<?php
	}
	?>		
});
</script>