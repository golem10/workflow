

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
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
					   
						<div class="box box-default">
						<div class="box-header with-border">
						  <h3 class="box-title">Dane farby</h3>
						</div><!-- /.box-header -->
						
						  <div class="box-body">					  
							<div class="form-group <?php echo (form_error('name')) ? "has-error" : ""; ?>">
							  <label for="inputName">Nazwa</label>
							  <input type="text" name="name" class="form-control" id="inputName" placeholder="Podaj nazwę" value="<?php  echo (set_value('name')) ? set_value('name') : $paint->name; ?>">
							  <?php if(isset($is_edit)) {?>
								<input type="hidden" name="id_edit" class="form-control" id="id_edit"  value="<?php  echo $paint->id_paint; ?>">
							  <?php }?>
							</div>
						  </div><!-- /.box-body -->					  
						<div class="box-footer"> 
							<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>											
							<a href="<?php echo base_url("definitions/paints");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
						</div>	
						</div><!-- /.box -->	
					  <!-- general form paints -->				  		  
					</div><!--/.col (left) -->
				</div>
			</section><!-- /.content -->			
		<?php echo form_close();?>
      </div><!-- /.content-wrapper -->

      