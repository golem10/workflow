

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
					  <h3 class="box-title">Dane konta</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						<?php if(isset($is_edit)) {?>
							<input type="hidden" name="id_edit" class="form-control" id="id_edit"  value="<?php  echo $user->id_user; ?>">
					    <?php }?>					  
						<div class="form-group">
						  <label for="inputFirstName">Imię</label>
						  <input type="text" name="first_name" class="form-control" id="inputFirstName" placeholder="Imię" value="<?php  echo (set_value('first_name')) ? set_value('first_name') : $user->first_name; ?>">
						</div>	
						<div class="form-group">
						  <label for="inputSecondName">Nazwisko</label>
						  <input type="text" name="second_name" class="form-control" id="inputSecondName" placeholder="Nazwisko" value="<?php  echo (set_value('second_name')) ? set_value('second_name') : $user->second_name; ?>">
						</div>
						<div class="form-group <?php echo (form_error('email')) ? "has-error" : ""; ?>">
						  <label for="inputEmail">Email address</label>
						  <input type="email" name="email" class="form-control" id="inputEmail" placeholder="Enter email" value="<?php  echo (set_value('email')) ? set_value('email') : $user->email; ?>" <?php echo (isset($is_edit)) ? "readonly" : "";?>>
						</div>
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
				
				<div class="col-md-6">
				  <!-- general form elements -->
				  <div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Grupy użytkowników</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body">					  
						<div class="form-group">
						  <label>Wybierz...  (CTRL+LPM aby wybrać więcej pozycji)</label>
						  <select multiple="" class="form-control" name="id_group[]" style="min-height:300px">
							<?php foreach($user_groups as $group) {
							echo "<option value='{$group->id_group}'";
							if(isset($group->id_user)){
								if($group->id_user){
									echo "selected";							
								}
							}
							echo" >{$group->name}</option>";
							
							} ?>
						  </select>
						</div>
						
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				
				
			</div>
			<div class="box-footer"> 
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>	
				<?php  if(isset($is_edit) && isset($access[2][4])) {?>
					<a href="<?php echo base_url("users/setPermissions/".$user->id_user);?>" class="btn btn-default"><i class="fa fa-check-square-o"></i>&nbsp;Ustal uprawnienia</a>
				<?php }  ?>		
				<a href="<?php echo base_url("users");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
			</div>	
        </section><!-- /.content -->
		<?php echo form_close()?>
      </div><!-- /.content-wrapper -->

      