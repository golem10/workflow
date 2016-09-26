

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $site_info['title']."<small>".$site_info['description']."</small>";?>
          </h1>
          <?php echo $breadcrumbs;?>
        </section>

        <!-- Main content -->
		<?php echo form_open($formAction,'post',array());?>
        <section class="content">
			<?php echo $msgBlock;?>
			<input type="hidden" name="id_priority" value="<?php echo $pz->id_pz ;?>" />
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
				  <!-- general form elements -->
				  <div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Ustal priorytet</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						
						<div class="form-group">
						  <select class="form-control" name="priority" >
								
								 <?php 
								for($i=1;$i<=10;$i++){ 
									echo "<option value='".$i."'";
									if($pz->priority == $i){
										echo "selected";
									}
									echo ">".$i."</option>";
								}?>	
							</select>
						</div>
					
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				
				
				
			</div>
			<div class="box-footer"> 
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>					
			</div>	
        </section><!-- /.content -->
		<?php echo form_close()?>
      </div><!-- /.content-wrapper -->

      