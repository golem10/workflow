		<div class="modal modal-danger fade" id="deleteModalDialogConfirm">
		  <div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title"><i class="fa fa-warning"></i>&nbsp;Uwaga!</h4>
			  </div>
			  <div class="modal-body">
				<p>Czy na pewno chcesz anulować wybraną pozycję?</p>
			  </div>
			  <div class="modal-footer">
				<button type="button" class="btn btn-outline" data-dismiss="modal">Nie</button>
				<button type="button" class="btn btn-outline pull-left" id="deleteModalButtonYes"><i class="fa fa-trash"></i>&nbsp;Tak</button>
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
        <section class="content">
		 
          <div class="box">
                <div class="box-header">     
					<div class="btn-group pull-left">
                      <button type="button" class="btn btn-default"><?php echo $status_active['name'];?></button>
                      <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                        <span class="caret"></span>
                        <span class="sr-only">Toggle Dropdown</span>
                      </button>
                      <ul class="dropdown-menu" role="menu">
							<li><a href='<?php echo base_url("pz/index/3")?>'>Zrealizowane</a></li>
							<li><a href='<?php echo base_url("pz/index/2")?>'>Do realizacji</a></li>
							<li><a href='<?php echo base_url("pz/index/1")?>'>Do wypełnienia</a></li>
							<li><a href='<?php echo base_url("pz/index/4")?>'>Anulowane</a></li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url("pz");?>">Wszystkie</a></li>
                      </ul>
                    </div>
					<div class="btn-group pull-right">
					   
						<?php if(isset($access[6][2])){?>
							<button type="button" id="buttonEdit" class="btn btn-default" disabled><i class="fa fa-search"></i>&nbsp;Podgląd</button>
						<?php }?>	
						<?php if(isset($access[6][2])){?>
							<button type="button" id="buttonPriority" class="btn btn-default" disabled><i class="fa fa-arrows-v"></i>&nbsp;Priorytet</button>
						<?php }?>
						<?php if(isset($access[6][3])){?>
							<button type="button" id="buttonDelete" class="btn btn-default" data-toggle="modal" data-target="#deleteModalDialogConfirm" disabled><i class="fa fa-trash"></i>&nbsp;Anuluj</button>
						<?php }?>						
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width:1px"></th>
                        <th>Numer</th> 
						<th>Numer nadania</th>
						<th>Termin realizacji</th>
						<th>Godz. odbioru</th>
						<th>Data utworzenia</th>
						<th>Klient</th>
						<th>Priorytet</th>	
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
                        <th>Numer</th>  
						<th>Numer nadania</th>
						<th>Termin realizacji</th>
						<th>Godz. odbioru</th>
						<th>Data utworzenia</th>
						<th>Klient</th>
						<th>Priorytet</th>	
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
		
      </div><!-- /.content-wrapper -->
	  
<div style="display:none">
 <?php echo form_open(base_url("pz/edit"),array('id' => 'editFormSend','method' => 'post'),array());?>
	<input type="hidden" name="id_edit" id="id_edit" class="form-control" />
	<input type="hidden" name="redirect"  class="form-control" value='1' />
  <?php echo form_close();?>
   <?php echo form_open(base_url("pz/delete"),array('id' => 'deleteFormSend','method' => 'post'),array());?>
	<input type="text" name="id_delete" id="id_delete" class="form-control" />
  <?php echo form_close();?>
   <?php echo form_open(base_url("pz/changePriority"),array('id' => 'changePriorityFormSend','method' => 'post'),array());?>
	<input type="text" name="id_priority" id="id_priority" class="form-control" />
  <?php echo form_close();?>
</div>

<script>
    $(function () {
        dTable = $("#dataTable").DataTable( {
			"processing": true,
			"serverSide": true,
			"order": [[ 7, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
			"ajax": "<?php echo base_url("pz/getAllTable/".$status_active['id']);?>",
			"language": {
				"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
			}				
		});
				
	});
</script>
      