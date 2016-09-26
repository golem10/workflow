

      <!-- Content Wrapper. Contains page content -->
      <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $site_info['title']."<small>".$site_info['description']."</small>";?>
          </h1>
          <?php echo $breadcrumbs;?>
        </section>
		<section class="content" style="min-height:0px">
		<?php echo $msgBlock;?>
		<div class="callout callout-warning">
			<h4>Uwaga!</h4>
			<p>Zmiana uprawnień dla grup przypisanych do użytkowników spowoduje zresetowanie uprawnień ustalonych indywidualnie dla użytkowników edytowanej grupy.</p>
		  </div>
		</section> 
        <!-- Main content -->
		<?php echo form_open($formAction,'post',array());?>			
			<?php echo $blockPermissionsSettings;?>
			<section class="content">
				<div class="box-footer"> 
					<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>
					<a href="<?php echo base_url("usersGroups");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
				</div>	
			</section>
		<?php echo form_close();?>
      </div><!-- /.content-wrapper -->

      