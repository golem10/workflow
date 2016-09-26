
	
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
				<input type="hidden" name="id_edit" class="form-control" id="id_edit"  value="<?php  echo $pz->id_pz; ?>">
				<div class="col-md-3">
				  <!-- general form elements -->
				  <div class="box box-warning">
					<div class="box-header with-border">
					  <h3 class="box-title">Informacje</h3>
					</div><!-- /.box-header -->
					<!-- form start -->
					  <div class="box-body form-horizontal">					  						
						<div class="form-group">
						  <label for="delivery_date" class="col-sm-4 control-label">Dostawa</label>
						  <div class="col-sm-8">							
								<input type="text" class="form-control" id="delivery_date" value="<?php echo $order->delivery_date;?>" disabled>								
						  </div>
						</div>
						<div class="form-group">
						  <label for="delivery_date" class="col-sm-4 control-label">Wystawiono</label>
						  <div class="col-sm-8">						  
							<input type="text" class="form-control" id="delivery_date" value="<?php echo $pz->date_add;?>" disabled >
						  </div>
						</div>
						<div class="form-group">
						  <label for="execution_date" class="col-sm-4 control-label">Termin</label>
						  <div class="col-sm-8">
							  <div class="input-group date"  data-provide="datepicker" data-date-format="yyyy-mm-dd">
								<input type="text" class="form-control" id="execution_date" value="<?php echo $pz->execution_date;?>" name="execution_date" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>
								<div class="input-group-addon">
									<span class="glyphicon glyphicon-calendar"></span>
								</div>
							  </div>
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
						  <textarea name="info" class="form-control" rows="3" placeholder="Uwagi..." <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  
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
							  <th>Ilość</th>
							  <th>J.m.</th>
							</tr>
							<?php if(isset($positions[0]->element_name) && isset($positions[0]->id_paint))
							{?>
							<tr>
							  <td>1.</td>
							  <td>							
								<?php if(isset($positions[0]->element_name)) echo $positions[0]->element_name;?>								
							  </td>
							  <td>							
								<?php foreach($paints as $k=>$v){ 
									if(isset($positions[0]->id_paint) && $v->id_paint == $positions[0]->id_paint){
										echo $v->name;
									}
								}?>	
								</select>
							  </td>
								<td>
								<input type="hidden" name="id_positions[]" value="<?php echo $positions[0]->id;?>">		
									<div class="form-group">										
									  <input type="text" name="quantity_<?php echo $positions[0]->id;?>" class="form-control" value="<?php echo $positions[0]->quantity;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>	
								<td>
									<div class="form-group">										
									  <input type="text" name="unit_<?php echo $positions[0]->id;?>" class="form-control" value="<?php echo $positions[0]->unit;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>																		
							</tr>
							<?php 
							}?>
							<?php if(isset($positions[1]->element_name) && isset($positions[1]->id_paint))
							{?>
							<tr>
							  <td>2.</td>
							  <td>								
								<?php if(isset($positions[1]->element_name)) echo $positions[1]->element_name;?>						
							  </td>
							  <td>								
								<?php foreach($paints as $k=>$v){ 							
									if(isset($positions[1]->id_paint) && $v->id_paint == $positions[1]->id_paint){
										echo $v->name;
									}
								}?>	
							  </td>	
								<td>
								<input type="hidden" name="id_positions[]" value="<?php echo $positions[1]->id;?>">		
									<div class="form-group">										
									  <input type="text" name="quantity_<?php echo $positions[1]->id;?>" class="form-control" value="<?php echo $positions[1]->quantity;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>> 						  									
									</div>	
								</td>	
								<td>
									<div class="form-group">										
									  <input type="text" name="unit_<?php echo $positions[1]->id;?>" class="form-control" value="<?php echo $positions[1]->unit;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>	
								
							</tr>
							<?php 
							}?>
							<?php if(isset($positions[2]->element_name) && isset($positions[2]->id_paint))
							{?>
							<tr>
							  <td>3.</td>
							  <td>
								<?php if(isset($positions[2]->element_name)) echo $positions[2]->element_name;?>	
								</select>
							  </td>
							  <td>
								<?php foreach($paints as $k=>$v){ 
									if(isset($positions[2]->id_paint) && $v->id_paint == $positions[2]->id_paint){
										echo $v->name;
									}
								}?>	
								</select>
							  </td>	
								<td>
								<input type="hidden" name="id_positions[]" value="<?php echo $positions[2]->id;?>">		
									<div class="form-group">										
									  <input type="text" name="quantity_<?php echo $positions[2]->id;?>" class="form-control" value="<?php echo $positions[2]->quantity;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>	
								<td>
									<div class="form-group">										
									  <input type="text" name="unit_<?php echo $positions[2]->id;?>" class="form-control" value="<?php echo $positions[2]->unit;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>	
														  
							</tr>
							<?php 
							}?>
						  </table>
					  </div>
				  </div>
				</div>
			</div>	
			<div class="row">
				<!-- left column -->
				<div class="col-md-12">
				  <!-- general form elements -->
				  <div class="box box-info">
					<div class="box-header with-border">
					  <h3 class="box-title">Osoby odpowiedzialne</h3>
					</div><!-- /.box-header -->
					<!-- form start -->					
					  <div class="box-body">
						<div class="col-md-3">
							<div class="form-group">
							  <label for="trawienie" class="col-sm-4 control-label">Trawienie</label>
							  <div class="col-sm-8">							
									<input type="text" class="form-control" id="trawienie" name="trawienie" value="<?php echo $pz->trawienie;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>								
							  </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							  <label for="szlifowanie" class="col-sm-4 control-label">Szlifowanie</label>
							  <div class="col-sm-8">							
									<input type="text" class="form-control" id="szlifowanie" name="szlifowanie" value="<?php echo $pz->szlifowanie;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>								
							  </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							  <label for="przygotowanie" class="col-sm-4 control-label">Przygotowanie</label>
							  <div class="col-sm-8">							 
									<input type="text" class="form-control" id="przygotowanie" name="przygotowanie" value="<?php echo $pz->przygotowanie;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>								
							  </div>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group">
							  <label for="zapakowanie" class="col-sm-4 control-label">Zapakowanie</label>
							  <div class="col-sm-8">							
									<input type="text" class="form-control" id="zapakowanie" name="zapakowanie" value="<?php echo $pz->zapakowanie;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>								
							  </div>
							</div>
						</div>
					  </div>
				  </div>
				</div>
			</div>	
			
			<div class="box-footer"> 				
				<a href="<?php echo base_url("pz_production");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
			</div>
			
		</section>
		
	  <?php echo form_close()?>	
      </div><!-- /.content-wrapper -->

      