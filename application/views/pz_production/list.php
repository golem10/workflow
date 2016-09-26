
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
					<div class="btn-group pull-right">
						<?php if(isset($access[7][5])){?>
							<button type="button" id="buttonEdit" class="btn btn-default" disabled><i class="fa fa-search"></i>&nbsp;Podgląd</button>							
						<?php }?>	
						<a href="<?php echo base_url("pz_production/pdfList"); ?>" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i>&nbsp; Drukuj</a>
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
						<th>Farby</th>						
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
						<th>Farby</th>		
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
		
      </div><!-- /.content-wrapper -->
	  
<div style="display:none">
 <?php echo form_open(base_url("pz_production/edit"),array('id' => 'editFormSend','method' => 'post'),array());?>
	<input type="hidden" name="id_edit" id="id_edit" class="form-control" />
	<input type="hidden" name="redirect"  class="form-control" value='1' />
  <?php echo form_close();?>
</div>

<script>
    $(function () {
        dTable = $("#dataTable").DataTable({
			"processing": true,
			"serverSide": true,
			"stateSave": true,
			"order": [[ 7, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
			"ajax": "<?php echo base_url("pz_production/getAllTable/");?>",
			"language": {
				"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
			},
			"columnDefs": [ {
			"targets": 8,
			"orderable": false
			} ]			
		});
		
		$( document ).ready( redrawTable() );
			
	});
	function redrawTable(){
		setTimeout(function(){
			dTable.destroy();
			dTable = $("#dataTable").DataTable( {
				"processing": true,
				"serverSide": true,
				"stateSave": true,
				"order": [[ 7, "asc" ],[ 3, "asc" ],[ 4, "asc" ]],
				"ajax": "<?php echo base_url("pz_production/getAllTable/");?>",
				"language": {
					"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
				},
				"columnDefs": [ {
				"targets": 8,
				"orderable": false
				} ]		
			});
			redrawTable();
		}, 60000);
			
	}
</script>
      