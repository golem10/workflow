
	<div class="modal modal-warning fade" id="modalDialogConfirm">
	  <div class="modal-dialog">
		<div class="modal-content">
		  <div class="modal-header">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			<h4 class="modal-title"><i class="fa fa-warning"></i>&nbsp;Uwaga!</h4>
		  </div>
		  <div class="modal-body">		
			<?php echo $modalTxt;?>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-outline" data-dismiss="modal">Anuluj</button>			
			<?php if($pz->id_status == 2) {?>
			<a href="<?php echo base_url("pz/toProduction/".$pz->id_pz."/1"); ?>" class="btn btn-outline pull-left"><i class="fa fa-file-o"></i>&nbsp;Paragon</a>
			<a href="<?php echo base_url("pz/toProduction/".$pz->id_pz."/2"); ?>" class="btn btn-outline pull-left"><i class="fa fa-building-o"></i>&nbsp;Faktura VAT</a>
			<?php } else{?>
				<button type="button" class="btn btn-outline pull-left" id="modalButtonYes"><i class="fa fa-check"></i>&nbsp;Tak</button>
			<?php } ?>
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
		<?php if($pz->id_status == 1) {
			echo form_open($formAction,'post',array());
		}
		?>
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
								<div class="input-group-addon" id="sendSmsDeadline" style="cursor:pointer" >
									<?php if(!$pz->id_sms_1){?>
									SMS
									<?php } else{ ?>
										Wysłano
									<?php }?>
								</div>
							  </div>
						  </div>
						</div>
						<div class="form-group">
						  <label for="delivery_date" class="col-sm-4 control-label">G. odbioru</label>
						  <div class="col-sm-8">						  
							<input type="text" class="form-control" id="hour_reception" value="<?php echo $pz->hour_reception;?>" name="hour_reception" <?php echo ($pz->id_status != 1) ? "disabled" : "";?> >
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
							  <th>Ilość farby [kg]</th>
							  <th>Cena</th>
							  <th>Wartość [ilość*cena]</th>
							</tr>
							<?php 
							$value = 0;
							if(isset($positions[0]->element_name) && isset($positions[0]->id_paint))
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
								<td>
									<div class="form-group">										
									  <input type="text" name="quantity_unit2_<?php echo $positions[0]->id;?>" class="form-control" value="<?php echo $positions[0]->quantity_unit2;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>		
								<td>
									<div class="form-group">										
									  <input type="text" name="price_<?php echo $positions[0]->id;?>" class="form-control" value="<?php echo $positions[0]->price;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>
								<td>
									<div class="form-group">										
									  <input type="text" value="<?php echo number_format(($positions[0]->price*$positions[0]->quantity), 2, '.', '');?>" class="form-control" disabled>						  									
									</div>
									<?php $value += number_format(($positions[0]->price*$positions[0]->quantity), 2, '.', '');?>
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
								<td>
									<div class="form-group">										
									  <input type="text" name="quantity_unit2_<?php echo $positions[1]->id;?>" class="form-control" value="<?php echo $positions[1]->quantity_unit2;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>
								<td>
									<div class="form-group">										
									  <input type="text" name="price_<?php echo $positions[1]->id;?>" class="form-control" value="<?php echo $positions[1]->price;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>
								<td>
									<div class="form-group">										
									  <input type="text" value="<?php echo number_format(($positions[1]->price*$positions[1]->quantity), 2, '.', '');?>" class="form-control" disabled>						  									
									</div>
									<?php $value += number_format(($positions[1]->price*$positions[1]->quantity), 2, '.', '');?>
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
								<td>
									<div class="form-group">										
									  <input type="text" name="quantity_unit2_<?php echo $positions[2]->id;?>" class="form-control" value="<?php echo $positions[2]->quantity_unit2;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>		
								<td>
									<div class="form-group">										
									  <input type="text" name="price_<?php echo $positions[2]->id;?>" class="form-control" value="<?php echo $positions[2]->price;?>" <?php echo ($pz->id_status != 1) ? "disabled" : "";?>>						  									
									</div>	
								</td>
								<td>
									<div class="form-group">										
									  <input type="text" value="<?php echo number_format(($positions[2]->price*$positions[2]->quantity), 2, '.', '');?>" class="form-control" disabled>						  									
									</div>	
									<?php $value += number_format(($positions[2]->price*$positions[2]->quantity), 2, '.', '');?>
								</td>							  
							</tr>
							<?php 
							}?>
							<tr>
							  <th style="width: 10px"></th>
							  <th></th>
							  <th></th>
							  <th></th>
							  <th></th>
							  <th></th>
							  <th></th>
							  <th><?php echo "Suma: ".number_format($value, 2, '.', '');;?></th>
							</tr>
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
			<?php  if(isset($access[6][2]) && $pz->id_status == 3){ 
				echo form_open(base_url('pz/updateBill/'),'post',array());
				?>
				<div class="row">
					<!-- left column -->
					<div class="col-md-12">
					  <!-- general form elements -->
					  <div class="box box-default">
						<div class="box-header with-border">
						  <h3 class="box-title">Informacje rachunkowe</h3>
						</div><!-- /.box-header -->
						<!-- form start -->					
						  <div class="box-body">
						  <input type="hidden" value="<?php echo $pz->id_pz;?>" name="id_pz">
							<div class="col-md-3">
								<div class="form-group">
								  <label for="" class="col-sm-6 control-label">Rodzaj rachunku:</label>
								  <div class="col-sm-6">							
										<?php echo ($pz->bill_type == 1) ? "Paragon" : "Faktura VAT";?>							
								  </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								  <label for="bill_number" class="col-sm-6 control-label">Nr paragonu/FV:</label>
								  <div class="col-sm-6">							
										<input type="text" class="form-control" id="bill_number" name="bill_number" value="<?php echo $pz->bill_number;?>">								
								  </div>
								</div>
							</div>
							<div class="col-md-3">
								<div class="form-group">
								  <label for="bill_value" class="col-sm-6 control-label">Kwota [pln]:</label>
								  <div class="col-sm-6">							
										<input type="text" class="form-control" id="bill_value" name="bill_value" value="<?php echo $pz->bill_value;?>" >					
								  </div>
								</div>
							</div>
							<div class="col-md-3">
								<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>
							</div>
						  </div>
					   </div>
					</div>
				</div>				
				<?php 
				echo form_close();
			}
			?>
			<div class="box-footer"> 
				<?php if($pz->id_status == 1) { ?>
				<button type="submit" class="btn btn-primary"><i class="fa fa-save"></i>&nbsp;Zapisz</button>
				<?php } 
				if(isset($access[6][2])){
					if($pz->id_status == 1) {
				?>
				<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDialogConfirm"><i class="fa fa-building"></i>&nbsp;Przekaż do realizacji</button>
				<?php 
					}
					elseif($pz->id_status == 2) {?>
						<button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalDialogConfirm"><i class="fa fa-building"></i>&nbsp;Oznacz jako zrealizowane</button>
				<?php	}
					else { 
						 if(!$pz->id_sms_2){?>					
							<button type="button" class="btn btn-success" id="sendSmsDone"><i class="fa fa-send"></i>&nbsp;Wyślij wiadomość SMS</button>
						<?php }
							else{ ?>
							<button type="button" class="btn btn-success" disabled><i class="fa fa-send"></i>&nbsp;Wiadomość SMS wysłano</button>
						<?php }
						}
				} ?>
				<div class="btn-group">
                      <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><i class="fa fa-print"></i>&nbsp; Drukuj <span class="fa fa-caret-down"></span></button>
                      <ul class="dropdown-menu">
                        <li><a href="<?php echo base_url('pdf/index/0/0/1/'.$pz->id_pz);?>" target="_blank">Zamówienie</a></li>
                        <li><a href="<?php echo base_url('pdf/index/1/0/0/'.$pz->id_pz);?>" target="_blank">Druk PZ</a></li>
                        <li><a href="<?php echo base_url('pdf/index/0/1/0/'.$pz->id_pz);?>" target="_blank">Druk PZ - Kopia</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url('pdf/index/1/1/1/'.$pz->id_pz);?>" target="_blank">Wszystkie</a></li>
                      </ul>
                    </div>		
				<a href="<?php echo base_url("pz");?>" class="btn btn-default pull-right"><i class="fa fa-arrow-left"></i>&nbsp;Powrót</a>
			</div>
			<br/><br/><br/><br/><br/>
		</section>
	  <?php if($pz->id_status == 1) {
		echo form_close();
	  } ?>	
      </div><!-- /.content-wrapper -->
  <?php echo form_open(base_url("pz/toProduction"),array('id' => 'formSend','method' => 'post'),array());?>
	<input type="hidden" name="id_pz" id="id_pz" class="form-control" value="<?php  echo $pz->id_pz; ?>" />
  <?php echo form_close();?>
 <script>
	$(function() 
	{	
		<?php if(!$pz->id_sms_1){
			$msg = "Twoje zamowienie nr:".$order->number." bedzie gotowe do odbioru ".$pz->execution_date;
			?>
		$("#sendSmsDeadline").click(function(){
			if($("#sendSmsDeadline").attr('rel') != 1){
				$.ajax({ url:"<?php echo "http://api.smsapi.pl/sms.do?username=infornet&password=615c9eb60b526860e54fb661e008f4f0&eco=0&from=ELIZAB-STAL&to=".$customer->phone."&message=".$msg;?>", cache: false});
				$.ajax({ url:"<?php echo base_url("pz/addSms/1/".$pz->id_pz)?>", cache: false});
				$("#sendSmsDeadline").html("Wysłano");
				$("#sendSmsDeadline").attr("rel",1);
			}
		});
		<?php }?>
		<?php if(!$pz->id_sms_2){
			$msg = "Twoje zamowienie nr:".$order->number." jest już zrealizowane. Zapraszamy do jego odebrania.";
			?>
		$("#sendSmsDone").click(function(){
			if($("#sendSmsDone").attr('rel') != 1){
				$.ajax({ url:"<?php echo "http://api.smsapi.pl/sms.do?username=infornet&password=615c9eb60b526860e54fb661e008f4f0&eco=0&from=ELIZAB-STAL&to=".$customer->phone."&message=".$msg;?>", cache: false});
				$.ajax({ url:"<?php echo base_url("pz/addSms/2/".$pz->id_pz)?>", cache: false});
				$("#sendSmsDone").attr("rel",1);
				$("#sendSmsDone").attr("disabled","disabled");
			}
		});
		<?php }?>
	});
	</script>     