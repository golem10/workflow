

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
				<div class="col-md-6">
				  <!-- general form elements -->
				  <div class="box box-primary">
					<div class="box-header with-border">
					  <h3 class="box-title">Dane klienta</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						<?php if(isset($is_edit)) {?>
							<input type="hidden" name="id_edit" class="form-control" id="id_edit"  value="<?php  echo $customer->id_customer; ?>">
					    <?php }?>					  
						<div class="form-group">
						  <label for="inputName">Nazwa</label>
						  <input type="text" name="name" class="form-control" id="inputName" placeholder="Nazwa" value="<?php  echo (set_value('name')) ? set_value('name') : $customer->name; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputNip">NIP</label>
						  <input type="text" name="nip" class="form-control" id="inputNip" placeholder="NIP" value="<?php  echo (set_value('nip')) ? set_value('nip') : $customer->nip; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputEmail">E-mail</label>
						  <input type="text" name="email" class="form-control" id="inputEmail" placeholder="E-mail" value="<?php  echo (set_value('email')) ? set_value('email') : $customer->email; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputPhone">Nr telefonu</label>
						  <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="Nr telefonu" value="<?php  echo (set_value('phone')) ? set_value('phone') : $customer->phone; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputPerson">Osoba do kontaktu</label>
						  <input type="text" name="person" class="form-control" id="inputPerson" placeholder="Osoba do kontaktu" value="<?php  echo (set_value('person')) ? set_value('person') : $customer->person; ?>">
						</div>	
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				
				<div class="col-md-6">
				  <!-- general form elements -->
				  <div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Dane adresowe</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body">	
						<div class="form-group">
						  <label for="inputPostCode">Kod pocztowy</label>
						  <input type="text" name="post_code" class="form-control" id="inputPostCode" placeholder="Kod pocztowy" value="<?php  echo (set_value('post_code')) ? set_value('post_code') : $customer->post_code; ?>">
						</div>		
						<div class="form-group">
						  <label for="inputCity">Miejscowość</label>
						  <input type="text" name="city" class="form-control" id="inputCity" placeholder="Miejscowość" value="<?php  echo (set_value('city')) ? set_value('city') : $customer->city; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputStreet">Ulica</label>
						  <input type="text" name="street" class="form-control" id="inputStreet" placeholder="Ulica" value="<?php  echo (set_value('street')) ? set_value('street') : $customer->street; ?>">
						</div>
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				
				
			</div>
			<div class="box-footer"> 
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>		
				<a href="<?php if($isOrder) echo base_url("customers/selectCustomer"); else echo base_url("customers");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
			</div>	
        </section><!-- /.content -->
		<?php echo form_close()?>
      </div><!-- /.content-wrapper -->

      