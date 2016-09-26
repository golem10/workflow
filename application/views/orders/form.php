
	<div class="modal modal-warning fade" id="modalDialogConfirm">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><i class="fa fa-warning"></i>&nbsp;Uwaga!</h4>
		  </div>
		  <div class="modal-body">
			<p>Przed wygenerowaniem druku należy zapisać zamówienie.</p>
			<p>Wygenerowanie druku PZ uniemożliwi dalszą edycję zamówienia.</p>
			<p>Czy na pewno chcesz wygenerować druk PZ?</p>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-outline" data-dismiss="modal">Anuluj</button>
			<button type="button" class="btn btn-outline pull-left" id="modalButtonYes"><i class="fa fa-check"></i>&nbsp;Tak</button>
		  </div>
		</div><!-- /.modal-content -->
	  </div><!-- /.modal-dialog -->
	</div><!-- /.modal -->
	
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
					  <h3 class="box-title">Klient</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						<dl class="dl-horizontal">
							<dt>Nazwa</dt>
							<dd><?php echo $customer->name;?></dd>
							<dt>NIP</dt>
							<dd><?php echo $customer->nip;?></dd>
							<dt>Adres</dt>
							<dd><?php echo $customer->post_code." ".$customer->city."<br/>".$customer->street;?></dd>							
							<dt>Adres e-mail</dt>
							<dd><?php echo $customer->email;?></dd>
							<dt>Nr telefonu</dt>
							<dd><?php echo $customer->phone;?></dd>
							<dt>Osoba do kontatku</dt>
							<dd><?php echo $customer->person;?></dd>
						  </dl>			
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				<input type="hidden" name="id_edit" class="form-control" id="id_edit"  value="<?php  echo $order->id_order; ?>">
				<div class="col-md-3">
				  <!-- general form elements -->
				  <div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Informacje</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body form-horizontal">					  
						<div class="form-group">
						  <label for="id_status" class="col-sm-2 control-label">Status</label>
						  <div class="col-sm-10">
							<select class="form-control"  id="id_status" name="id_status" <?php echo ($order->id_pz) ? "disabled" : "";?>>
							<?php foreach($statuses as $k=>$v){ 
								echo "<option value='".$v->id_status."'";
								if($v->id_status == $order->id_status){
									echo "selected";
								}
								echo ">".$v->name."</option>";
							}?>	
							</select>
						  </div>
						</div>
						<div class="form-group">
						  <label for="delivery_date" class="col-sm-2 control-label">Dostawa</label>
						  <div class="col-sm-10">
							  <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" id="delivery_date" value="<?php echo $order->delivery_date;?>" name="delivery_date" <?php echo ($order->id_pz) ? "disabled" : "";?>>
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="consecutive_number" class="col-sm-2 control-label">Numer nadania</label>
						  <div class="col-sm-10">							  
								<input type="text" class="form-control" id="consecutive_number" value="<?php echo $order->consecutive_number;?>" name="consecutive_number" <?php echo ($order->id_pz) ? "disabled" : "";?>>
						  </div>
						</div>
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				<div class="col-md-3">
				  <!-- general form elements -->
				  <div class="box box-success">
					<div class="box-header with-border">
					  <h3 class="box-title">Uwagi</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body">	
						<div class="form-group">
						  <textarea name="info" class="form-control" rows="3" placeholder="Uwagi..." <?php echo ($order->id_pz) ? "disabled" : "";?>>						  
							<?php echo trim($order->info);?>
						  </textarea>
						</div>					  						
						
					  </div><!-- /.box-body -->
				  </div><!-- /.box -->				  
				</div>
				
			</div>		
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
				  <!-- general form elements -->
				  <div class="box box-danger">
					<div class="box-header with-border">
					  <h3 class="box-title">Elementy zamówienia</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						 <table class="table table-striped">
							<tr>
							  <th style="width: 10px">#</th>
							  <th>Element</th>
							  <th>Kolor</th>
							</tr>
							<tr>
							  <td>1.</td>
							  <td>
								<input type="text" value="<?php if(isset($positions[0]->element_name)) echo $positions[0]->element_name;?>" class="form-control" name="element_name[]" <?php echo ($order->id_pz) ? "disabled" : "";?> maxlength="100"/>								
							  </td>
							  <td>
								<select class="form-control" name="id_paint[]" <?php echo ($order->id_pz) ? "disabled" : "";?>>
								<option value="0">Wybierz farbę</option>
								<?php foreach($paints as $k=>$v){ 
									echo "<option value='".$v->id_paint."'";
									if(isset($positions[0]->id_paint) && $v->id_paint == $positions[0]->id_paint){
										echo "selected";
									}
									echo ">".$v->name."</option>";
								}?>	
								</select>
							  </td>							 
							</tr>
							<tr>
							  <td>2.</td>
							  <td>
								<input type="text" value="<?php if(isset($positions[1]->element_name)) echo $positions[1]->element_name;?>" class="form-control" name="element_name[]" <?php echo ($order->id_pz) ? "disabled" : "";?>  maxlength="100"/>
							  </td>
							  <td>
								<select class="form-control" name="id_paint[]" <?php echo ($order->id_pz) ? "disabled" : "";?>>
								<option value="0">Wybierz farbę</option>
								<?php foreach($paints as $k=>$v){ 
									echo "<option value='".$v->id_paint."'";
									if(isset($positions[1]->id_paint) && $v->id_paint == $positions[1]->id_paint){
										echo "selected";
									}
									echo ">".$v->name."</option>";
								}?>	
								</select>
							  </td>							 
							</tr>
							<tr>
							  <td>3.</td>
							  <td>
								<input type="text" value="<?php if(isset($positions[2]->element_name)) echo $positions[2]->element_name;?>" class="form-control" name="element_name[]" <?php echo ($order->id_pz) ? "disabled" : "";?>  maxlength="100"/>
							  </td>
							  <td>
								<select class="form-control" name="id_paint[]" <?php echo ($order->id_pz) ? "disabled" : "";?>>
								<option value="0">Wybierz farbę</option>
								<?php foreach($paints as $k=>$v){ 
									echo "<option value='".$v->id_paint."'";
									if(isset($positions[2]->id_paint) && $v->id_paint == $positions[2]->id_paint){
										echo "selected";
									}
									echo ">".$v->name."</option>";
								}?>	
								</select>
							  </td>							 
							</tr>
						  </table>
					  </div>
				  </div>
				</div>
			</div>	
			
			<div class="box-footer"> 
				<?php if(!$order->id_pz) { ?>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>	
				<?php if(isset($access[6][1])){?>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDialogConfirm"><i class="fa fa-building"></i>&nbsp;Generuj PZ</button>
				<?php } ?>
				<a href="<?php echo base_url("orders");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
				<?php
				}else{?>					
					<?php if(isset($access[6][2])){?>
					<a href="<?php echo base_url("pz/edit/".$order->id_pz);?>" class="btn btn-primary"><i class="fa fa-building"></i>&nbsp;Zobacz PZ</a>
					<?php }	?>
					<a href="<?php echo base_url('pdf/index/0/0/1/'.$order->id_pz);?>" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i>&nbsp;Drukuj</a>
					<a href="<?php echo base_url("orders");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
				<?php 
				}?>
			</div>
			
		</section>
		
	  <?php echo form_close()?>	
      </div><!-- /.content-wrapper -->
<?php echo form_open(base_url("pz/generatePZ"),array('id' => 'formSend','method' => 'post'),array());?>
	<input type="hidden" name="id_order" id="id_order" class="form-control" value="<?php  echo $order->id_order; ?>" />
  <?php echo form_close();?>
      