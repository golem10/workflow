

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
							<button type="button" id="buttonEdit" class="btn btn-success" disabled><i class="fa fa-check"></i>&nbsp;Wybierz klienta</button>
					    <?php if(isset($access[3][1])){?>
							<a href="<?php echo base_url('customers/add/1');?>" class="btn btn-default"><i class="fa fa-plus"></i>&nbsp;Dodaj</a>
						<?php }?>				
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
                        <th style="width:1px"></th>
						<th>Nazwa</th>
						<th>E-mail</th>
                        <th>Osoba kontaktowa</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                      
                    </tbody>
                    <tfoot>
                      <tr>
                        <th></th>
						<th>Nazwa</th>
						<th>E-mail</th>
                        <th>Osoba kontaktowa</th>                                     
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->
<div style="display:none">
 <?php echo form_open(base_url("orders/add"),array('id' => 'editFormSend','method' => 'post'),array());?>
	<input type="hidden" name="id_edit" id="id_edit" class="form-control" />
	<input type="hidden" name="redirect"  class="form-control" value='1' />
  <?php echo form_close();?>

</div>
<script>
    $(function () {
        dTable = $("#dataTable").DataTable( {
			"processing": true,
			"serverSide": true,
			"order": [[ 1, "asc" ]],
			"ajax": "<?php echo base_url("customers/getAllTable");?>",
			"language": {
				"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
			},			
		});
	});
</script>
      