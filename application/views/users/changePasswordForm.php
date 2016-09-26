

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
				  <!-- general form elements -->
				  <div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Dane konta</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						
						<div class="form-group <?php echo (form_error('password')) ? "has-error" : ""; ?>">
						  <label for="inputPassword">Hasło</label>
						  <input type="password" name="password" class="form-control" id="inputPassword" placeholder="Hasło">
						</div>
						<div class="form-group <?php echo (form_error('cnfpassword')) ? "has-error" : ""; ?>">
						  <label for="inputCnfPassword">Powtórz hasło</label>
						  <input type="password" name="cnfpassword" class="form-control" id="inputCnfPassword" placeholder="Powtórz hasło">
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

      