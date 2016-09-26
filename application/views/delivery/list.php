

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
						<a href="<?php echo base_url("delivery/pdfList"); ?>" class="btn btn-warning" target="_blank"><i class="fa fa-print"></i>&nbsp; Drukuj</a>
                  </div>
                </div><!-- /.box-header -->
                <div class="box-body">
                  <table id="dataTable" class="table table-bordered table-striped table-hover">
                    <thead>
                      <tr>
						<th>Farba</th>
                        <th>Ilość</th>
						<th>Jednostka</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php foreach($positions as $v){ ?>
						<tr>
							<td><?php echo $v->name;?></td>
							<td><?php echo $v->quantity;?></td>
							<td><?php echo $v->unit;?></td>
						</tr>
					<?php }  ?>
                    </tbody>
                    <tfoot>
                      <tr>
						<th>Farba</th>
                        <th>Ilość</th> 
						<th>Jednostka</th>
                      </tr>
                    </tfoot>
                  </table>
                </div><!-- /.box-body -->
              </div><!-- /.box -->

        </section><!-- /.content -->
      </div><!-- /.content-wrapper -->

<script>
    $(function () {
        dTable = $("#dataTable").DataTable( {			
			"order": [[ 1, "asc" ]],
			"language": {
				"url": "<?php echo base_url("plugins/datatables/polish.txt");?>"
			},			
		});
	});
</script>
      